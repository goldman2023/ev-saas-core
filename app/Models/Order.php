<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Order
 */
class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $guarded = ['id'];

    protected $casts = [
        'phone_numbers' => 'array',
        'same_billing_shipping' => 'boolean',
        'viewed' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function order_items() {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }


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
