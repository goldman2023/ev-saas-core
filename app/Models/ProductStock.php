<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStock extends Model
{
    //use SoftDeletes;

    protected $table = 'product_stocks';

    protected $fillable = ['subject_id', 'subject_type', 'sku', 'barcode', 'qty', 'low_stock_qty', 'use_serial', 'allow_out_of_stock_purchases', 'created_at', 'updated_at'];
    protected $visible = ['id', 'subject_id', 'subject_type', 'sku', 'barcode', 'qty', 'low_stock_qty', 'use_serial', 'allow_out_of_stock_purchases', 'created_at', 'updated_at'];

    protected $casts = [
        'allow_out_of_stock_purchases' => 'boolean',
        'use_serial' => 'boolean',
    ];
    //
    public function subject() {
    	return $this->morphTo('subject');
    }
}
