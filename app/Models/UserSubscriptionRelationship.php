<?php

namespace App\Models;

use StripeService;
use App\Traits\SocialAccounts;
use Stripe\Invoice as StripeInvoice;
use App\Enums\UserSubscriptionStatusEnum;
use Spatie\Activitylog\Traits\LogsActivity;

class UserSubscriptionRelationship extends WeBaseModel
{
    use LogsActivity;

    protected $table = 'user_subscription_relationships';

    protected $fillable = ['user_subscription_id', 'subject_id', 'subject_type', 'qty', 'created_at', 'updated_at'];

    public function subscription()
    {
        return $this->belongsTo(UserSubscription::class);
    }

    public function subject() {
        return $this->morphTo('subject');
    }

    
}
