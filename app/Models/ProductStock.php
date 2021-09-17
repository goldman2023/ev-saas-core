<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    //
    public function product(){
    	return $this->morphTo('subject');
    }

    public function product_variations(){
        return $this->belongsTo(ProductVariation::class);
    }
}
