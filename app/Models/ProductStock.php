<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use UUID;

class ProductStock extends Model
{
    //use SoftDeletes;
    use \Bkwld\Cloner\Cloneable;

    protected $table = 'product_stocks';

    protected $fillable = ['subject_id', 'subject_type', 'track_inventory', 'sku', 'barcode', 'qty', 'low_stock_qty', 'use_serial', 'allow_out_of_stock_purchases', 'created_at', 'updated_at'];

    protected $visible = ['id', 'subject_id', 'subject_type', 'track_inventory', 'sku', 'barcode', 'qty', 'low_stock_qty', 'use_serial', 'allow_out_of_stock_purchases', 'created_at', 'updated_at'];

    protected $clone_exempt_attributes = ['sku'];

    protected $casts = [
        'allow_out_of_stock_purchases' => 'boolean',
        'use_serial' => 'boolean',
        'track_inventory' => 'boolean',
    ];

    //
    public function subject()
    {
        return $this->morphTo('subject');
    }

    /**
     * When cloning ProductStocks, don't clone SKU cuz it's a unique index and instead of it put UUID4 random string!
     * Also, notify the user to change product/variation SKU, after duplication is done!!!
     */
    public function onCloning($src, $child = null)
    {
        $this->sku = UUID::generate(4)->string;
    }
}
