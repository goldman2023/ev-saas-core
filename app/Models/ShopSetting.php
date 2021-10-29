<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class ShopSetting extends Model
{
    use Cachable;
    use Notifiable;

    protected $table = 'shop_settings';

    public function shop() {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function getValueAttribute($value) {
        $decoded = json_decode($value, true);

        if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        if(ctype_digit($value)) {
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