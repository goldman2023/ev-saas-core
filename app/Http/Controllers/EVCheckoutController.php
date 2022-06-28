<?php

namespace App\Http\Controllers;

use App\Enums\OrderTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\ShippingStatusEnum;
use App\Http\Services\PaymentMethods\PayseraGateway;
use App\Models\Address;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethodUniversal;
use App\Models\User;
use Auth;
use Session;
use CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EVCheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart_items = CartService::getItems();
        $total_items_count = CartService::getTotalItemsCount();

        $originalPrice = CartService::getOriginalPrice();
        $discountAmount = CartService::getDiscountAmount();
        $subtotalPrice = CartService::getSubtotalPrice();

        return view('frontend.checkout', compact('cart_items', 'total_items_count', 'originalPrice', 'discountAmount', 'subtotalPrice'));
    }

    public function store(Request $request)
    {
        $cart_items = CartService::getItems();
        $total_items_count = CartService::getTotalItemsCount();

        // Check if there are items in cart
        if ($total_items_count <= 0) {
            // Should redirect to empty cart page
            return redirect('cart');
        }

        $originalPrice = CartService::getOriginalPrice();
        $discountAmount = CartService::getDiscountAmount();
        $subtotalPrice = CartService::getSubtotalPrice();

        $same_billing_shipping = ! empty($request->input('same_billing_shipping'));
        $subscribe_newsletter = ! empty($request->input('newsletter'));

        $data_to_validate = [
            'email' => 'required|email:rfc,dns',
            'billing_first_name' => 'required|min:3',
            'billing_last_name' => 'required|min:3',
            'billing_company' => 'nullable',
            'payment_method' => ['required', Rule::in(\App\Models\PaymentMethodUniversal::$available_gateways)],
            'note' => 'nullable',
            'same_billing_shipping' => 'nullable',
            'newsletter' => 'nullable',
            'buyers_consent' => 'required',
            'selected_billing_address_id' => '',
        ];

        $address_rules = [
            'billing_address' => 'required|min:5',
            'billing_country' => ['required', Rule::in(\Countries::getCodesAll(true))],
            'billing_state' => 'nullable',
            'billing_city' => 'required|min:3',
            'billing_zip' => 'required|min:2',
            'phone_numbers' => 'array|required', // TODO: Consider changing this to phone_number.* in order to specify which phone number is not valid
        ];

        $shipping_rules = [
            //            'shipping_first_name' => 'required|min:3',
            //            'shipping_last_name' => 'required|min:3',
            //            'shipping_company' => 'nullable',
            'shipping_address' => 'required|min:5',
            'shipping_country' => ['required', Rule::in(\Countries::getCodesAll(true))],
            'shipping_state' => 'nullable',
            'shipping_city' => 'required|min:3',
            'shipping_zip' => 'required|min:2',
        ];

        $add_billing_shipping_rules = function () use ($request, &$data_to_validate, $address_rules, $shipping_rules) {
            $data_to_validate = array_merge($data_to_validate, $address_rules);

            if (empty($request->input('same_billing_shipping'))) {
                if ((int) $request->input('selected_shipping_address_id') === -1 || empty($request->input('selected_shipping_address_id'))) {
                    // Shipping address IS NOT a selected address, but a manually added address!
                    $data_to_validate = array_merge($data_to_validate, $shipping_rules);
                } else {
                    // Shipping address IS a selected address
                    $data_to_validate = array_merge($data_to_validate, [
                        'selected_shipping_address_id' => 'required|if_id_exists:App\Models\Address,id',
                    ]);
                }
            }
        };

        if (Auth::check()) {
            if ((int) $request->input('selected_billing_address_id') === -1 || empty($request->input('selected_billing_address_id'))) {
                // Always validate billing info when user IS logged in AND DID NOT select billing address
                $add_billing_shipping_rules();
            } else {
                $data_to_validate = array_merge($data_to_validate, [
                    'selected_billing_address_id' => 'required|if_id_exists:App\Models\Address,id',
                ]);

                if (! $same_billing_shipping) {
                    // shipping address IS NOT the same as the billing address

                    if ((int) $request->input('selected_shipping_address_id') === -1 || empty($request->input('selected_shipping_address_id'))) {
                        // Shipping address IS NOT a selected address, but a manually added address!
                        $data_to_validate = array_merge($data_to_validate, $shipping_rules);
                    } else {
                        // Shipping address IS a selected address
                        $data_to_validate = array_merge($data_to_validate, [
                            'selected_shipping_address_id' => 'required|if_id_exists:App\Models\Address,id',
                        ]);
                    }
                }
            }
        } else {
            // Always validate bislling info when user is not authenticated
            $add_billing_shipping_rules();
        }

        // If billing and shipping address are not the same
        $validator = Validator::make($request->all(), $data_to_validate);

        if ($validator->fails()) {
            // dd($validator);
            session()->flashInput($request->input()); // needed in order to use $request()->old('{input_name}')

            return view('frontend.checkout', compact('cart_items', 'total_items_count', 'originalPrice', 'discountAmount', 'subtotalPrice'))
                ->withErrors($validator);
        }

        // Retrieve the validated input...
        $data = $validator->validated();

        // Validate password again
        // If user is not logged in and `create account` is set to TRUE
        $new_user = User::where('email', $data['email'])->first();
        $to_create_user = empty(auth()->user()->id ?? null) && $request->input('create_account') === 'on';
        if ($to_create_user) {
            // Check if user with email is not already registered user.
            if ($new_user instanceof User && ! empty($new_user->id ?? null)) {
                // Registered user
                $account_password_rules = 'match_password:App\Models\User,email';
            } else {
                // Not registered user
                $account_password_rules = 'required|confirmed|min:6';
            }

            if (($password_validator = Validator::make($request->all(), [
                'account_password' => $account_password_rules,
            ], [
                'account_password.match_password' => translate('Password is not correct for a given email. If you want to create an order under provided email, you have to know password of the user under given email. If you don\'t know, either use Forgot password or create another account. under different email.'),
            ]))->fails()) {
                session()->flashInput($request->input()); // needed in order to use $request()->old('{input_name}')

                return view('frontend.checkout', compact('cart_items', 'total_items_count', 'originalPrice', 'discountAmount', 'subtotalPrice'))
                    ->withErrors($password_validator);
            }

            $password_data = $password_validator->validated();
        }

        DB::beginTransaction();

        try {
            $payment_method = PaymentMethodUniversal::where('gateway', $data['payment_method'])->first();
            $default_grace_period = 5; // 5 days is default grace period
            $default_due_date = Carbon::now()->addDays(7)->toDateTimeString(); // 7 days fom now is default invoice due_date
            $selected_billing_address_id = (int) ($request->input('selected_billing_address_id') ?? -1);
            $selected_shipping_address_id = (int) ($request->input('selected_shipping_address_id') ?? -1);
            $phone_numbers = [];

            // Save Order and order items
            $order = new Order();
            $order->shop_id = \CartService::getShop(true);
            $order->user_id = auth()->user()->id ?? null;
            $order->email = $data['email'];
            $order->type = OrderTypeEnum::standard()->value;

            $order->billing_first_name = $data['billing_first_name'];
            $order->billing_last_name = $data['billing_last_name'];
            $order->billing_company = $data['billing_company'];

            // Check if Billing Address is selected from user's addresses
            // TODO: Add validation that if address is selected, that address must be related to the user who is checking out
            if ($selected_billing_address_id > 0 && Address::where('id', $selected_billing_address_id)->exists()) {
                // Billing Address is selected from the list
                $address = Address::find($selected_billing_address_id);

                $order->billing_address = $address->address;
                $order->billing_country = $address->country;
                $order->billing_state = empty($address->state) ? $address->country : $address->state;
                $order->billing_city = $address->city;
                $order->billing_zip = $address->zip_code;
                $order->phone_numbers = $phone_numbers = $address->phones;
            } else {
                // Billing Address is manually added
                $order->billing_address = $data['billing_address'];
                $order->billing_country = $data['billing_country'];
                $order->billing_state = empty($data['billing_state']) ? $data['billing_country'] : $data['billing_state'];
                $order->billing_city = $data['billing_city'];
                $order->billing_zip = $data['billing_zip'];
                $order->phone_numbers = $phone_numbers = array_values(array_filter($data['phone_numbers'] ?? ['']));
            }

            $order->same_billing_shipping = $same_billing_shipping;

            // Check if billing and shipping address are NOT THE SAME!
            if (! $same_billing_shipping) {
                // TODO: Do we need shipping first_name, last_name and shipping_company ???
                $order->shipping_first_name = $data['billing_first_name'];
                $order->shipping_last_name = $data['billing_last_name'];
                $order->shipping_company = $data['billing_company'];

                // Check if Shipping Address is selected from user's addresses
                // TODO: Add validation that if address is selected, that address must be related to the user who is checking out
                if ($selected_shipping_address_id > 0 && Address::where('id', $selected_shipping_address_id)->exists()) {
                    // Billing Address is selected from the list
                    $address = Address::find($selected_shipping_address_id);

                    $order->shipping_address = $address->address;
                    $order->shipping_country = $address->country;
                    $order->shipping_state = empty($address->state) ? $address->country : $address->state;
                    $order->shipping_city = $address->city;
                    $order->shipping_zip = $address->zip_code;
                } else {
                    // Shipping Address is manually added
                    $order->shipping_address = $data['shipping_address'];
                    $order->shipping_country = $data['shipping_country'];
                    $order->shipping_state = empty($data['shipping_state']) ? $data['shipping_country'] : $data['shipping_state'];
                    $order->shipping_city = $data['shipping_city'];
                    $order->shipping_zip = $data['shipping_zip'];
                }
            }

            $order->base_price = $originalPrice['raw'];
            $order->discount_amount = $discountAmount['raw'];
            $order->subtotal_price = $subtotalPrice['raw'];
            $order->total_price = $subtotalPrice['raw']; // TODO: This should be totalPrice (with taxes and stuff...but since we don't have Tax system working, let it stay like this for now)

            $order->shipping_method = 'free'; // TODO: Change this to use shipping methods and calculations when the shipping logic is added in BE
            $order->shipping_cost = 0;
            $order->tax = 0; // TODO: Change this to use Taxes from DB (Create Tax logic in BE first)

//            $order->terms TODO: Where are Order Terms added? In shop settings(default), in each purchasable item (specific)?

            // These are invoicing data for standard orders
            $order->number_of_invoices = 1;
            $order->invoicing_period = null;
            $order->invoice_grace_period = $default_grace_period;
            $order->invoicing_start_date = Carbon::now()->toDateTimeString(); // start invoicing this moment

            $order->note = $data['note'];

            // payment_status - `unpaid` by default (this should be changed on payment processor callback before Thank you page is shown - if payment goes through of course)
            // shipping_status - `not_sent` by default (this is changed manually in Order management pages by company staff)
            // viewed - is 0 by default (if it's not viewed by company stuff, it'll be marked as `New` in company dashboard)

            $order->save();

            // Save Order items
            foreach ($cart_items as $item) {
                // Check if there are enough items in stock for each item
                // TODO: Checking if there are enough items in stock should be done before creating an order and by locking the table (maybe).
                if ($item->current_stock >= $item->purchase_quantity) {
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
                    if ($item->use_serial) {
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

            // Create Invoices
            // TODO: Create Invoice(s)
            $invoice = new Invoice();
            $invoice->order_id = $order->id;
            $invoice->shop_id = \CartService::getShop(true);
            $invoice->user_id = auth()->user()->id ?? null;
            $invoice->payment_method_type = PaymentMethodUniversal::class;
            $invoice->payment_method_id = $payment_method->id ?? null;
            $invoice->invoice_number = Invoice::generateInvoiceNumber($data['billing_first_name'], $data['billing_last_name'], $data['billing_company']); // Default: VJ21012022
            $invoice->email = $data['email'];

            $invoice->billing_first_name = $data['billing_first_name'];
            $invoice->billing_last_name = $data['billing_last_name'];
            $invoice->billing_company = $data['billing_company'];

            // Check if Billing Address is selected from user's addresses
            // TODO: Add validation that if address is selected, that address must be related to the user who is checking out
            if ($selected_billing_address_id > 0 && Address::where('id', $selected_billing_address_id)->exists()) {
                // Billing Address is selected from the list
                $address = Address::find($selected_billing_address_id);

                $invoice->billing_address = $address->address;
                $invoice->billing_country = $address->country;
                $invoice->billing_state = empty($address->state) ? $address->country : $address->state;
                $invoice->billing_city = $address->city;
                $invoice->billing_zip = $address->zip_code;
            } else {
                // Billing Address is manually added
                $invoice->billing_address = $data['billing_address'];
                $invoice->billing_country = $data['billing_country'];
                $invoice->billing_state = empty($data['billing_state']) ? $data['billing_country'] : $data['billing_state'];
                $invoice->billing_city = $data['billing_city'];
                $invoice->billing_zip = $data['billing_zip'];
            }

            $invoice->base_price = $originalPrice['raw'];
            $invoice->discount_amount = $discountAmount['raw'];
            $invoice->subtotal_price = $subtotalPrice['raw'];
            $invoice->total_price = $subtotalPrice['raw'];

            $invoice->shipping_cost = 0; // TODO: Don't forget to change this when shipping mechanism is created
            $invoice->tax = 0; // TODO: Don't forget to change this when tax mechanism is created

            // TODO: Add Shop Settings for general due_date and grace_period
            $invoice->due_date = $default_due_date; // Default due_date is 7 days from
            $invoice->grace_period = $default_grace_period; // 5 days grace_period by default

            $invoice->save();

//            throw new \Exception($invoice->toJson());

            // If user is not logged in and `create account` is set to TRUE - Create account if it doesn't exist
            if ($to_create_user) {
                if (! empty($new_user->id ?? null) && Hash::check($data['account_password'], $new_user->password)) { // check password again just in case
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
                        'password' => bcrypt($password_data['account_password']),
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
                        'set_default' => 1,
                    ]);

                    if (! $same_billing_shipping) {
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
                            'set_default' => 1,
                        ]);

                        $address_billing->set_default = 0;
                        $address_billing->save();
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flashInput($request->input()); // needed in order to use $request()->old('{input_name}')

            return view('frontend.checkout', compact('cart_items', 'total_items_count', 'originalPrice', 'discountAmount', 'subtotalPrice'))
                ->withErrors(['general' => $e->getMessage()]);
        }

        // TODO: Check if newsletter is checked and based on that add email to mailing list (CRM)
        // $subscribe_newsletter

        // Full Cart reset (with resetting session cart data)
        \CartService::fullCartReset();

        // Depending on payment method, do actions
        $this->executePayment($request, $invoice->id);

        // TODO: Go to Order page in user dashboard! Also, when payment gateway processes payment, callback url should navigate to Order single page in user dashboard (if user is logged in, of course)

        return redirect()->route('checkout.order.received', $order);
    }

    public function single()
    {
        if (empty(request()->data)) {
            $models = CartService::getItems();
        } else {
            $data = json_decode(base64_decode(request()->data ?? null));

            $models = collect([app($data->class)->findOrFail($data->id)]); // for now only one model can be bouoght using a link approach
            // TODO: Add purchase_quantity to $model here, based on $qty
        }

        // If models are empty, redirect to Homepage
        if ($models->isEmpty()) {
            return redirect()->route('home');
        }

        return view('frontend.checkout-single', compact('models'));
    }

    public function orderReceived(Request $request, $order_id)
    {
        $order = Order::find($order_id);

        /** 
         * Order Received page (or Thank you page) can be accessed only by user who bought it.
         * But what are we going to do with Guest users?
         * 1. They will be identified by session ID
         * 2. Email will be sent to them to finalize registration (when ghost/guest user is created in our DB after purchase)
        */
        $ghost_user = User::where('session_id', Session::getId())->first();

        if(!Auth::check() && $order->user_id !== ($ghost_user?->id ?? null)) {
            // Guest users - identify them by session_id and check if any user has that session_id, if not redirect!
            return redirect()->route('user.registration');
        } else if(Auth::check() && $order->user_id !== (auth()->user()?->id ?? null) && !auth()->user()->isAdmin()) {
            return redirect()->route('home');
        }

        return view('frontend.order-received', compact('order', 'ghost_user'));
    }

    public function orderCanceled(Request $request, $order_id)
    {
        $order = Order::find($order_id);

        return view('frontend.order-canceled', compact('order'));
    }

    public function executePayment(Request $request, $invoice_id)
    {
        $invoice = Invoice::with('payment_method')->find($invoice_id);

        if ($invoice->payment_method->gateway === 'wire_transfer') {
            // TODO: Add different payment methods checkout flows here (going to payment gateway page with callback URL for payment_status change route)
        } elseif ($invoice->payment_method->gateway === 'paysera') {
            $paysera = new PayseraGateway(order: $invoice->order, invoice: $invoice, payment_method: $invoice->payment_method, lang: 'ENG', paytext: translate('Payment for goods and services (for nb. [order_nr]) ([site_name])'));
            $paysera->pay();
        }
    }
}
