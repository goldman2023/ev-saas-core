<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\BusinessSetting
 *
 * @property int $id
 * @property string $type
 * @property string|null $value
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessSetting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessSetting whereValue($value)
 * @mixin \Eloquent
 */
class BusinessSetting extends Model
{
    use Cachable;
    use Notifiable;

    public function getValueAttribute($value) {
        $decoded = json_decode($value, true);

        if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        } else if(ctype_digit($value)) {
            $int = (int) $value;
            $float = (float) $value;

            if($int == $float) {
                return $int;
            }

            return $float;
        }

        return $value;
    }
}
