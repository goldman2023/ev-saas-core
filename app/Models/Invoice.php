<?php

namespace App\Models;

use MyShop;
use App\Enums\UserEntityEnum;
use App\Builders\BaseBuilder;
use App\Traits\HasDataColumn;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use StripeService;
use LaravelDaily\Invoices\Invoice as LaravelInvoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

/**
 * App\Models\Invoice
 */
class Invoice extends WeBaseModel
{
    use SoftDeletes;
    use HasDataColumn;

    protected $table = 'invoices';

    protected $guarded = ['id'];

    protected $connection = 'tenant'; // Don't understand why this is necessary but it is! It should pick up tenant connection from Builder, but that's not working for Invoice model o_0

    protected $fillables = ['is_temp', 'mode', 'order_id', 'shop_id', 'user_id', 'payment_method_type', 'payment_method_id', 'invoice_number', 'email', 'billing_first_name','billing_last_name','billing_company', 'billing_address', 'billing_country',
                'billing_state', 'billing_city', 'billing_zip', 'base_price', 'discount_amount', 'subtotal_price', 'total_price','shipping_cost', 'tax', 'payment_status',
                'start_date', 'end_date', 'due_date', 'grace_period', 'viewed_by_customer', 'meta', 'note', 'created_at', 'updated_at'];

    protected $casts = [
        'viewed_by_customer' => 'boolean',
        'is_temp' => 'boolean',
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
            return false;
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

    public function getRealInvoiceNumber($fallback = false) {
        if($fallback && empty($this->real_invoice_number)) {
            return $this->invoice_number;
        }

        return $this->real_invoice_prefix.str_pad((string) $this->real_invoice_number, 5, '0', STR_PAD_LEFT);
    }

    public function setRealInvoiceNumber() {
        if($this->is_temp === false && $this->total_price > 0) {
            $this->real_invoice_prefix = get_tenant_setting('invoice_prefix');

            if($this->mode === 'live') {
                $this->real_invoice_number = (Invoice::where('total_price', '>', 0)->where('mode', 'live')->where('is_temp', 0)->latest()->first()?->real_invoice_number ?? 0) + 1;
            } else {
                $this->real_invoice_number = (Invoice::where('total_price', '>', 0)->where('mode', 'test')->where('is_temp', 0)->latest()->first()?->real_invoice_number ?? 0) + 1;
            }
        }
    }

    public function generateInvoicePDF() {
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
                    if(\Countries::isEU($company_country) && !empty($company_vat)) {
                        $notes[] = '“Reverse Charge”  PVMĮ 13str. 2 d.';
                        $customer_custom_fields['VAT no.'] = $company_vat;
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
                'company' => $this->getData('customer.company_name', ''),
                'address' => $this->billing_address.', '.$this->billing_zip
            ], $customer_custom_fields);

            $customer = new Party([
                // 'name'          => $this->billing_first_name.' '.$this->billing_last_name,
                'custom_fields' => $customer_custom_fields,
            ]);
        } else {
            $customer = new Party([
                'name'          => $this->user->name.' '.$this->user->surname,
                'address'       => $this->billing_address.', '.$this->billing_zip,
                'custom_fields' => $customer_custom_fields,
            ]);
        }
        


        $invoice_items = [];

        foreach($this->order->order_items as $item) {
            if($this->isFromStripe()) {
                $stripe_product_id = $item->subject->getCoreMeta(stripe_prefix('stripe_product_id'));

                // In order to identify correct line item, 2 conditions must be met:
                // 1. productID must be $stripe_product_id,
                // 2. proration property must be FALSE (cuz invoice items can be proration items with the same $stripe_product_id),
                $stripe_line_item = $stripe_line_items->filter( fn($item) => $item['price']['product'] === $stripe_product_id && $item['proration'] === false)->first();
                
                if(!empty($stripe_line_item)) {
                    $li_name = $item->name;

                    if($item->subject->isSubscribable()) {
                        $li_name = $item->name.' / '.$stripe_line_item['price']['recurring']['interval'].' ('.\Carbon::createFromTimestamp($this->start_date)->format('d M, Y').' - '.\Carbon::createFromTimestamp($this->end_date)->format('d M, Y').')';
                    }

                    $invoice_items[] = (new InvoiceItem())
                        ->title($li_name)
                        ->description($item->excerpt)
                        ->pricePerUnit($item->base_price)
                        ->quantity($stripe_line_item['quantity'])
                        ->discount($item->discount_amount)
                        ->subTotalPrice($stripe_line_item['amount_excluding_tax'] / 100);
                }                
            } else {
                $invoice_items[] = (new InvoiceItem())
                    ->title(translate(''))
                    ->description($item->excerpt)
                    ->pricePerUnit($item->base_price)
                    ->quantity($item->quantity)
                    ->discount($item->discount_amount)
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
            'total_taxes_label' => $total_taxes_label,
        ];
        
        $invoice = LaravelInvoice::make('VAT Invoice')
            ->series(!empty($this->real_invoice_number) ? $this->getRealInvoiceNumber() : $this->invoice_number)
            // ->sequence()
            ->serialNumberFormat('{SERIES}')
            // ability to include translated invoice status
            // in case it was paid
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
            ->filename(!empty($this->real_invoice_number) ? $this->getRealInvoiceNumber() : $this->invoice_number)
            ->addItems($invoice_items)
            ->setCustomData($custom_data)
            ->notes($notes);

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

            // ->logo(public_path('vendor/invoices/sample-logo.png'))
            // You can additionally save generated invoice to configured disk
            // ->save('public');

        return $invoice->stream();
    }

    public function getRealTotalPrice($format = true) {
        if(is_array($invoice = $this->getData(stripe_prefix('stripe_invoice_data')))) {
            return $format ? \FX::formatPrice($invoice['amount_due'] / 100) : $invoice['amount_due'] / 100;
        }

        return $format ? \FX::formatPrice($this->total_price) : $this->total_price;
    }

    public function isTestMode() {
        return $this->keyExistsInData('test_stripe_invoice_id');
    }

    public function isFromStripe() {
        return $this->keyExistsInData('test_stripe_invoice_id') || $this->keyExistsInData('live_stripe_invoice_id');
    }

//    TODO: ORDER TRACKING NUMBER!!!
//    public function refund_requests()
//    {
//        return $this->hasMany(RefundRequest::class);
//    }
}
