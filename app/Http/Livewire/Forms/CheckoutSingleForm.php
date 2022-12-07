<?php

namespace App\Http\Livewire\Forms;

use DB;
use EVS;
use Str;
use Auth;
use Carbon;
use Purifier;
use Categories;
use CartService;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Invoice;
use Livewire\Component;
use App\Models\OrderItem;
use LVR\CreditCard\CardCvc;
use App\Enums\OrderTypeEnum;
use LVR\CreditCard\CardNumber;
use Illuminate\Validation\Rule;
use App\Enums\PaymentStatusEnum;
use App\Traits\Livewire\RulesSets;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use App\Enums\ShippingStatusTypeEnum;
use App\Models\PaymentMethodUniversal;
use LVR\CreditCard\CardExpirationDate;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Contracts\Support\Arrayable;
use Spatie\ValidationRules\Rules\ModelsExist;

class CheckoutSingleForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $items;

    public $order;

    public $manual_mode_billing = true;

    public $manual_mode_shipping = true;

    public $show_addresses = false;

    public $addresses = [];

    public $selected_billing_address_id;

    public $selected_shipping_address_id;

    public $checkout_newsletter = false;

    public $buyers_consent = false;

    public $selected_payment_method = 'wire_transfer';

    public $cc_number;

    public $cc_name;

    public $cc_expiration_date;

    public $cc_cvc;

    // Account
    public $account_password;

    public $account_password_confirmation;

    protected $listeners = [];

    protected function rulesSets()
    {
        return [
            'items' => [
                'items.*' => [''],
            ],
            'main' => [
                'order.email' => 'required|email:rfc,dns',
                'order.billing_first_name' => 'required|min:2',
                'order.billing_last_name' => 'required|min:2',
                'order.billing_company' => 'nullable',
                'order.same_billing_shipping' => 'nullable',
                'order.phone_numbers' => 'array|required',
                'order.buyers_consent' => 'required|boolean|is_true',

                'selected_payment_method' => ['required', Rule::in(PaymentMethodUniversal::$available_gateways)],
                'checkout_newsletter' => 'nullable',
                'selected_billing_address_id' => '',
            ],
            'account_creation' => [
                'account_password' => 'required|confirmed|min:6',
            ],
            'billing' => [
                'order.billing_address' => 'required|min:5',
                'order.billing_country' => ['required', Rule::in(\Countries::getCodesAll(true))],
                'order.billing_state' => 'required|min:2',
                'order.billing_city' => 'required|min:3',
                'order.billing_zip' => 'required|min:2',
            ],
            'selected_billing_address' => [
                'selected_shipping_address_id' => 'required|if_id_exists:App\Models\Address,id',
            ],
            'shipping' => [
                'selected_shipping_address_id' => '',
                'order.shipping_address' => 'required|min:5',
                'order.shipping_country' => ['required', Rule::in(\Countries::getCodesAll(true))],
                'order.shipping_state' => 'required|min:2',
                'order.shipping_city' => 'required|min:3',
                'order.shipping_zip' => 'required|min:2',
            ],
            'selected_shipping_address' => [
                'selected_shipping_address_id' => 'required|if_id_exists:App\Models\Address,id',
            ],
            'registered_user_password_rule' => [
                'account_password' => 'match_password:App\Models\User,email,order.email',
            ],
            'non_registered_user_password_rule' => [
                'account_password' => 'required|confirmed|min:6',
            ],
            'cc' => [
                'cc_number' => ['required', new CardNumber],
                'cc_name' => 'required|min:3',
                'cc_expiration_date' => ['required', new CardExpirationDate('m/y')],
                'cc_cvc' => ['required'], // new LVR\CreditCard\CardCvc($request->get('card_number'))
            ],
        ];
    }

    protected function rules()
    {
        $rules = [];

        foreach ($this->rulesSets() as $key => $array) {
            $rules = array_merge($rules, $array);
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'order.email.required' => translate('Email is requierd'),
            'order.email.email' => translate('Wrong email format'),
            'order.billing_first_name.required' => translate('First name is required'),
            'order.billing_first_name.min' => translate('Minimum :min characters required'),
            'order.billing_last_name.required' => translate('Last name is required'),
            'order.billing_last_name.min' => translate('Minimum :min characters required'),

            'order.billing_address.required' => translate('Address is required'),
            'order.billing_address.min' => translate('Minimum :min characters required'),
            'order.billing_country.required' => translate('Country is required'),
            // 'order.billing_country.required' => ['required', Rule::in(\Countries::getCodesAll(true))],

            'order.billing_state.required' => translate('State is required'),
            'order.billing_state.min' => translate('Minimum :min characters required'),

            'order.billing_city.required' => translate('City is required'),
            'order.billing_city.min' => translate('Minimum :min characters required'),

            'order.billing_zip.required' => translate('ZIP code is required'),
            'order.billing_zip.min' => translate('Minimum :min characters required'),

            'account_password.match_password' => translate('Password is not correct for a given email. If you want to create an order under provided email, you have to know password of the user under given email. If you don\'t know, either use Forgot password or create another account. under different email.'),
            'order.buyers_consent.is_true' => translate('You must agree with terms of service'),
            'cc_expiration_date.required' => translate('CC expiration date is required'),
            'cc_cvc.required' => translate('Card CVC is required'),
            'cc_number.card_invalid' => translate('Card is invalid'),
        ];
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount()
    {
        $this->items = CartService::getItems();

        $this->order = new Order();

        /* TODO: This is temp workaround before implementing bellow option fully  */
        $this->order->shop_id = 1;

        // TODO: THIS IS VERY IMPORTANT - Separate $items based on shop_ids and create multiple orders
        // $this->order->shop_id = ($this->items->first()?->shop_id ?? 1);
        $this->order->same_billing_shipping = true;
        $this->order->buyers_consent = false;

        if (auth()->user()->id) {
            $this->order->email = auth()->user()->email;
            $this->order->billing_first_name = auth()->user()->name;
            $this->order->billing_last_name = auth()->user()?->name;
        }

        $this->cc_number = '';
        $this->cc_name = '';
        $this->cc_expiration_date = '';
        $this->cc_cvc = '';

        $this->manual_mode_billing = ! \Auth::check();
        $this->manual_mode_shipping = ! \Auth::check();
        $this->show_addresses = \Auth::check() && auth()->user()->addresses->isNotEmpty();
        $this->addresses = \Auth::check() ? auth()->user()->addresses->map(function ($item) {
            $item->country = \Countries::get(code: $item->country)->name ?? translate('Unknown');

            return $item;
        }) : [];
        $this->selected_billing_address_id = $this->show_addresses ?
            (auth()->user()->addresses->firstWhere('is_primary', true)->id ?? -1) : -1;

        $this->selected_shipping_address_id = $this->show_addresses ?
            (auth()->user()->addresses->firstWhere('is_primary', true)->id ?? -1) : -1;

        if ($this->selected_billing_address_id === -1) {
            $this->manual_mode_billing = true;
        }

        if ($this->selected_shipping_address_id === -1) {
            $this->manual_mode_shipping = true;
        }
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    public function render()
    {
        return view('livewire.checkout.checkout-single-form');
    }

    protected function getSpecificRules()
    {
        $rules = [];
        $rulesSets = $this->rulesSets();

        $add_billing_shipping_rules = function ($is_billing_selected = false) use (&$rulesSets, &$rules) {
            $rules = array_merge($rulesSets['main'], $is_billing_selected ? $rulesSets['selected_billing_address'] : $rulesSets['billing']);

            if (empty($this->order->same_billing_shipping)) {
                if ((int) $this->selected_shipping_address_id === -1) {
                    // Shipping address IS NOT a selected address, but a manually added address!
                    $rules = array_merge($rules, $rulesSets['shipping']);
                } else {
                    // Shipping address IS a selected address
                    $rules = array_merge($rules, $rulesSets['selected_shipping_address']);
                }
            }

            // User cretion rules (password)
            if (! Auth::check()) {
                $new_user = User::where('email', $this->order->email)->first(); // check if user with a given email already exists

                // Check if user with email is not already registered user.
                if ($new_user instanceof User && ! empty($new_user->id ?? null)) {
                    // Registered user
                    $rules = array_merge($rules, $rulesSets['registered_user_password_rule']);
                } else {
                    // Not registered user
                    $rules = array_merge($rules, $rulesSets['non_registered_user_password_rule']);
                }
            }
        };

        if (Auth::check()) {
            if ((int) $this->selected_billing_address_id === -1) {
                // Always validate billing info when user IS logged-in AND DID NOT select billing address
                $add_billing_shipping_rules();
            } else {
                $add_billing_shipping_rules(true);
            }
        } else {
            // Always validate billing info when user is not authenticated
            $add_billing_shipping_rules();
        }

        return $rules;
    }

    public function pay()
    {
        $this->items = CartService::getItems();

        try {
            $this->validate($this->getSpecificRules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

        DB::beginTransaction();

        try {
            $payment_method = PaymentMethodUniversal::where('gateway', $this->selected_payment_method)->first();

            $default_grace_period = 5; // 5 days is default grace period
            $default_due_date = Carbon::now()->addDays(7)->toDateTimeString(); // 7 days fom now is default invoice due_date
            $phone_numbers = [];
            $user = auth()->user() ?? null;

            if (! Auth::check()) {
                $user = User::where('email', $this->order->email)->first();

                if (! empty($user->id ?? null) && Hash::check($this->account_password, $user->password)) { // check password again just in case
                    // There is a user under given Email AND passwords match -> LOG IN USER
                    auth()->login($user, true); // log the user in
                } else {
                    // Create user 'cuz there's no user under this email and password validation passed

                    // TODO: Move to some RegistrationService or something so we can reuse it throughout the app!

                    // Create user
                    $user = User::create([
                        'name' => $this->order->billing_first_name.' '.$this->order->billing_last_name,
                        'user_type' => User::$customer_type,
                        'email' => $this->order->email,
                        'password' => bcrypt($this->account_password),
                    ]);

                    // Create address
                    $address_billing = Address::create([
                        'user_id' => $user->id,
                        'address' => $this->order->billing_address,
                        'address_2' => '',
                        'country' => $this->order->billing_country,
                        'state' => empty($this->order->billing_state) ? $this->order->billing_country : $this->order->billing_state,
                        'city' => $this->order->billing_city,
                        'zip_code' => $this->order->billing_zip,
                        'phones' => json_encode($this->order->phone_numbers),
                        'set_default' => 1,
                    ]);

                    if (! $this->order->same_billing_shipping) {
                        // Create another address with shipping info
                        $address_shipping = Address::create([
                            'user_id' => $user->id,
                            'address' => $this->order->shipping_address,
                            'address_2' => '',
                            'country' => $this->order->shipping_country,
                            'state' => empty($this->order->shipping_state) ? $this->order->shipping_country : $this->order->shipping_state,
                            'city' => $this->order->shipping_city,
                            'zip_code' => $this->order->shipping_zip,
                            'phones' => json_encode($this->order->phone_numbers),
                            'set_default' => 1,
                        ]);

                        $address_billing->set_default = 0;
                        $address_billing->save();
                    }
                }
            }

            // TODO: THIS IS VERY IMPORTANT - Separate $items based on shop_ids and create multiple orders
            $this->order->shop_id = $this->items->first()->shop_id;
            $this->order->user_id = auth()->user()->id ?? null;

            // TODO: THIS IS ALSO VERY IMPORTANT - Separate $items based on type - is it a subscription or a standard product...or installment?

            if ($this->items->first() instanceof Plan) {
                /*
                * Invoicing data for SUBSCRIPTIONS/PLANS or INCREMENTAL orders
                */
                $this->order->type = OrderTypeEnum::subscription()->value;
                $this->order->number_of_invoices = -1; // 'unlimited' for subscriptions
                $this->order->invoicing_period = 'month'; // TODO: Add monthly/annual switch
                $this->order->invoice_grace_period = 0;
                $this->order->invoicing_start_date = Carbon::now()->timestamp; // when invoicing starts
            } else {
                $this->order->type = OrderTypeEnum::standard()->value;
                $this->order->number_of_invoices = 1; // 1 for one-time payment
                $this->order->invoicing_period = null;
                $this->order->invoice_grace_period = $default_grace_period;
                $this->order->invoicing_start_date = Carbon::now()->timestamp; // when invoicing starts? NOW!
            }

            /*
            * Billing data (when Address is selected)
            * Only if user is logged-in
            */
            // TODO: Add validation that if address is selected, that address must be related to the user who is checking out
            if (Auth::check() && $this->selected_billing_address_id > 0 && Address::where('id', $this->selected_billing_address_id)->exists()) {
                // Billing Address is selected from the list
                $address = Address::find($this->selected_billing_address_id);

                $this->order->billing_address = $address->address;
                $this->order->billing_country = $address->country;
                $this->order->billing_state = empty($address->state) ? $address->country : $address->state;
                $this->order->billing_city = $address->city;
                $this->order->billing_zip = $address->zip_code;
                $this->order->phone_numbers = $phone_numbers = $address->phones; // TODO: To overwrite phones or no???
            }

            /*
             * Shipping data (when billing and shipping data are not the same)
             * Address (user logged-in) + Manual
             */
            if (! $this->order->same_billing_shipping) {
                // TODO: Do we need shipping first_name, last_name and shipping_company ???
                $this->order->shipping_first_name = $this->order->billing_first_name;
                $this->order->shipping_last_name = $this->order->billing_last_name;
                $this->order->shipping_company = $this->order->billing_company;

                // Check if Shipping Address is selected from user's addresses
                // TODO: Add validation that if address is selected, that address must be related to the user who is checking out
                if (Auth::check() && $this->selected_shipping_address_id > 0 && Address::where('id', $this->selected_shipping_address_id)->exists()) {
                    // Billing Address is selected from the list
                    $address = Address::find($this->selected_shipping_address_id);

                    $this->order->shipping_address = $address->address;
                    $this->order->shipping_country = $address->country;
                    $this->order->shipping_state = empty($address->state) ? $address->country : $address->state;
                    $this->order->shipping_city = $address->city;
                    $this->order->shipping_zip = $address->zip_code;
                }
            }

            $this->order->shipping_method = 'free'; // TODO: Change this to use shipping methods and calculations when the shipping logic is added in BE
            $this->order->shipping_cost = 0;
            $this->order->tax = 0; // TODO: Change this to use Taxes from DB (Create Tax logic in BE first)

            // payment_status - `unpaid` by default (this should be changed on payment processor callback before Thank you page is shown - if payment goes through of course)
            // shipping_status - `not_sent` by default (this is changed manually in Order management pages by company staff)
            // viewed - is 0 by default (if it's not viewed by company stuff, it'll be marked as `New` in company dashboard)

            $this->order->save();

            /*
             * Create OrderItem(s)
             */
            foreach ($this->items as $item) {
                $order_item = new OrderItem();
                $order_item->order_id = $this->order->id;
                $order_item->subject_type = $item::class;
                $order_item->subject_id = $item->id;
                $order_item->name = ($item?->is_variation ?? false) ? $item->main->name : $item->name;
                $order_item->excerpt = ($item?->is_variation ?? false) ? $item->main->excerpt : $item->excerpt;
                $order_item->variant = ($item?->is_variation ?? false) ? $item->getVariantName(key_by: 'name') : null;
                $order_item->quantity = ! empty($item->purchase_quantity) ? $item->purchase_quantity : 1;

                // Check if $item has stock and reduce it if it does (ONLY IF TRACK_INVENTORY is TRUE)
                if ($item->track_inventory && method_exists($item, 'stock')) {
                    // Reduce the stock quantity of an $item
                    $serial_numbers = $item->reduceStock();

                    // Serial Numbers only work for Simple Products.
                    // TODO: Make Product Variations support serial numbers!
                    if ($item->use_serial) {
                        $order_item->serial_numbers = $serial_numbers; // reduceStockBy returns serial numbers in array if $item uses serials
                    } else {
                        $order_item->serial_numbers = null;
                    }
                }

                $order_item->base_price = $item->base_price; // it's like a unit_price
                $order_item->discount_amount = $order_item->quantity * ($item->base_price - $item->total_price);
                $order_item->subtotal_price = $order_item->quantity * $item->total_price;
                $order_item->total_price = $order_item->quantity * $item->total_price;
                $order_item->tax = 0; // TODO: Think about what to do with this one (But first create Tax BE Logic)!!!

                $order_item->save();
            }

            /*
             * Create Invoice
             */
            $invoice = new Invoice();

            $invoice->order_id = $this->order->id;
            $invoice->shop_id = $this->order->shop_id;
            $invoice->user_id = $this->order->user_id;
            $invoice->is_temp = false;
            $invoice->mode = 'live';
            $invoice->payment_method_type = PaymentMethodUniversal::class;
            $invoice->payment_method_id = $payment_method->id ?? null;
            $invoice->payment_status = PaymentStatusEnum::unpaid()->value;
            // $invoice->invoice_number = Invoice::generateInvoiceNumber($this->order->billing_first_name, $this->order->billing_last_name, $this->order->billing_company); // Default: VJ21012022

            $invoice->email = $this->order->email;
            $invoice->billing_first_name = $this->order->billing_first_name;
            $invoice->billing_last_name = $this->order->billing_last_name;
            $invoice->billing_company = $this->order->billing_company;
            $invoice->billing_address = $this->order->billing_address;
            $invoice->billing_country = $this->order->billing_country;
            $invoice->billing_state = $this->order->billing_state;
            $invoice->billing_city = $this->order->billing_city;
            $invoice->billing_zip = $this->order->billing_zip;

            // Take invoice totals from Cart
            $invoice->base_price = CartService::getOriginalPrice()['raw'];
            $invoice->discount_amount = CartService::getDiscountAmount()['raw'];
            $invoice->subtotal_price = CartService::getSubtotalPrice()['raw'];
            $invoice->total_price = CartService::getSubtotalPrice()['raw']; // should be TotalPrice in future...

            $invoice->shipping_cost = 0; // TODO: Don't forget to change this when shipping mechanism is created
            $invoice->tax = 0; // TODO: Don't forget to change this when tax mechanism is created

            // TODO: Add Shop Settings for general due_date and grace_period
            // TODO: Trial can determine invoicing start_date because trial can append X days on top of current date-time, so invoicing starts on e.g. 15 days from current date, or 30 or X
            $invoice->start_date = $this->order->invoicing_start_date; // current unix_timestamp (for non-trial plans)
            $invoice->due_date = null; // Default due_date is NULL days for subscription (if not trial mode, if it's trial it's null)
            $invoice->grace_period = $this->order->invoice_grace_period; // NULL; or 5 days grace_period by default

            $invoice->setInvoiceNumber();

            $invoice->save();

            DB::commit();

            $this->executePayment(request(), $invoice->id);


            // Full cart reset
            CartService::fullCartReset();

            return redirect()->route('checkout.order.received', $this->order->id);
        } catch (\Throwable $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while processing the order...Please try again.'));
            dd($e);
        }
    }

    protected function executePayment(mixed $request, $invoice_id)
    {
        $invoice = Invoice::with('payment_method')->find($invoice_id);
        $invoice->load('payment_method');

        // TODO: Add different payment methods checkout flows here (going to payment gateway page with callback URL for payment_status change route)

        if ($invoice->payment_method->gateway === 'wire_transfer') {

        } else if ($invoice->payment_method->gateway === 'stripe') {

        } else if ($invoice->payment_method->gateway === 'paypal') {
            
        } else if ($invoice->payment_method->gateway === 'paysera') {
            $paysera = new PayseraGateway(order: $invoice->order, invoice: $invoice, payment_method: $invoice->payment_method, lang: 'ENG', paytext: translate('Payment for goods and services (for nb. [order_nr]) ([site_name])'));
            $paysera->pay();
        }
    }
}
