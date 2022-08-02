<?php

namespace App\Models;

use MyShop;
use App\Builders\BaseBuilder;
use App\Traits\HasDataColumn;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    protected $fillables = ['is_temp', 'order_id', 'shop_id', 'user_id', 'payment_method_type', 'payment_method_id', 'invoice_number', 'email', 'billing_first_name','billing_last_name','billing_company', 'billing_address', 'billing_country',
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
                ->orWhere('email', 'like', '%'.$term.'%')
                ->orWhere('billing_first_name', 'like', '%'.$term.'%')
                ->orWhere('billing_last_name', 'like', '%'.$term.'%')
                ->orWhere('payment_status', 'like', '%'.$term.'%')
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

        return $this->real_invoice_prefix.'-0000'.$this->real_invoice_number;
    }

    public function setRealInvoiceNumber() {
        if($this->is_temp === false && $this->total_price > 0) {
            $this->real_invoice_number = Invoice::where('total_price', '>', 0)->where('is_temp', 0)->count() + 1;
            $this->real_invoice_prefix = get_tenant_setting('invoice_prefix');
        }
    }

    public function generateInvoicePDF() {
        $shop = $this->shop;

        $business = new Party([
            'name'          => get_tenant_setting('company_name'),
            // 'phone'         => is_array($shop->phones) ? implode(',', $shop->phones) : '',
            'custom_fields' => [
                'address' => get_tenant_setting('company_address'),
                'city' => get_tenant_setting('company_city'),
                'country' => get_tenant_setting('company_country'),
                'postal_code' => get_tenant_setting('company_postal_code'),
                'email' => get_tenant_setting('company_email'),
                'VAT no.' => get_tenant_setting('company_vat'),
                'Company no.' => get_tenant_setting('company_number'),
            ],
        ]);

        $customer = new Party([
            'name'          => $this->billing_first_name.' '.$this->billing_last_name,
            'address'       => $this->billing_address.', '.$this->billing_zip,
            // 'code'          => '#'.$this->id,
            'custom_fields' => [
                'city' => $this->billing_city,
                'country' => \Countries::get(code: $this->billing_country)?->name ?? $this->billing_country,
                'email' => $this->email,
                'order number' => '#'.$this->order->id,
            ],
        ]);

        $invoice_items = [];

        foreach($this->order->order_items as $item) {
            $invoice_items[] = (new InvoiceItem())
                    ->title($item->name)
                    ->description($item->excerpt)
                    ->pricePerUnit($item->base_price)
                    ->quantity($item->quantity)
                    ->discount($item->discount_amount)
                    ->subTotalPrice(($item->base_price - $item->discount_amount) * $item->quantity);
        }

        // Tax notes
        

        $notes = [
            'your multiline',
            'additional notes',
            'in regards of delivery or something else',
        ];
        $notes = implode("<br>", $notes);

        $invoice = LaravelInvoice::make('Invoice')
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
            ->totalTaxes($this->tax)
            ->notes($notes);
            // ->logo(public_path('vendor/invoices/sample-logo.png'))
            // You can additionally save generated invoice to configured disk
            // ->save('public');

        return $invoice->stream();
    }

//    TODO: ORDER TRACKING NUMBER!!!
//    public function refund_requests()
//    {
//        return $this->hasMany(RefundRequest::class);
//    }
}
