<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use TenantSettings;

/**
 * App\Models\TenantSetting
 *
 * @property int $id
 * @property string $type
 * @property string|null $value
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TenantSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TenantSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TenantSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TenantSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TenantSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TenantSetting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TenantSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TenantSetting whereValue($value)
 * @mixin \Eloquent
 */
class TenantSetting extends Model
{
    // use Cachable;
    use Notifiable;

    protected $table = 'tenant_settings';

    protected $fillable = ['setting', 'value'];

    // public function getValueAttribute($value) {
        
    //     if(is_array($value)) {
    //         return $value;
    //     } else if(is_string($value)) {
    //         $decoded = json_decode($value, true);

    //         if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
    //             return $decoded;
    //         }
    //     } else if(ctype_digit($value)) {
    //         $int = (int) $value;
    //         $float = (float) $value;

    //         if($int == $float) {
    //             return $int;
    //         }

    //         return $float;
    //     }

    //     return $value;
    // }
}
