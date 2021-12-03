<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStock extends Model
{
    //use SoftDeletes;

    protected $table = 'product_stocks';

    protected $fillable = ['subject_id', 'subject_type', 'sku', 'qty', 'low_stock_qty', 'use_serial', 'created_at', 'updated_at'];
    protected $visible = ['id', 'subject_id', 'subject_type', 'sku', 'qty', 'created_at', 'updated_at'];

    //
    public function subject() {
    	return $this->morphTo('subject');
    }
}
