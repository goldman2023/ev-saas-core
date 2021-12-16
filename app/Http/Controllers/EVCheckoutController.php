<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class EVCheckoutController extends Controller
{
    public function index(Request $request) {
        $cart_items = CartService::getItems();
        $total_items_count = CartService::getTotalItemsCount();

        $originalPrice = CartService::getOriginalPrice();
        $discountedAmount = CartService::getDiscountedAmount();
        $subtotalPrice = CartService::getSubtotalPrice();

        return view('frontend.checkout', compact('cart_items','total_items_count','originalPrice','discountedAmount','subtotalPrice'));
    }

    public function store(Request $request)
    {
        $cart_items = CartService::getItems();
        $total_items_count = CartService::getTotalItemsCount();

        // Check if there are items in cart
        if($total_items_count <= 0) {
            // Should redirect to empty cart page
            return redirect('cart');
        }

        $originalPrice = CartService::getOriginalPrice();
        $discountAmount = CartService::getDiscountedAmount();
        $subtotalPrice = CartService::getSubtotalPrice();

        $same_billing_shipping = !empty($request->input('same_billing_shipping'));
        $subscribe_newsletter = !empty($request->input('newsletter'));

        $data_to_validate = [
            'email' => 'required|email:rfc,dns',
            'billing_first_name' => 'required|min:3',
            'billing_last_name' => 'required|min:3',
            'billing_company' => 'nullable',
            'billing_address' => 'required|min:5',
            'billing_country' => ['required', Rule::in(\Countries::getCodesAll(true))],
            'billing_state' => 'nullable',
            'billing_city' => 'required|min:3',
            'billing_zip' => 'required|min:2',
            'phone_numbers' => 'array|required', // TODO: Consider changing this to phone_number.* in order to specify which phone number is not valid
            'payment_method' => ['required', Rule::in(\App\Models\PaymentMethodUniversal::$available_gateways)],
            'note' => 'nullable',
            'same_billing_shipping' => 'nullable',
            'newsletter' => 'nullable'
        ];

        if(empty($request->input('same_billing_shipping'))) {
            $data_to_validate = array_merge($data_to_validate, [
                'shipping_first_name' => 'required|min:3',
                'shipping_last_name' => 'required|min:3',
                'shipping_company' => 'nullable',
                'shipping_address' => 'required|min:5',
                'shipping_country' => ['required', Rule::in(\Countries::getCodesAll(true))],
                'shipping_state' => 'nullable',
                'shipping_city' => 'required|min:3',
                'shipping_zip' => 'required|min:2',
            ]);
        }

        $validator = Validator::make($request->all(), $data_to_validate);

        if ($validator->fails()) {
            session()->flashInput($request->input()); // needed in order to use $request()->old('{input_name}')
            return view('frontend.checkout', compact('cart_items','total_items_count','originalPrice','discountAmount','subtotalPrice'))
                ->withErrors($validator);
        }

        // Retrieve the validated input...
        $data = $validator->validated();

        DB::beginTransaction();

        try {
            // Save Order and order items
            $order = new Order();
            $order->shop_id = \CartService::getShop(true);
            $order->user_id = auth()->user()->id ?? null;
            $order->email = $data['email'];
            $order->billing_first_name = $data['billing_first_name'];
            $order->billing_last_name = $data['billing_last_name'];
            $order->billing_company = $data['billing_company'];
            $order->billing_address = $data['billing_address'];
            $order->billing_country = $data['billing_country'];
            $order->billing_state = empty($data['billing_state']) ? $data['billing_country'] : $data['billing_state'];
            $order->billing_city = $data['billing_city'];
            $order->billing_zip = $data['billing_zip'];

            $order->phone_numbers = array_values(array_filter($data['phone_numbers']));
            $order->same_billing_shipping = $same_billing_shipping;

            if(!$same_billing_shipping) {
                $order->shipping_first_name = $data['shipping_first_name'];
                $order->shipping_last_name = $data['shipping_last_name'];
                $order->shipping_company = $data['shipping_company'];
                $order->shipping_address = $data['shipping_address'];
                $order->shipping_country = $data['shipping_country'];
                $order->shipping_state = empty($data['shipping_state']) ? $data['shipping_country'] : $data['shipping_state'];
                $order->shipping_city = $data['shipping_city'];
                $order->shipping_zip = $data['shipping_zip'];
            }

            $order->base_price = $originalPrice['raw'];
            $order->discount_amount = $discountAmount['raw'];
            $order->subtotal_price = $subtotalPrice['raw'];
            $order->total_price = $subtotalPrice['raw']; // TODO: This should be totalPrice (with taxes and stuff...but since we don't have Tax system working, let it stay like this for now)

            $order->shipping_method = 'free'; // TODO: Change this to use shipping methods and calculations when the shipping logic is added in BE
            $order->shipping_cost = 0;
            $order->tax = 0; // TODO: Change this to use Taxes from DB (Create Tax logic in BE first)

            $order->payment_method = $data['payment_method'];
            $order->note = $data['note'];

            // payment_status - `unpaid` by default (this should be changed on payment processor callback before Thank you page is shown - if payment goes through of course)
            // shipping_status - `not_sent` by default (this is changed manually in Order management pages by company staff)
            // viewed - is 0 by default (if it's not viewed by company stuff, it'll be marked as `New` in company dashboard)
            $order->save();

            // Save Order items
            foreach($cart_items as $item) {
                // Check if there are enough items in stock for each item
                // TODO: Checking if there are enough items in stock should be done before creating an order and by locking the table (maybe).
                if($item->current_stock >= $item->purchase_quantity) {
                    $order_item = new OrderItem();
                    $order_item->order_id = $order->id;
                    $order_item->subject_type = $item::class;
                    $order_item->subject_id = $item->id;
                    $order_item->title = method_exists($item, 'hasMain') && $item->hasMain() ? $item->main->name : $item->name; // TODO: Think about changing Product `name` col to `title`, it's more universal!
                    $order_item->excerpt = method_exists($item, 'hasMain') && $item->hasMain() ? $item->main->excerpt : $item->excerpt;
                    $order_item->variant = method_exists($item, 'hasMain') && $item->hasMain() ? $item->getVariantName(key_by: 'name') : null;
                    $order_item->quantity = $item->purchase_quantity;

                    // Reduce the stock quantity of an $item
                    $data = $item->reduceStock();

                    if($item->use_serial) {
                        $order_item->serial_numbers = $data; // reduceStockBy returns serial numbers in array if $item uses serials
                    }

                    $order_item->base_price = $item->base_price;
                    $order_item->discount_amount = ($item->base_price - $item->total_price);
                    $order_item->subtotal_price = $item->total_price; // TODO: This should use subtotal_price instead of total_price
                    $order_item->total_price = $item->total_price;
                    $order_item->tax = 0; // TODO: Think about what to do with this one (But first create Tax BE Logic)!!!

                    $order_item->save();
                }
            }

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e->getMessage()); // TODO: Find a better way to display messages on FE!
        }


        // TODO: Check if newsletter is checked and based on that add email to mailing list (CRM)
        // $subscribe_newsletter

//        if($data['payment_method'] === 'wire_transfer') {
//            // TODO: Add different payment methods checkout flows here (going to payment gateway page with callback URL for payment_status change route)
//        }

        // Full Cart reset (with resetting session cart data)
        \CartService::fullCartReset();

        return redirect()->route('checkout.order-received', $order);
    }

    public function orderReceived(Request $request, Order $order)
    {
        if(auth()->user()->id ?? null) {
            // Redirect user to proper Order Details page
        } else {
            // Redirect non-logged user to order-received (like Thank you page)
        }

        return view('frontend.order-received', compact('order'));
    }
}
