<?php

namespace App\Models;

use WEF;
use Illuminate\Support\Arr;
use App\Traits\GalleryTrait;
use App\Traits\UploadTrait;
use App\Traits\SocialAccounts;
use App\Traits\CoreMetaTrait;
use App\Traits\HasDataColumn;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use App\Notifications\EmailVerificationNotification;
use App\Traits\PermalinkTrait;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Casts\Attribute;

class License extends WeBaseModel
{
    use CoreMetaTrait;
    use HasDataColumn;
    use LogsActivity;

    protected $table = 'licenses';

    protected $fillable = ['license_name', 'user_id', 'serial_number', 'license_type', 'data', 'created_at', 'updated_at'];
    protected $hidden = ['user_subscription', 'user', 'plan'];

    protected $casts = [

    ];

    public function user_subscription() {
        return $this->morphToMany(UserSubscription::class, 'subject', 'user_subscription_relationships');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan() {
        return $this->belongsTo(Plan::class, 'plan_id');
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

    public function getEditableData() {
        $keys = apply_filters('license.get.data.editable.keys');
        $data = empty($this->data) ? [] : $this->data; // init empty array if data is empty, just in case if it's null in DB
        $editableData = [];

        if(empty($keys)) {
            // If there are no keys restriction from current theme, return whole data json!
            return $data;
        }

        // Otherwise, if there are keys specified in current theme, return only those keys specified!

        // Get only specified keys from current $data and set it inside $editableData (IMPORTANT: dot notaion CAN BE used ;)
        foreach($keys as $key => $options) {
            $value = Arr::get($data, $key, null);

            if(empty($value)) {
                if(($options['type'] ?? null) === 'datetime') {
                    if(($options['default'] ?? null) === 'now' && !empty($options['format'] ?? null)) {
                        $value = \Carbon::now()->format($options['format']);
                    }
                }
            }

            Arr::set($editableData, $key, $value);
        }

        return $editableData;
    }

    public function setEditableData($new_data) {
        $keys = apply_filters('license.get.data.editable.keys');
        $data = empty($this->data) ? [] : $this->data; // init empty array if data is empty, just in case if it's null in DB

        if(empty($keys)) {
            // If there are no keys restriction from current theme, replace old $data with given $new_data!
            $this->data = $new_data;
            return;
        }

        // Otherwise, if there are keys specified in current theme, save only $keys from $new_data to old $data!
        foreach($keys as $key => $options) {
            $value = Arr::get($new_data, $key, null);

            Arr::set($data, $key, $value);
        }

        $this->data = $data;
    }

    public function getWEFDataTypes() {
        return WEF::bundleWithGlobalWEF(apply_filters('license.wef.data-types', []));
    }

    // TODO: Refactor this through ThemeFunctions in some way and make it theme-specific! (Extending the Model functions concept)
    public function get_license() {
        return pix_pro_get_license_by_serial_number($this)['license'] ?? null;
    }
}
