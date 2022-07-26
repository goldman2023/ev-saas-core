<?php

namespace App\Models;

use MyShop;
use App\Builders\BaseBuilder;
use App\Traits\HasDataColumn;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

//    TODO: ORDER TRACKING NUMBER!!!
//    public function refund_requests()
//    {
//        return $this->hasMany(RefundRequest::class);
//    }
//    public function pickup_point()
//    {
//        return $this->belongsTo(PickupPoint::class);
//    }
//    public function affiliate_log()
//    {
//        return $this->hasMany(AffiliateLog::class);
//    }
//
//    public function club_point()
//    {
//        return $this->hasMany(ClubPoint::class);
//    }
}
