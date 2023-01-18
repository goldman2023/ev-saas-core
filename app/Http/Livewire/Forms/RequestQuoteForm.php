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
use App\Models\Product;
use Livewire\Component;
use App\Models\OrderItem;
use LVR\CreditCard\CardCvc;
use App\Enums\OrderTypeEnum;
use LVR\CreditCard\CardNumber;
use Illuminate\Validation\Rule;
use App\Enums\PaymentStatusEnum;
use App\Traits\Livewire\RulesSets;
use Illuminate\Support\Collection;
use App\Traits\Livewire\HasCoreMeta;
use Illuminate\Support\Facades\Hash;
use App\Enums\ShippingStatusTypeEnum;
use App\Models\PaymentMethodUniversal;
use App\Traits\Livewire\HasAttributes;
use LVR\CreditCard\CardExpirationDate;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Contracts\Support\Arrayable;
use Spatie\ValidationRules\Rules\ModelsExist;

class RequestQuoteForm extends Component
{
    use RulesSets;
    use DispatchSupport;
    use HasCoreMeta;
    use HasAttributes;

    public $order_items = [];

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

    // Account
    public $account_password;

    public $account_password_confirmation;

    protected $listeners = [];

    protected function rulesSets()
    {
        return [
            'order_items' => [
                'order_items' => ['nullable'],
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
                'manual_mode_billing' => 'nullable',
                'manual_mode_shipping' => 'nullable',
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
            ]
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

    public function getWEFRules() {
        return apply_filters('tenant.request-quote.rules.wef', []);
    }

    public function getWEFMessages() {
        return apply_filters('tenant.request-quote.messages.wef', []);
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount()
    {
        // Create new Order model
        $this->order = new Order();

        /* TODO: This is temp workaround before implementing bellow option fully  */
        $this->order->shop_id = 1;

        // TODO: THIS IS VERY IMPORTANT - Separate $items based on shop_ids and create multiple orders
        // $this->order->shop_id = ($this->order_items->first()?['shop_id'] ?? 1);

        $this->order->type = OrderTypeEnum::standard()->value;
        $this->order->same_billing_shipping = true;
        $this->order->buyers_consent = false;

        if (auth()->user()?->id ?? null) {
            $this->order->email = auth()->user()->email;
            $this->order->billing_first_name = auth()->user()->name;
            $this->order->billing_last_name = auth()->user()?->name;
        }

        $this->initCoreMeta($this->order);

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

        // Create OrderItems
        $this->order_items = [];
        $cart_items = CartService::getItems();

        $fake_product = new Product();
        $this->refreshAttributes($fake_product);

        if($cart_items) {
            foreach($cart_items as $key => $item) {
                // $item is Product here (or any other purchasable model from Cart)
                $custom_attributes = [];
                $selected_predefined_attribute_values = [];
                self::initAttributes($item, $custom_attributes, $selected_predefined_attribute_values, $item::class);

                $this->order_items[] = [
                    'id' => $item->id,
                    'subject_type' => base64_encode($item::class),
                    'subject_id' => $item->id ?? null,
                    'name' => $item->name,
                    'excerpt' => $item->excerpt,
                    'quantity' => $item->purchase_quantity,
                    'thumbnail' => $item?->thumbnail?->file_name ?? '',
                    'custom_attributes' => $custom_attributes,
                    'selected_attribute_values' => $selected_predefined_attribute_values,
                ];
            }
        }
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    public function render()
    {
        return view('livewire.forms.request-quote-form');
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

    public function requestQuote()
    {
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
                    // Create ghost-user 'cuz there's no user under this email and password validation passed

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
            $this->order->shop_id = 1;
            $this->order->user_id = auth()->user()?->id ?? null;

            $this->order->type = OrderTypeEnum::standard()->value;
            $this->order->number_of_invoices = 1;
            $this->order->invoicing_period = null;
            $this->order->invoice_grace_period = $default_grace_period;
            $this->order->invoicing_start_date = 0; // when invoicing starts? NOW!

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
            foreach ($this->order_items as $item) {
                $order_item = new OrderItem();
                $order_item->order_id = $this->order->id;
                $order_item->subject_type = empty($item['subject_type'] ?? null) ? null : base64_decode($item['subject_type']);
                $order_item->subject_id = $item['subject_id'] ?? null;
                $order_item->name = $item['name'];
                $order_item->excerpt = $item['excerpt'];
                $order_item->variant = $item['variant'] ?? null;
                $order_item->quantity = $item['quantity'];

                $order_item->base_price = 0; // it's like a unit_price
                $order_item->discount_amount = 0;
                $order_item->subtotal_price = 0;
                $order_item->total_price = 0;
                $order_item->tax = 0;

                $order_item->save();

                // Define custom_attributes for each $item
                $item_attributes = $item['custom_attributes'];
                $selected_attribute_values = $item['selected_attribute_values'];
                $this->setAttributes($order_item, $item['custom_attributes'], $item['selected_attribute_values']); // set attributes to OrderItem
            }

            $this->order->load('order_items');

            do_action('request-quote.insert', $this->order);

            DB::commit();

            // Full cart reset
            CartService::fullCartReset();

            return redirect()->route('quote.received', $this->order->id);
        } catch (\Throwable $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while processing "Request a quote" action...Please try again.'));
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
