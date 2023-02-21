<?php

namespace App\Models;

use WEF;
use App\Facades\MyShop;
use App\Traits\HasStatus;
use App\Traits\TasksTrait;
use App\Traits\UploadTrait;
use App\Traits\GalleryTrait;
use App\Builders\BaseBuilder;
use App\Traits\CoreMetaTrait;
use App\Traits\HasDataColumn;
use App\Traits\PermalinkTrait;
use App\Traits\TemporaryTrait;
use Spatie\ModelStatus\HasStatuses;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\Order
 */
class Order extends WeBaseModel
{
    use SoftDeletes;
    use TemporaryTrait;
    use PermalinkTrait;
    use HasDataColumn;
    use LogsActivity;
    use UploadTrait;
    use CoreMetaTrait;
    use TasksTrait;
    use HasStatus;

    protected $table = 'orders';

    protected $guarded = ['id'];

    protected $casts = [
        'phone_numbers' => 'array',
        'same_billing_shipping' => 'boolean',
        'viewed' => 'boolean',
        'buyers_consent' => 'boolean',
        'tax_incl' => 'boolean',
        // 'created_at' => 'datetime:d.m.Y H:i',
        // 'updated_at' => 'datetime:d.m.Y H:i',
    ];

    protected $fillable = ['shop_id', 'user_id', 'type', 'is_temp', 'email',
        'billing_first_name', 'billing_last_name', 'billing_company', 'billing_address', 'billing_country', 'billing_state', 'billing_city', 'billing_zip',
        'phone_numbers', 'same_billing_shipping',
        'shipping_first_name', 'shipping_last_name', 'shipping_company', 'shipping_address', 'shipping_country', 'shipping_state', 'shipping_city', 'shipping_zip',
        'note', 'terms', 'number_of_invoices', 'invoicing_period', 'invoice_grace_period', 'invoicing_start_date',
        'shipping_method', 'shipping_cost', 'tax', 'tax_incl', 'payment_status', 'shipping_status', 'tracking_number', 'viewed', 'buyers_consent'
    ];

    public mixed $base_price;

    public mixed $discount_amount;

    public mixed $subtotal_price;
    
    public mixed $tax_amount;

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

    public function order_items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function user_subscription()
    {
        return $this->hasOne(UserSubscription::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'order_id', 'id')->orderBy('created_at', 'desc');
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
            // 1. base_price in our DB should represent order_item's unit_price
            // 2. quantity is ...quantity
            // 3. subtotal_price = (base_price * quantity) - discount_amount
            // 4. tax_amount = sum of order items tax
            // 4. total_price = subtotal_price - discount(didn't add it yet) + shipping_cost + tax

            $sums_properties = ['base_price', 'discount_amount', 'subtotal_price', 'total_price', 'tax_amount'];
            $order->appendCoreProperties($sums_properties);
            $order->append($sums_properties);

            if (! empty($order->fillable)) {
                $order->fillable(array_unique(array_merge($order->fillable, $sums_properties)));
            }

            $order->initCoreProperties(only: $sums_properties); // init ONLY 'sums' core properties (cuz otherwise, other core properties from traits will be overriden)

            if($order->type === 'subscription') {
                foreach ($sums_properties as $property) {
                    $order->{$property} = 0;

                    foreach ($order->order_items as $item) {
                        // if($item->subject->isSubscribable() && $order->invoicing_period === 'year') {
                        //     $order->{$property} += $item->{$property} * $item->quantity;
                        // } else {
                            $order->{$property} += $item->{$property};
                        // }
                    }

                    // TODO: Fix this to populate each price with correct data. For now, all 4 properties are `total_price` -_-
                }

                $order->total_price = $order->subtotal_price + (float) $order->shipping_cost;
                $order->total_price += ($order->total_price * ((float) $order->tax) / 100);
            } else {
                $order->base_price = 0;
                $order->discount_amount = 0;
                $order->subtotal_price = 0;

                foreach ($order->order_items as $item) {
                    $order->base_price += $item->quantity * $item->base_price; // base_price is unit_price, so we need to multiply it by quantity
                    $order->discount_amount += $item->discount_amount; // here: discount_amount is `$item->quantity * ($item->base_price - $item->total_price)`
                    $order->subtotal_price += $item->subtotal_price;
                    $order->tax_amount += $item->tax;
                    $order->total_price += $item->total_price;
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

    public function scopeShopOrders($query)
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
        return ! $this->is_temp && $this->invoices->filter(fn($item) => $item->payment_status === \App\Enums\PaymentStatusEnum::paid()->value)->count() === $this->invoices->count();
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

    public function getDynamicModelUploadProperties(): array
    {
        return [
            [
                'property_name' => 'documents',
                'relation_type' => 'documents',
                'multiple' => true,
            ],
        ];
    }

    public function getWEFDataTypes() {
        return WEF::bundleWithGlobalWEF(apply_filters('order.wef.data-types', [
            'deposit_amount' => 'decimal',
            'billing_entity' => 'string',
            'billing_company_code' => 'string',
            'billing_company_vat' => 'string',
        ]));
    }

    // Stripe
    public function refreshStripeUpcomingInvoice() {
        $is_stripe_subscription = $this->getData(stripe_prefix('stripe_payment_mode'));

        if(!$this->is_temp && $this->type === 'subscription' && $is_stripe_subscription === 'subscription' && !empty($this->user_subscription)) {
            $upcoming_invoice = \StripeService::getUpcomingInvoice($this->user_subscription);
            $this->setData(stripe_prefix('stripe_upcoming_invoice'), is_array($upcoming_invoice) ? $upcoming_invoice : $upcoming_invoice->toArray());
            $this->save();
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


    /* TODO: Make this into reporting Trait */
    public function scopeByDays($query, $days)
    {
        //one day (today)
        $date = \Carbon::now();

        //one month / 30 days
        $date = \Carbon::now()->subDays($days);

        return $query->where('created_at', '>' , $date);
    }

    public function get_primary_order_item() {
        return $this->order_items->first();
    }

    public function comments() {
        return $this->morphMany(SocialComment::class, 'subject');
    }
}
