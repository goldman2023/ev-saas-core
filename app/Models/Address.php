<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $table = 'addresses';

    protected $fillable = ['user_id', 'address','country','city', 'zip_code','phones','set_default','state','address_2'];

    protected $casts = [
        'phones' => 'array',
        'set_default' => 'boolean'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
