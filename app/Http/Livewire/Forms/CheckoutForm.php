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
use Payments;
use AuthService;
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
use App\Traits\Livewire\HasCoreMeta;
use Illuminate\Support\Facades\Hash;
use App\Enums\ShippingStatusTypeEnum;
use App\Models\PaymentMethodUniversal;
use App\Traits\Livewire\HasAttributes;
use LVR\CreditCard\CardExpirationDate;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Contracts\Support\Arrayable;
use Spatie\ValidationRules\Rules\ModelsExist;

class CheckoutForm extends Component
{
    use RulesSets;
    use DispatchSupport;
    use HasCoreMeta;
    use HasAttributes;

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

    protected $listeners = ['refreshCheckoutForm' => '$refresh'];

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
                'order.same_billing_shipping' => 'required|boolean',
                'order.billing_country' => 'nullable',
                'order.shipping_country' => 'nullable',
                'order.phone_numbers' => 'array|required',
                'order.buyers_consent' => 'required|boolean|is_true',

                'selected_payment_method' => ['required', Rule::in(PaymentMethodUniversal::$available_gateways)],
                'checkout_newsletter' => 'nullable',
            ],
            'wef' => $this->getWEFRules(),
            'billing' => [
                'selected_billing_address_id' => '',
                'order.billing_address' => 'required|min:5',
                'order.billing_country' => ['required', Rule::in(\Countries::getCodesAll(true))],
                'order.billing_state' => 'required|min:2',
                'order.billing_city' => 'required|min:3',
                'order.billing_zip' => 'required|min:2',
            ],
            'selected_billing_address' => [
                'selected_billing_address_id' => 'required|if_id_exists:App\Models\Address,id',
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
        return $this->getRuleSetsCombined([
            'main', 
            'wef',
            'billing' => function() {
                if(Auth::check() && $this->selected_billing_address_id === -1) return true; // if user is auth. and billing address IS NOT selected
                else if(!\Auth::check()) return true; // if user is not auth.
            },
            'selected_billing_address' => function() {
                if(Auth::check() && $this->selected_billing_address_id !== -1) return true; // if user is auth. and billing address IS selected
            },
            'shipping' => function() {
                if(empty($this->order->same_billing_shipping)) {
                    if(Auth::check() && $this->selected_shipping_address_id === -1) return true;
                    else if(!\Auth::check()) return true;
                }
            },
            'selected_shipping_address' => function() {
                if(empty($this->order->same_billing_shipping)) {
                    if(Auth::check() && $this->selected_shipping_address_id !== -1) return true;
                }
            },
        ]);
    }

    protected function messages()
    {
        return array_merge([
            'order.email.required' => translate('Email is requierd'),
            'order.email.email' => translate('Wrong email format'),
            'order.billing_first_name.required' => translate('First name is required'),
            'order.billing_first_name.min' => translate('Minimum :min characters required'),
            'order.billing_last_name.required' => translate('Last name is required'),
            'order.billing_last_name.min' => translate('Minimum :min characters required'),

            // Billing Address
            'order.billing_address.required' => translate('Address is required'),
            'order.billing_address.min' => translate('Minimum :min characters required'),
            'order.billing_country.required' => translate('Country is required'),
            'order.billing_state.required' => translate('State is required'),
            'order.billing_state.min' => translate('Minimum :min characters required'),
            'order.billing_city.required' => translate('City is required'),
            'order.billing_city.min' => translate('Minimum :min characters required'),
            'order.billing_zip.required' => translate('ZIP code is required'),
            'order.billing_zip.min' => translate('Minimum :min characters required'),

            // Shipping Address
            'order.shipping_address.required' => translate('Address is required'),
            'order.shipping_address.min' => translate('Minimum :min characters required'),
            'order.shipping_country.required' => translate('Country is required'),
            'order.shipping_state.required' => translate('State is required'),
            'order.shipping_state.min' => translate('Minimum :min characters required'),
            'order.shipping_city.required' => translate('City is required'),
            'order.shipping_city.min' => translate('Minimum :min characters required'),
            'order.shipping_zip.required' => translate('ZIP code is required'),
            'order.shipping_zip.min' => translate('Minimum :min characters required'),

            'order.buyers_consent.is_true' => translate('You must agree with terms of service'),

            'selected_payment_method.required' => translate('Please select payment method'),
            'selected_payment_method.in' => translate('Payment method can only be one of the following:').' '.Payments::getPaymentMethodsName()->join(', '),

            'cc_expiration_date.required' => translate('CC expiration date is required'),
            'cc_cvc.required' => translate('Card CVC is required'),
            'cc_number.card_invalid' => translate('Card is invalid'),
        ], $this->getWEFMessages());
    }

    public function getWEFRules() {
        return apply_filters('checkout-form.rules.wef', [
            'wef.billing_entity' => ['in:individual,company'],
            'wef.billing_company_vat' => ['nullable'],
            'wef.billing_company_code' => ['nullable'],
        ]);
    }

    public function getWEFMessages() {
        return apply_filters('checkout-form.messages.wef', [
            'wef.billing_entity.in' => translate('Customer entity can only be individual or company')
        ]);
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

        $this->initCoreMeta($this->order);

        if (auth()->user()?->id ?? false) {
            $this->order->email = auth()->user()->email;
            $this->order->billing_first_name = auth()->user()->name;
            $this->order->billing_last_name = auth()->user()?->name;

            $this->wef['billing_entity'] = auth()->user()->entity;

            if(auth()->user()->entity === 'company') {
                $this->order->billing_company = auth()->user()->getUserMeta('company_name') ?? '';
                $this->wef['billing_company_code'] = auth()->user()->getUserMeta('company_registration_number') ?? '';
                $this->wef['billing_company_vat'] = auth()->user()->getUserMeta('company_vat') ?? '';
            }
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
        return view('livewire.forms.checkout-form');
    }

    protected function getSpecificRules()
    {
        
    }

    public function pay()
    {
        $this->items = CartService::getItems();
        
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }
        
        DB::beginTransaction();

        try {
            $payment_method = PaymentMethodUniversal::where('gateway', $this->selected_payment_method)->first();

            $default_grace_period = 5; // 5 days is default grace period
            $default_due_date = Carbon::now()->addDays(7)->toDateTimeString(); // 7 days fom now is default invoice due_date
            $user = auth()->user() ?? null;

            if (! Auth::check()) {
                $user = AuthService::createGhostUserOnCheckout($this->order);
            }

            // TODO: THIS IS VERY IMPORTANT - Separate $items based on shop_ids and create multiple orders
            $this->order->shop_id = $this->items->first()->shop_id;
            $this->order->user_id = $user->id ?? null;

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

                if(empty($this->order->phone_numbers)) {
                    // Overwrite order phones only if they are not added first, but address is selected 
                    $this->order->phone_numbers = $address->phones;
                }
            }

            /*
             * Shipping data (when billing and shipping data are not the same)
             * Address (user logged-in) + Manual
             */
            $this->order->shipping_first_name = $this->order->billing_first_name;
            $this->order->shipping_last_name = $this->order->billing_last_name;
            $this->order->shipping_company = $this->order->billing_company;

            if (empty($this->order->same_billing_shipping)) {
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
            $this->order->tax = CartService::getGlobalTaxPercentage();

            // payment_status - `unpaid` by default (this should be changed on payment processor callback before Thank you page is shown - if payment goes through of course)
            // shipping_status - `not_sent` by default (this is changed manually in Order management pages by company staff)
            // viewed - is 0 by default (if it's not viewed by company stuff, it'll be marked as `New` in company dashboard)

            $this->order->save();

            /*
             * Create OrderItem(s)
             */
            foreach ($this->items as $item) {
                if(empty($item->purchase_quantity))
                    continue; // Skip item if purchase quantity is something other than > 0

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
                $order_item->subtotal_price = ($order_item->quantity * $item->base_price) - $order_item->discount_amount;
                $order_item->tax = $order_item->subtotal_price * CartService::getGlobalTaxPercentage() / 100;
                $order_item->total_price = $order_item->subtotal_price + $order_item->tax;

                $order_item->save();
            }

            $this->order->load(['order_items', 'user']);

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
            
            $invoice->setInvoiceNumber($payment_method);

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
            $invoice->tax = CartService::getTaxAmount()['raw'];
            $invoice->shipping_cost = 0; // TODO: Don't forget to change this when shipping mechanism is created
            $invoice->total_price = CartService::getTotalPrice()['raw'];

            // TODO: Add Shop Settings for general due_date and grace_period
            $invoice->start_date = $this->order->invoicing_start_date; // current unix_timestamp (for non-trial plans)
            $invoice->due_date = null; // Default due_date is NULL days for subscription (if not trial mode, if it's trial it's null)
            $invoice->grace_period = $this->order->invoice_grace_period; // NULL; or 5 days grace_period by default

            $invoice->save();

            do_action('checkout.process', $this->order, $invoice);

            DB::commit();

            $invoice->setRealInvoiceNumber();

            // Full cart reset
            CartService::fullCartReset();

            return redirect()->route('checkout.execute.custom.payment', ['invoice_id' => $invoice->id, 'payment_gateway' => $payment_method->gateway] );
            // return redirect()->route('checkout.order.received', $this->order->id);
        } catch (\Throwable $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while processing the order...Please try again.'));
            dd($e);
        }
    }
}
