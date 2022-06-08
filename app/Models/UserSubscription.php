<?php

namespace App\Models;

use App\Traits\GalleryTrait;
use App\Traits\UploadTrait;
use App\Traits\SocialAccounts;
use App\Traits\CoreMetaTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use App\Notifications\EmailVerificationNotification;
use App\Traits\PermalinkTrait;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class UserSubscription extends WeBaseModel
{
    use LogsActivity;
    use UploadTrait;
    use GalleryTrait;
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

    // public static function getSubscriptionsAmount($subscriptions) {
    //     return $subscriptions->where([])
    // }

    public function getDynamicModelUploadProperties() : array {
        return [];
    }
}
