<?php

namespace App\Models;

use App\Traits\GalleryTrait;
use App\Traits\UploadTrait;
use App\Traits\SocialAccounts;
use App\Traits\CoreMetaTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Auth\User as Authenticatable;
use App\Models\Shop;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use App\Notifications\EmailVerificationNotification;
use App\Traits\PermalinkTrait;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class UserInvite extends WeBaseModel
{
    use LogsActivity;

    protected $table = 'user_invites';

    protected $fillable = ['user_id', 'shop_id', 'new_user_type', 'new_user_role', 'email', 'token', 'accepted'];

    protected $casts = [
        'accepted' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
