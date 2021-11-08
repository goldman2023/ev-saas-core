<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $table = 'product_stocks';

    protected $fillable = ['subject_id', 'subject_type', 'sku', 'qty'];
    protected $visible = ['id', 'subject_id', 'subject_type', 'sku', 'qty', 'created_at', 'updated_at'];

    //
    public function product() {
    	return $this->morphTo('subject');
    }

    public function product_variations(){
        return $this->belongsTo(ProductVariation::class);
    }
}
