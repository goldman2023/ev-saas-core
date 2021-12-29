<?php

namespace App\Http\Controllers;

use App\Http\Services\PaymentMethods\PayseraGateway;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethodUniversal;
use App\Models\User;
use CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class EVCheckoutController extends Controller
{
    public function index(Request $request) {
        $cart_items = CartService::getItems();
        $total_items_count = CartService::getTotalItemsCount();

        $originalPrice = CartService::getOriginalPrice();
        $discountAmount = CartService::getdiscountAmount();
        $subtotalPrice = CartService::getSubtotalPrice();

        return view('frontend.checkout', compact('cart_items','total_items_count','originalPrice','discountAmount','subtotalPrice'));
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
        $discountAmount = CartService::getdiscountAmount();
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

        // If billing and shipping address are not the same
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


        // Validate password again
        // If user is not logged in and `create account` is set to TRUE
        $new_user = User::where('email', $data['email'])->first();
        if(empty(auth()->user()->id ?? null) && $request->input('create_account') === 'on') {
            // Check if user with email is not already registered user.

            if($new_user instanceof User && !empty($new_user->id ?? null)) {
                // Registered user
                $account_password_rules = 'match_password:App\Models\User,email';
            } else {
                // Not registered user
                $account_password_rules = 'required|confirmed|min:6';
            }

            if (($password_validator = Validator::make($request->all(), [
                'account_password' => $account_password_rules,
            ], [
                'account_password.match_password' => translate('Password is not correct for a given email. If you want to create an order under provided email, you have to know password of the user under given email. If you don\'t know, either use Forgot password or create another account. under different email.')
            ]))->fails()) {
                session()->flashInput($request->input()); // needed in order to use $request()->old('{input_name}')
                return view('frontend.checkout', compact('cart_items','total_items_count','originalPrice','discountAmount','subtotalPrice'))
                    ->withErrors($password_validator);
            }

            $password_data = $password_validator->validated();
        }


        DB::beginTransaction();

        $payment_method = PaymentMethodUniversal::where('gateway', $data['payment_method'])->first();

        $phone_numbers = array_values(array_filter($data['phone_numbers']));
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

            $order->phone_numbers = $phone_numbers;
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

            $order->payment_method_type = PaymentMethodUniversal::class;
            $order->payment_method_id = $payment_method->id ?? null; // TODO: Change this to use ID

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
                    $serial_numbers = $item->reduceStock();

                    // Serial Numbers only work for Simple Products. TODO: Make Product Variations support serial numbers!
                    if($item->use_serial) {
                        $order_item->serial_numbers = $serial_numbers; // reduceStockBy returns serial numbers in array if $item uses serials
                    }

                    $order_item->base_price = $item->base_price;
                    $order_item->discount_amount = ($item->base_price - $item->total_price);
                    $order_item->subtotal_price = $item->total_price; // TODO: This should use subtotal_price instead of total_price
                    $order_item->total_price = $item->total_price;
                    $order_item->tax = 0; // TODO: Think about what to do with this one (But first create Tax BE Logic)!!!

                    $order_item->save();
                }
            }


            // If user is not logged in and `create account` is set to TRUE - Create account if it doesn't exist
            if(empty(auth()->user()->id ?? null) && $request->input('create_account') === 'on') {
                if(!empty($new_user->id ?? null) && Hash::check($data['account_password'], $new_user->password)) { // check password again just in case
                    // There is a user under given Email AND passwords match -> LOG IN USER
                    auth()->login($new_user, true); // log the user in
                } else {
                    // Create user 'cuz there's no user under this email and password validation passed

                    // TODO: Move to some RegistrationService or something so we can reuse it throughout the app!

                    // Create user
                    $new_user = User::create([
                        'name' => $data['billing_first_name'].' '.$data['billing_last_name'],
                        'user_type' => User::$customer_type,
                        'email' => $data['email'],
                        'password' => bcrypt($password_data['account_password'])
                    ]);


                    // Create address
                    $address_billing = Address::create([
                        'user_id' => $new_user->id,
                        'address' => $data['billing_address'],
                        'address_2' => '',
                        'country' => $data['billing_country'],
                        'state' => empty($data['billing_state']) ? $data['billing_country'] : $data['billing_state'],
                        'city' => $data['billing_city'],
                        'zip_code' => $data['billing_zip'],
                        'phones' => $phone_numbers,
                        'set_default' => 1
                    ]);

                    if(!$same_billing_shipping) {
                        // Create another address with shipping info
                        $address_shipping = Address::create([
                            'user_id' => $new_user->id,
                            'address' => $data['shipping_address'],
                            'address_2' => '',
                            'country' => $data['shipping_country'],
                            'state' => empty($data['shipping_state']) ? $data['shipping_country'] : $data['shipping_state'],
                            'city' => $data['shipping_city'],
                            'zip_code' => $data['shipping_zip'],
                            'phones' => $phone_numbers,
                            'set_default' => 1
                        ]);

                        $address_billing->set_default = 0;
                        $address_billing->save();
                    }


                }
            }

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e->getMessage()); // TODO: Find a better way to display messages on FE!
        }


        // TODO: Check if newsletter is checked and based on that add email to mailing list (CRM)
        // $subscribe_newsletter


        // Full Cart reset (with resetting session cart data)
        \CartService::fullCartReset();

        // Depending on payment method, do actions
        $this->executePayment($request, $order->id);


        // TODO: Go to Order page in user dashboard! Also, when payment gateway processes payment, callback url should navigate to Order single page in user dashboard (if user is logged in, of course)

        return redirect()->route('checkout.order.received', $order);
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

    public function executePayment(Request $request, $order_id) {
        $order = Order::with('payment_method')->find($order_id);

        if($order->payment_method->gateway === 'wire_transfer') {
            // TODO: Add different payment methods checkout flows here (going to payment gateway page with callback URL for payment_status change route)
        } else if($order->payment_method->gateway === 'paysera') {
            $paysera = new PayseraGateway(order: $order, payment_method: $order->payment_method, lang: 'ENG', paytext: translate('Payment for goods and services (for nb. [order_nr]) ([site_name])'));
            $paysera->pay();
        }
    }
}
