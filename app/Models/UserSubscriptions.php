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

class UserSubscriptions extends WeBaseModel
{
    use LogsActivity;
    use UploadTrait;
    use GalleryTrait;
    use CoreMetaTrait;

    protected $table = 'user_subscriptions';

    protected $fillable = ['user_id', 'subject_id', 'subject_type', 'start_date', 'end_date', 'qty', 'data'];

    protected $casts = [
        'start_date' => 'U',
        'end_date' => 'U'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan() {
        return $this->morphTo(Plan::class, 'subject');
    }

    // public static function getSubscriptionsAmount($subscriptions) {
    //     return $subscriptions->where([])
    // }
}
