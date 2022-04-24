<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    public function taxes()
    {
        return $this->belongsToMany(Tax::class, 'tax_relationships', 'country_id', 'id');
    }
}
