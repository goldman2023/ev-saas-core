<?php

namespace App\Models;

use App\Builders\BaseBuilder;
use App\Facades\MyShop;
use App\Traits\PermalinkTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Order
 */
class Order extends WeBaseModel
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
        'is_temp' => 'boolean',
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

    public function user_subscriptions()
    {
        return $this->hasMany(UserSubscription::class, 'order_id', 'id');
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
        // static::addGlobalScope('from_my_shop_or_me', function (BaseBuilder $builder) {
        //     $builder->where('shop_id', '=', MyShop::getShop()?->id ?? -1)->orWhere('user_id', '=', auth()->user()?->id ?? null);
        // });

        // Get amounts/totals from $order_items and sum them to corresponding Orders core_properties - THEY ARE NOT SET DURING THE ORDER CREATION!!!
        static::relationsRetrieved(function ($order) {
            // TODO: These should depend on "invoices number x order_items"
            $sums_properties = ['base_price', 'discount_amount', 'subtotal_price', 'total_price'];
            $order->appendCoreProperties($sums_properties);
            $order->append($sums_properties);

            if (! empty($order->fillable)) {
                $order->fillable(array_unique(array_merge($order->fillable, $sums_properties)));
            }

            $order->initCoreProperties();

            foreach ($sums_properties as $property) {
                foreach ($order->order_items as $item) {
                    // if($item->subject->isSubscribable() && $order->invoicing_period === 'year') {
                    //     $order->{$property} += $item->{$property} * $item->quantity;
                    // } else {
                        $order->{$property} += $item->{$property} * $item->quantity;
                    // }
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
        );
    }

    public function scopeMy($query)
    {
        return $query->where('user_id', '=', auth()->user()?->id ?? null);
    }

    public function scopeShopOrders()
    {
        return $query->where('shop_id', '=', MyShop::getShop()?->id ?? -1);
    }

    public function scopeAbandoned($query)
    {
        return $query->where('is_temp', '=', 1);
    }

    // All possible Order statuses
    public function isAbandoned()
    {
        return $this->is_temp && $this->payment_status === \App\Enums\PaymentStatusEnum::canceled()->value;
    }

    public function isPendingPayment()
    {
        return $this->is_temp && $this->payment_status === \App\Enums\PaymentStatusEnum::pending()->value;
    }

    public function isPaid()
    {
        return ! $this->is_temp && $this->payment_status === \App\Enums\PaymentStatusEnum::paid()->value;
    }
    // END All possible Order statuses

    public function getAbandonedOrderStripeCheckoutPermalink($preview = false)
    {
        $order_items = $this->order_items;

        if ($this->is_temp && $this->order_items->isNotEmpty()) {
            // TODO: For now it takes only first order item - add support for multiple items in Stripe
            $subject = $order_items->first()->subject;

            $data = base64_encode(json_encode([
                'id' => $subject->id,
                'class' => $subject::class,
                'qty' => $subject->quantity > 0 ? $subject->quantity : 1,
                'preview' => $preview,
                'abandoned_order_id' => $this->id,
            ]));

            return route('stripe.checkout_redirect').'?data='.$data;
        }

        return '#';
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
        $present = self::where('created_at', '>=', \Carbon::now()->subdays($period))->count();

        $past = self::where('created_at', '<=', \Carbon::now()->subdays($period))->count();

        if ($present == 0) {
            $present = 1;
        }

        $percentChange = (1 - $past / $present) * 100;

        return $percentChange;
    }
}
