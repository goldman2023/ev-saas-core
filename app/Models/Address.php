<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = ['id', 'user_id', 'address', 'country', 'city', 'zip_code', 'phones', 'is_primary', 'is_billing', 'state', 'address_2'];

    protected $casts = [
        'phones' => 'array',
        'is_primary' => 'boolean',
        'is_billing' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getPhonesAttribute($value)
    {
        if (empty($value)) {
            return [''];
        }

        return is_array($value) ? $value : json_decode($value, true);
    }
}
