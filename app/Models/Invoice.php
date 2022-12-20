<?php

namespace App\Models;

use MyShop;
use StripeService;
use App\Facades\Media;
use App\Facades\Payments;
use App\Traits\UploadTrait;
use App\Enums\OrderTypeEnum;
use App\Builders\BaseBuilder;
use App\Enums\UserEntityEnum;
use App\Traits\HasDataColumn;
use App\Traits\TemporaryTrait;
use Illuminate\Support\Carbon;
use App\Facades\TenantSettings;
use App\Enums\PaymentStatusEnum;
use App\Models\PaymentMethodUniversal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use LaravelDaily\Invoices\Classes\Party;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice as LaravelInvoice;

/**
 * App\Models\Invoice
 */
class Invoice extends WeBaseModel
{
    use SoftDeletes;
    use HasDataColumn;
    use TemporaryTrait;
    use UploadTrait;


    protected $table = 'invoices';

    protected $guarded = ['id'];

    protected $connection = 'tenant'; // Don't understand why this is necessary but it is! It should pick up tenant connection from Builder, but that's not working for Invoice model o_0

    protected $fillables = ['is_temp', 'mode', 'order_id', 'shop_id', 'user_id', 'payment_method_type', 'payment_method_id', 'invoice_number', 'email', 'billing_first_name','billing_last_name','billing_company', 'billing_address', 'billing_country',
                'billing_state', 'billing_city', 'billing_zip', 'base_price', 'discount_amount', 'subtotal_price', 'total_price','shipping_cost', 'tax', 'payment_status',
                'start_date', 'end_date', 'due_date', 'grace_period', 'viewed_by_customer', 'meta', 'note', 'created_at', 'updated_at'];

    protected $casts = [
        'viewed_by_customer' => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'deleted_at' => 'datetime:d.m.Y H:i',
    ];

    protected $with = ['payment_method'];

    protected static function booted()
    {
        // Display only real invoices (is_temp = 0)
        static::addGlobalScope('real_invoices', function (BaseBuilder $builder) {
            $builder->real();
        });

        // Restrict to MyShop and My invoices
        static::addGlobalScope('skip_negative_invoices', function (BaseBuilder $builder) {
            $builder->where('total_price', '>', 0);
        });
    }

    public function getDataColumnName()
    {
        return 'meta';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function payment_method()
    {
        return $this->morphTo('payment_method');
    }

    public function scopeMy($query)
    {
        return $query->where('user_id', '=', auth()->user()?->id ?? null);
    }

    public function scopeShopInvoices($query)
    {
        return $query->where('shop_id', '=', MyShop::getShop()?->id ?? -1);
    }

    public function scopeReal($query) {
        // Invoices are real if is_temp is 0/false
        return $query->where('is_temp', '=', 0);
    }
    
    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) => $query->where('id', 'like', '%'.$term.'%')
                ->orWhere('invoice_number', 'like', '%'.$term.'%')
                ->orWhere('real_invoice_number', 'like', '%'.$term.'%') // TODO: How to search by real invoice number???
                ->orWhere('real_invoice_prefix', 'like', '%'.$term.'%')
                ->orWhere('email', 'like', '%'.$term.'%')
                ->orWhere('billing_first_name', 'like', '%'.$term.'%')
                ->orWhere('billing_last_name', 'like', '%'.$term.'%')
                // ->orWhere('payment_status', 'like', '%'.$term.'%')
                ->orWhere('total_price', 'like', '%'.$term.'%')
        );
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [
            [
                'property_name' => 'invoice_document',
                'relation_type' => 'invoice',
                'folder' => 'invoices/',
                'multiple' => true,
            ],
        ];
    }

    /*
     * This functions determines if current Invoice is actually the last invoice of an Order this invoice is related to.
     *
     * There are three possible scenarios:
     * 1. Standard order - one invoice is generated and invoice is always last
     * 2. Subscription order - x invoices are generated and invoice is never last
     * 3. Installments - Invoice can be last if Number_of_invoices is reached
     */
    public function isLastInvoice()
    {
        if ($this->order->type === OrderTypeEnum::standard()->value) {
            return true;
        } elseif ($this->order->type === OrderTypeEnum::subscription()->value) {
            return false; // TODO: should actually check if it's really last invoice for current period...
        } elseif ($this->order->type === OrderTypeEnum::installments()->value) {
            return $this->order->number_of_invoices === $this->order->invoices()->count();
        }
    }

    public static function generateInvoiceNumber($first_name, $last_name, $company_name)
    {
        // TODO: Add invoicing number template to Shop settings, otherwise use Default
        $random_number = random_int(0, 100000);
        $current_date = date('dmY');
        $first_name_char = strtoupper($first_name[0] ?? 'x');
        $last_name_char = strtoupper($last_name[0] ?? 'y');
        $company_name_char = strtoupper($company_name[0] ?? '');

        return $current_date.$first_name_char.$last_name_char.$company_name_char.$random_number;
    }

    public function getRealInvoiceNumber($fallback = false) {
        if($fallback && empty($this->real_invoice_number)) {
            return $this->invoice_number;
        }

        return $this->real_invoice_prefix.str_pad((string) $this->real_invoice_number, 5, '0', STR_PAD_LEFT);
    }

    public function setRealInvoiceNumber() {
        // Dispatch a jobin order to avoid race-conditioning
        dispatch(function() {
            if($this->is_temp === false && $this->total_price > 0 && $this->payment_status === PaymentStatusEnum::paid()->value) {
            
                $this->real_invoice_prefix = \DB::table('tenant_settings')
                    ->select('setting', 'value')
                    ->where('setting', '=', 'invoice_prefix')
                    ->first()->value ?? '';

                    // TODO: Try to load TenantSettings somehow, it's not working (not getting the data from `tenant_settings` table)...

                if($this->mode === 'live') {
                    $this->real_invoice_number = (Invoice::where('total_price', '>', 0)
                        ->where('mode', 'live')
                        ->where('is_temp', 0)
                        ->where('id', '!=', $this->id)
                        ->orderBy('real_invoice_number', 'DESC')
                        ->first()?->real_invoice_number ?? 0) + 1;
                } else {
                    $this->real_invoice_number = (Invoice::where('total_price', '>', 0)
                        ->where('mode', 'test')
                        ->where('is_temp', 0)
                        ->where('id', '!=', $this->id)
                        ->orderBy('real_invoice_number', 'DESC')
                        ->first()?->real_invoice_number ?? 0) + 1;
                }

                $this->save();
            }
        });
    }
    
    /**
     * setInvoiceNumber
     *
     * This function sets invoice number(s) based on specified payment_method and app settings.
     * Logic:
     * 1. Non-payment-processor method (cash-on-delivery/wire-transfer) - invoice_number and real invoice number are same
     * 2. Payment-processor method (stripe/paysera/paypal etc.) - invoice_number and real invoice number can differ based on app settings
     * 
     * @param mixed $payment_method 
     * @return void
     */
    public function setInvoiceNumber($payment_method = null) {
        $payment_method = $payment_method instanceof PaymentMethodUniversal ? $payment_method : $this->payment_method()->first();

        if($payment_method->isPaymentProcessorGateway()) {
            // Payment-processor method
            // IMPORTANT: We are making draft-invoice here because if payment method is payment-processor - Webhooks will determine the invoice_number and real_invoice_number!
            $this->invoice_number = 'invoice-draft-'.Uuid::generate(4)->string;
        } else {
            // Non-payment-processor method -> 1) set real_invoice_prefx and number and make invoice_number combination of the previous two.
            $this->real_invoice_prefix = !empty(get_tenant_setting('invoice_prefix')) ? get_tenant_setting('invoice_prefix') : 'invoice-';

            if($this->mode === 'live') {
                $this->real_invoice_number = (Invoice::where('total_price', '>', 0)->where('mode', 'live')->where('is_temp', 0)->where('id', '!=', $this->id)->latest()->first()?->real_invoice_number ?? 0) + 1;
            } else {
                $this->real_invoice_number = (Invoice::where('total_price', '>', 0)->where('mode', 'test')->where('is_temp', 0)->where('id', '!=', $this->id)->latest()->first()?->real_invoice_number ?? 0) + 1;
            }

            $this->invoice_number = $this->real_invoice_prefix . $this->real_invoice_number;
        }
    }

    public function generateInvoicePDF($custom_title = null, $save = false) {
        $shop = $this->shop;
        $user = $this->user;

        $customer_custom_fields = [
            'city' => $this->billing_city,
            'country' => \Countries::get(code: $this->billing_country)?->name ?? $this->billing_country,
            'email' => $this->email,
            'order number' => '#'.$this->order->id,
        ];

        // Tax notes
        // TODO: Add this part as a filter!!!!!!!!!
        
        $notes = [];

        if($this->isFromStripe()) {
            $stripe_invoice = $this->getData(stripe_prefix('stripe_invoice_data'));

            if(empty($stripe_invoice)) {
                $stripe_invoice = \StripeService::stripe()->invoices->retrieve(
                    $this->getData(stripe_prefix('stripe_invoice_id')),
                    []
                );
                
                if(!empty($stripe_invoice)) {
                    $this->setData(stripe_prefix('stripe_invoice_data'), $stripe_invoice->toArray());
                    $this->saveQuietly();
                }
            }

            // Get line items from stripe invoice
            $stripe_line_items = collect($stripe_invoice['lines']['data']);
        }

        if($user->entity === UserEntityEnum::company()->value) {
            // Company
            $company_country = $this->billing_country;
            $company_vat = $this->getData('customer.vat');
            $company_registration_number = $this->getData('customer.company_registration_number');
            
            if(!empty($company_country) && !empty(\Countries::get(code: $company_country))) {
                // Override company country
                $customer_custom_fields['country'] = \Countries::get(code: $this->billing_country)->name; // TODO: Which country to use? From our system or from Stripe billing info?

                if($company_country === 'LT') {
                    $customer_custom_fields['company no.'] = $company_registration_number;

                    if(!empty($company_vat)) {
                        $customer_custom_fields['VAT no.'] = $company_vat;
                    }
                } else {
                    // TODO: Should we push notes through theme-functions, no? These noets are for PixPro
                    if(\Countries::isEU($company_country) && !empty($company_vat)) {
                        $notes[] = '“Reverse Charge”  PVMĮ 13str. 2 d.';
                        $customer_custom_fields['VAT no.'] = $company_vat;
                    } else if(\Countries::isEU($company_country)) {
                        $customer_custom_fields['company no.'] = $company_registration_number;
                    } else {
                        $notes[] = 'PVMĮ 13str. 2 d.';
                        $customer_custom_fields['company no.'] = $company_registration_number;
                    }
                }
            }
        } else {
            // Individual
            if($this->isFromStripe()) {
                $country = $stripe_invoice['customer_address']['country'];
            } else {
                $country = $this->billing_country;
            }

            if(!empty($country) && !empty(\Countries::get(code: $country))) {
                if($country === 'LT') {
                    
                } else {
                    if(\Countries::isEU($country)) {
                        // $notes[] = '“Reverse Charge”  PVMĮ 13str. 2 d.';
                    } else {
                        $notes[] = 'PVMĮ 13 str. 14 d.';
                    }
                }
                
            }
        }

        
        $notes = implode("<br>", $notes);


        $business = new Party([
            'name'          => get_tenant_setting('company_name'),
            // 'phone'         => is_array($shop->phones) ? implode(',', $shop->phones) : '',
            'custom_fields' => [
                'address' => get_tenant_setting('company_address'),
                'city' => get_tenant_setting('company_city'),
                'country' => get_tenant_setting('company_country'),
                'postal code' => get_tenant_setting('company_postal_code'),
                'email' => get_tenant_setting('company_email'),
                'VAT no.' => get_tenant_setting('company_vat'),
                'Company no.' => get_tenant_setting('company_number'),
            ],
        ]);

        if($this->user->entity === UserEntityEnum::company()->value) {
            $customer_custom_fields = array_merge([
                'company' => !empty($this->billing_company) ? $this->billing_company : $this->getData('customer.company_name', ''),
                'address' => $this->billing_address.', '.$this->billing_zip
            ], $customer_custom_fields);

            // TODO: This should actually depend on Invoice App Settings!
            // Like switch called: `display billing first and last name if purchase is made as company`
            $args = [];
            if(! $this->payment_method->isPaymentProcessorGateway()) {
                $args['name'] = $this->billing_first_name.' '.$this->billing_last_name;
            }
            $args['custom_fields'] = $customer_custom_fields;

            $customer = new Party($args);
        } else {
            $customer = new Party([
                'name'          => $this->user->name.' '.$this->user->surname,
                'address'       => $this->billing_address.', '.$this->billing_zip,
                'custom_fields' => $customer_custom_fields,
            ]);
        }

        
        // Start: Invoice Items
        /**
         * Important: There are two levels of discounts:
         * 1. Discouts on order_items level - for example: yearly discount etc.
         * 2. Discounts on order/invoice level - for example: coupon etc.
         * 
         * IMPORTANT: getDiscountAmount() - gets all discounts applied to the current invoice
         * In order to get discounts on order/invoice level, we must subtract 1. from getDiscountAmount()
         * 
         * TODO: Find a better way to manage and calculate discounts on these levels!!!
         */
        $invoice_items = [];
        $sum_invoice_items_discounts = 0; // Sum of all discounts on invoice items level!

        if($this->isFromStripe()) {
            foreach($stripe_line_items as $item) {
                $stripe_line_item = $item;
                $item = get_model_by_stripe_product_id($stripe_line_item['price']['product']);

                // TODO: THIS IS WRONG APPROACH! Refer to: https://app.asana.com/0/1201702153260545/1203549791108170
                $order_item = $this->order->order_items->where('subject_id', $item->id)->where('subject_type', $item::class)->first();

                if(!empty($stripe_line_item) && !empty($item)) {
                    $li_name = $item->name;

                    if($item->isSubscribable()) {
                        if($stripe_invoice['billing_reason'] === 'upcoming') {
                            $li_name = $item->name.' / '.$stripe_line_item['price']['recurring']['interval'];
                        } else {
                            $li_name = $item->name.' / '.$stripe_line_item['price']['recurring']['interval'].' ('.\Carbon::createFromTimestamp($this->start_date)->format('d M, Y').' - '.\Carbon::createFromTimestamp($this->end_date)->format('d M, Y').')';
                        }
                    }

                    if($stripe_line_item['proration']) {
                        $invoice_items[] = (new InvoiceItem())
                            ->title($stripe_line_item['description'])
                            ->pricePerUnit($stripe_line_item['amount_excluding_tax'] / 100)
                            ->quantity($stripe_line_item['quantity'])
                            ->discount(0)
                            ->subTotalPrice($stripe_line_item['amount_excluding_tax'] / 100);
                    } else {
                        if($stripe_line_item['price']['recurring']['interval'] === 'year') {
                            $unit_price = $order_item->base_price;
                            $discount = $order_item->discount_amount;
                            $subtotal = $stripe_line_item['amount_excluding_tax'] / 100;
                        } else if($stripe_line_item['price']['recurring']['interval'] === 'month') {
                            $unit_price = $stripe_line_item['price']['unit_amount'] / 100;
                            $discount = $item->discount_amount ?? 0;
                            $subtotal = $stripe_line_item['amount_excluding_tax'] / 100;
                        }

                        $sum_invoice_items_discounts += $discount;

                        $invoice_items[] = (new InvoiceItem())
                            ->title($li_name)
                            ->description($item->excerpt ?? '')
                            ->pricePerUnit($unit_price)
                            ->quantity($stripe_line_item['quantity'])
                            ->discount($discount)
                            ->subTotalPrice($subtotal);
                    }
                }  
            }
        } else {
            foreach($this->order->order_items as $item) {
                $invoice_items[] = (new InvoiceItem())
                    ->title($item->name)
                    ->description($item->excerpt ?? '')
                    ->pricePerUnit($item->base_price)
                    ->quantity($item->quantity)
                    ->discount($item->discount_amount ?? 0)
                    ->subTotalPrice(($item->base_price - $item->discount_amount) * $item->quantity);
            }
        }

        // Append Credit discounts and adjustments if there's any proration
        if($this->isFromStripe()) {
            if($stripe_invoice['starting_balance'] < 0) {
                $invoice_items[] = (new InvoiceItem())
                    ->title(translate('Credit adjustments'))
                    ->description(translate('Sum of previous prorated credits'))
                    ->pricePerUnit($stripe_invoice['starting_balance'] / 100)
                    ->quantity(1)
                    ->subTotalPrice($stripe_invoice['starting_balance'] / 100);
            }   
        }
        // End: Invoice Items

        // if(empty($total_taxes_label = $this->getData(stripe_prefix('total_taxes_label')))) {
        //     if(!empty($stripe_invoice['total_tax_amounts']) && !empty($stripe_invoice['total_tax_amounts'][0]['tax_rate'] ?? null)) {
        //         // Get tax rate for this invoice and store it

        //         // TODO: If "VAT OSS is enabled" (uncomment below):
        //         // $tax_rate = StripeService::stripe()->taxRates->retrieve(
        //         //     $stripe_invoice['total_tax_amounts'][0]['tax_rate'],
        //         //     []
        //         // );

        //         // $total_taxes_label = !empty($tax_rate->description) ? $tax_rate->description : $tax_rate->display_name.' '.$tax_rate->jurisdiction;
        //         // $total_taxes_label = $total_taxes_label.' ('.(int) $tax_rate->percentage.'%)';

        //         // DONE: If "VAT Small seller - EU" is enabled

        //         $total_taxes_label = 'VAT '.\Countries::get(code: $stripe_invoice['account_country']).' ('.(int) get_tenant_setting('company_tax_rate').'%)';

        //         $this->setData(stripe_prefix('total_taxes_label'), $total_taxes_label);
        //         $this->saveQuietly();
        //     }
        // }

        // DONE: If "VAT Small seller - EU" is enabled
        $total_taxes_label = 'VAT ('.(int) get_tenant_setting('company_tax_rate').'%)';
        
        // Set custom data
        $custom_data = [
            'total_discount' => $this->getDiscountAmount(false) - $sum_invoice_items_discounts, // Subtract sum of discounts on invoice items level from discount amount on invoice level!
            'total_taxes_label' => $total_taxes_label,
            'via_payment_method' => function() {
                return match ($this->getPaymentMethodGateway()) {
                    'stripe' => translate('Via Stripe'),
                    'paypal' => translate('Via Paypal'),
                    'paysera' => translate('Via Paysera'),
                    'wire_transfer' => translate('Via Bank Transfer'),
                };
            }
        ];
        
        $invoice = LaravelInvoice::make(!empty($custom_title) ? $custom_title : translate('VAT Invoice'))
            ->series(!empty($this->real_invoice_number) ? $this->getRealInvoiceNumber() : $this->invoice_number)
            // ->sequence()
            ->serialNumberFormat('{SERIES}')
            // ability to include translated invoice status
            // in case it was paid
            ->filename(\Str::slug($custom_title).'_'.$this->getRealInvoiceNumber())
            ->status($this->payment_status)
            ->seller($business)
            ->buyer($customer)
            ->date($this->created_at)
            ->dateFormat('d M, Y')
            ->payUntilDays(!empty($this->due_date) ? $this->created_at->diffInDays(Carbon::createFromTimestamp($this->due_date)) : 0)
            ->currencySymbol('€')
            ->currencyCode('EUR')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->addItems($invoice_items)
            ->setCustomData($custom_data)
            ->notes($notes);

            if($save) {
                $invoice_path = Media::getTenantPath('invoices').'/'.(!empty($this->real_invoice_number) ? $this->getRealInvoiceNumber() : $this->invoice_number);

                $invoice
                    ->filename($invoice_path)
                    ->save(config('filesystems.default'));

                return $invoice_path.'.pdf';
            }
            

        if($this->isFromStripe()) {
            if($stripe_invoice['tax'] / 100 > 0) {
                $invoice->totalTaxes($stripe_invoice['tax'] / 100);
            }

            $invoice
                // ->totalDiscount( ($stripe_invoice['subtotal_excluding_tax'] / 100) - ($stripe_invoice['total_excluding_tax'] / 100) )
                ->taxableAmount($stripe_invoice['total_excluding_tax'] / 100)
                ->totalAmount($stripe_invoice['amount_due'] / 100);
        } else {
            if($this->tax > 0) {
                $invoice->totalTaxes($this->tax);
            }
        }

        return $invoice->stream();
    }

    public function getRealTotalPrice($format = true) {
        if(is_array($invoice = $this->getData(stripe_prefix('stripe_invoice_data')))) {
            return $format ? \FX::formatPrice($invoice['amount_due'] / 100) : $invoice['amount_due'] / 100;
        }

        return $format ? \FX::formatPrice($this->total_price) : $this->total_price;
    }

    public function getDiscountAmount($format = true) {
        if(is_array($invoice = $this->getData(stripe_prefix('stripe_invoice_data')))) {
            if(!empty($invoice['total_discount_amounts'])) {
                $discount = array_reduce($invoice['total_discount_amounts'], function($carry, $item) {
                    $carry += $item['amount'];
                    return $carry;
                });

                return $format ?  \FX::formatPrice($discount / 100) : ($discount / 100);
            }
        }

        return $format ? \FX::formatPrice($this->discount_amount) : $this->discount_amount;
    }

    public static function getDaysFromPeriod($period) {
        if($period === 'year') {
            return 365;
        } else if($period === 'month') {
            return 30;
        } else if($period === 'week') {
            return 7;
        } else if($period === 'day') {
            return 1;
        }
    }

    public function isForStandard() {
        return $this->order->type === OrderTypeEnum::standard()->value;
    }

    public function isForSubscription() {
        return $this->order->type === OrderTypeEnum::subscription()->value;
    }

    public function isTestMode() {
        return $this->keyExistsInData('test_stripe_invoice_id');
    }

    public function isFromStripe() {
        return $this->keyExistsInData('test_stripe_invoice_id') || $this->keyExistsInData('live_stripe_invoice_id');
    }

    public function getStripeInvoiceID() {
        return $this->getData(stripe_prefix('stripe_invoice_id'));
    }

    public function getStripeInvoice() {
        return \StripeService::stripe()->invoices->retrieve(
            $this->getStripeInvoiceID(),
            []
        );
    }

    // Check payment method
    public function getPaymentMethodGateway() {
        if(PaymentMethodUniversal::class === $this->payment_method_type) {
            foreach(Payments::getPaymentMethodsAll() as $method) {
                if($method->id === $this->payment_method_id) {
                    return $method->gateway;
                }
            }
        }
    }

//    TODO: ORDER TRACKING NUMBER!!!
//    public function refund_requests()
//    {
//        return $this->hasMany(RefundRequest::class);
//    }
}
