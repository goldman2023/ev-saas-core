<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ShopAddress extends Model
{
    use Notifiable;

    protected $table = 'shop_addresses';

    protected $fillable = ['id', 'shop_id', 'address', 'country', 'city', 'state', 'zip_code', 'phones', 'features', 'location', 'is_primary'];

    protected $available_features = [
        'pet_friendly' => 'Pet friendly',
        'outdoor' => 'Outdoor',
        'smoking_allowed' => 'Allowed smoking',
        'delivery' => 'Delivery',
    ];

    protected $casts = [
        'location' => 'array',
        'features' => 'array',
        'set_default' => 'boolean'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function getPhonesAttribute($value) {
        if(empty($value)) {
            return [''];
        }

        return is_array($value) ? $value : json_decode($value, true);
    }
}
