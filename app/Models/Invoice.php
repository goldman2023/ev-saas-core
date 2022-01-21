<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Invoice
 */
class Invoice extends EVBaseModel
{
    use SoftDeletes;

    protected $table = 'invoices';

    protected $guarded = ['id'];

    protected $casts = [
        'viewed_by_customer' => 'boolean',
        'meta' => 'array',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'deleted_at' => 'datetime:d.m.Y H:i',
    ];

    protected $with = ['payment_method'];

    public const PAYMENT_STATUS = ['unpaid', 'pending', 'paid', 'canceled'];
    public const PAYMENT_STATUS_UNPAID = 'unpaid';
    public const PAYMENT_STATUS_PENDING = 'pending';
    public const PAYMENT_STATUS_CANCELED = 'canceled';
    public const PAYMENT_STATUS_PAID = 'paid';

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

    public function payment_method() {
        return $this->morphTo('payment_method');
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

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) => $query->where('id', 'like', '%'.$term.'%')
                ->orWhere('billing_first_name', 'like', '%'.$term.'%')
                ->orWhere('billing_last_name', 'like', '%'.$term.'%')
                ->orWhere('payment_status', 'like', '%'.$term.'%')
                ->orWhere('total_price', 'like', '%'.$term.'%')
        );
    }


    public static function trend($period = 30)
    {
        $present = Order::where('created_at', '>=', \Carbon::now()->subdays($period))->count();

        $past = Order::where('created_at', '<=', \Carbon::now()->subdays($period))->count();

        if ($present == 0) {
            $present = 1;
        }

        $percentChange = (1 - $past / $present) * 100;


        return $percentChange;
    }
}
