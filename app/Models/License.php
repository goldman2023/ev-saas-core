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

class License extends WeBaseModel
{
    use CoreMetaTrait;

    protected $table = 'licenses';

    protected $fillable = ['license_name', 'serial_number', 'hardware_id', 'license_type', 'data', 'created_at', 'updated_at'];

    protected $casts = [
        'data' => 'array'
    ];
    
    public function user_subscription() {
        return $this->morphedToMany(License::class, 'subject', 'user_subscription_relationships');
    }

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) =>  $query->where('serial_number', 'like', '%'.$term.'%')
                ->orWhere('license_name', 'like', '%'.$term.'%')
        );
    }
}
