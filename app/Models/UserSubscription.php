<?php

namespace App\Models;

use StripeService;
use App\Traits\UploadTrait;
use App\Traits\GalleryTrait;
use App\Traits\CoreMetaTrait;
use App\Traits\PermalinkTrait;
use App\Traits\SocialAccounts;
use App\Traits\HasDataColumn;
use App\Enums\AmountPercentTypeEnum;
use Stripe\Invoice as StripeInvoice;
use Spatie\Activitylog\Models\Activity;
use App\Enums\UserSubscriptionStatusEnum;
use Spatie\Activitylog\Traits\LogsActivity;

class UserSubscription extends WeBaseModel
{
    use LogsActivity;
    use UploadTrait;
    use CoreMetaTrait;
    use HasDataColumn;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $table = 'user_subscriptions';

    protected $fillable = ['user_id', 'order_id', 'start_date', 'end_date', 'status', 'payment_status', 'qty', 'data', 'created_at', 'updated_at'];

    // protected $with = ['order.order_items.subject'];

    protected $casts = [
        // 'start_date' => 'date',
        // 'end_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id')->withoutGlobalScopes();
    }

    public function items() {
        return $this->morphedByMany(Plan::class, 'subject', 'user_subscription_relationships')->withPivot('qty');
    }

    public function licenses() {
        return $this->morphedByMany(License::class, 'subject', 'user_subscription_relationships');
    }

    public function getStartDateAttribute($value) {
        $date = \Carbon::createFromTimestamp($value);

        return $date;
    }

    public function getEndDateAttribute($value) {
        $date = \Carbon::createFromTimestamp($value);

        return $date;
    }

    public function isTrial() {
        return $this->status === UserSubscriptionStatusEnum::trial()->value;
    }

    public function scopeActive($query) {
        return $query->whereIn('status', UserSubscriptionStatusEnum::toValues(skip: 'inactive'))->where('end_date', '>', time());
    }

    public function scopeTrial($query) {
        return $query->where('status', UserSubscriptionStatusEnum::trial()->value)->where('end_date', '>', time());
    }

    // public static function getSubscriptionsAmount($subscriptions) {
    //     return $subscriptions->where([])
    // }

    public function getDynamicModelUploadProperties() : array {
        return [];
    }

    // STRIPE
    public function isUsingStripe() {
        return !empty($this->getData(stripe_prefix('stripe_subscription_id')));
    }

    public function getStripeSubscriptionID() {
        return $this->getData(stripe_prefix('stripe_subscription_id'));
    }

    public function getStripeUpcomingInvoice() {
        // Try to get upcoming invoice from Order meta column
        $upcoming_invoice = $this->order->getData(stripe_prefix('stripe_upcoming_invoice'));

        // If no upcoming invoice is present in meta column, get upcoming invoice from stripe directly, and store it in meta
        if(empty($upcoming_invoice)) {
            $upcoming_invoice = \StripeService::getUpcomingInvoice($this);
            $this->order->setData(stripe_prefix('stripe_upcoming_invoice'), is_array($upcoming_invoice) ? $upcoming_invoice : $upcoming_invoice->toArray());            
            $this->order->save();
        }

        if($upcoming_invoice instanceof Order) {
            return array_merge(['invoice_source' => 'we'], $upcoming_invoice->toArray());
        } else if($upcoming_invoice instanceof StripeInvoice) {
            return array_merge(['invoice_source' => 'stripe'], $upcoming_invoice->toArray());
        } else if(is_array($upcoming_invoice)) {
            return $upcoming_invoice;
        }

        return null;
    }

    public function getUpcomingInvoiceStats() {
        // TODO: Add logic for different payment gateways later on
        return $this->getStripeUpcomingInvoice();
    }

    public function getTotalPrice($format = true) {
        $invoice = $this->getUpcomingInvoiceStats();

        if(is_array($invoice) && !empty($invoice['invoice_source'] ?? null)) {
            if($invoice['invoice_source'] === 'stripe') {
                return $format ? \FX::formatPrice($invoice['total'] / 100) : $invoice['total'] / 100;
            } else if($invoice['invoice_source'] === 'we') {
                return $format ? \FX::formatPrice($invoice['total_price'] ?? 0) : ($invoice['total_price'] ?? 0);
            }
        }

        return 0;
    }

    public function getTaxAmount($format = true) {
        $invoice = $this->getUpcomingInvoiceStats();
        
        if(is_array($invoice) && !empty($invoice['invoice_source'] ?? null)) {
            if($invoice['invoice_source'] === 'stripe') {
                return $format ?  \FX::formatPrice($invoice['tax'] / 100) : ($invoice['tax'] / 100);
            } else if($invoice['invoice_source'] === 'we' && !empty($invoice['tax_type'] ?? null)) {
                $interval = $this->order->invoicing_period;
                $subtotal_price = $this->order->subtotal_price;
                
                if ($invoice['tax_type'] === AmountPercentTypeEnum::percent()->value) {
                    $tax = ($this->order->subtotal_price * $this->order->tax) / 100;
                } elseif ($this->tax_type === AmountPercentTypeEnum::amount()->value) {
                    $tax = $this->order->tax;
                }

                return $format ? \FX::formatPrice($tax) : $tax;
            }
        }

        return 0;
    }

    public function hasSingleItem() {
        return $this->items->count() === 1 && $this->items->first()->pivot->qty === 1;
    }

    public function hasSingleItemMultipleQty() {
        return $this->items->count() === 1 && $this->items->first()->pivot->qty > 1;
    }

    public function hasMultipleItems() {
        return $this->items->count() > 0;
    }
}
