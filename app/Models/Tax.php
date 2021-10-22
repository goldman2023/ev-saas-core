<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'taxes';

    public function business() {
        return $this->belongsTo(Shop::class, 'business_id');
    }

    public function countries() {
        return $this->belongsToMany(Country::class, 'tax_relationships', 'tax_id', 'id');
    }

    public function product_taxes() {
        return $this->hasMany(ProductTax::class);
    }
}
