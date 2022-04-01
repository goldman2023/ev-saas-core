<?php

namespace App\Models;

use App\Builders\BaseBuilder;
use App\Facades\MyShop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\PermalinkTrait;

/**
 * App\Models\Order
 */
class Order extends EVBaseModel
{
    use SoftDeletes;
    use PermalinkTrait;

    protected $table = 'orders';

    protected $guarded = ['id'];

    protected $casts = [
        'phone_numbers' => 'array',
        'same_billing_shipping' => 'boolean',
        'viewed' => 'boolean',
        'meta' => 'array',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    public mixed $base_price;
    public mixed $discount_amount;
    public mixed $subtotal_price;
    public mixed $total_price;

    protected $with = ['order_items', 'invoices'];

    /**
     * Get the route name for the model.
     *
     * @return string
     */
    public static function getRouteName()
    {
        return 'checkout.order.received';
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'order_id', 'id');
    }

    public static function count()
    {
        return self::where('shop_id', MyShop::getShop()->id ?? null)->count();
    }

    protected static function booted()
    {
        // Show only MyShop Orders
        static::addGlobalScope('from_my_shop_or_me', function (BaseBuilder $builder) {
            $builder->where('shop_id', '=', MyShop::getShop()->id ?? -1)->orWhere('user_id', '=', auth()->user()->id);
        });

        // Get amounts/totals from $order_items and sum them to corresponding Orders core_properties - THEY ARE NOT SET DURING THE ORDER CREATION!!!
        static::relationsRetrieved(function ($order) {
            // TODO: These should depend on "invoices number x order_items"
            $sums_properties = ['base_price', 'discount_amount', 'subtotal_price', 'total_price'];
            $order->appendCoreProperties($sums_properties);
            $order->append($sums_properties);

            if(!empty($order->fillable))
                $order->fillable(array_unique(array_merge($order->fillable, $sums_properties)));

            $order->initCoreProperties();

            foreach($sums_properties as $property) {
                foreach($order->order_items as $item) {
                    $order->{$property} += $item->{$property};
                }
            }
        });
    }

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) =>  $query->where('id', 'like', '%'.$term.'%')
                ->orWhere('billing_first_name', 'like', '%'.$term.'%')
                ->orWhere('billing_last_name', 'like', '%'.$term.'%')
                ->orWhere('payment_status', 'like', '%'.$term.'%')
                ->orWhere('shipping_status', 'like', '%'.$term.'%')
//                ->orWhere('total_price', 'like', '%'.$term.'%')
        );
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
