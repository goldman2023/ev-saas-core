<?php

namespace App\Models;

use StripeService;
use App\Traits\UploadTrait;
use App\Traits\GalleryTrait;
use App\Traits\CoreMetaTrait;
use App\Traits\PermalinkTrait;
use App\Traits\SocialAccounts;
use Laravel\Passport\HasApiTokens;
use App\Enums\AmountPercentTypeEnum;
use Stripe\Invoice as StripeInvoice;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Notifications\Notifiable;
use App\Enums\UserSubscriptionStatusEnum;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class UserSubscription extends WeBaseModel
{
    use LogsActivity;
    use UploadTrait;
    // use GalleryTrait;
    use CoreMetaTrait;

    protected $table = 'user_subscriptions';

    protected $fillable = ['user_id', 'order_id', 'subject_id', 'subject_type', 'start_date', 'end_date', 'status', 'payment_status', 'qty', 'data'];

    protected $casts = [
        'data' => 'array',
        // 'start_date' => 'date',
        // 'end_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan() {
        return $this->morphTo('subject')->withoutGlobalScopes();
    }

    public function subject() {
        return $this->morphTo('subject')->withoutGlobalScopes();
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id')->withoutGlobalScopes();
    }

    public function license() {
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

    // public static function getSubscriptionsAmount($subscriptions) {
    //     return $subscriptions->where([])
    // }

    public function getDynamicModelUploadProperties() : array {
        return [];
    }

    // STRIPE
    public function getStripeSubscriptionID() {
        return $this->data[StripeService::getStripeMode().'stripe_subscription_id'];
    }

    public function getStripeUpcomingInvoice() {
        $upcoming_invoice = \StripeService::getUpcomingInvoice($this, $this->plan, $this->order->invoicing_period);

        if($upcoming_invoice instanceof Order) {
            return array_merge(['invoice_source' => 'we'], $upcoming_invoice->toArray());
        } else if($upcoming_invoice instanceof StripeInvoice) {
            return array_merge(['invoice_source' => 'stripe'], $upcoming_invoice->toArray());
        }

        return null;
    }

    public function getUpcomingInvoiceStats() {
        return \Cache::remember('user_subscription_'.$this->id.'_upcoming_invoice_stats', 60*60, function () {
            $invoice = $this->getStripeUpcomingInvoice();
            return $invoice;
        });
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
}
