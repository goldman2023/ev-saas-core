<?php

namespace App\Traits;

use App\Models\ProductStock;
use App\Models\SerialNumber;
use Illuminate\Support\Facades\Log;

/**
 * We'll combine classic stock management with serial numbers stock management in this trait.
 */
trait StockManagementTrait
{
    public $temp_sku;
    public $current_stock;
    public $low_stock_qty;
    public $use_serial;

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootStockManagementTrait()
    {
        // When model data is retrieved, populate model stock data!
        static::relationsRetrieved(function ($model) {

            if(!$model->relationLoaded('stock')) {
                $model->load('stock');
            }


//            if(empty($model->stock)) {
//                $product_stock = ProductStock::firstOrNew(['subject_id' => $model->id, 'subject_type' => $model::class]);
//                $product_stock->sku = $model->hasMain() ? $model->main->slug.'-001' : $model->slug.'-001';
//                $product_stock->qty = 1;
//                $product_stock->low_stock_qty = 1;
//                $product_stock->save();
//                $model->load('stock');
//            }

            if(!$model->relationLoaded('serial_numbers')) {
                $model->load('serial_numbers');
            }

            $model->getUseSerialAttribute();
            $model->getTempSkuAttribute();
            $model->getCurrentStockAttribute();
            $model->getLowStockQtyAttribute();
        });
    }

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeStockManagementTrait(): void
    {
        $this->append(['temp_sku', 'current_stock', 'low_stock_qty', 'use_serial']);
        $this->fillable(array_unique(array_merge($this->fillable, ['temp_sku', 'current_stock', 'low_stock_qty', 'use_serial'])));
    }

    /************************************
     * Stock/Serial Relations Functions *
     ************************************/
    public function stock()
    {
        return $this->morphOne(ProductStock::class, 'subject');
    }

    public function serial_numbers()
    {
        return $this->morphMany(SerialNumber::class, 'subject')->orderBy('status', 'ASC');
    }

    /************************************
     * Stock Attributes Getters/Setters *
     ************************************/
    public function getUseSerialAttribute() {
        if(!isset($this->use_serial)) {
            $this->use_serial = (bool) (empty($this->stock) ? false : ($this->stock->use_serial ?? false));
        }

        return $this->use_serial;
    }

    public function setUseSerialAttribute($value)
    {
        $this->use_serial = (bool) $value;
    }

    public function setTempSkuAttribute($value)
    {
        $this->temp_sku = $value;
    }

    public function getTempSkuAttribute() {
        // Set temp_sku only on first model hydration!
        if(!isset($this->temp_sku)) {
            $this->temp_sku = (string) (empty($this->stock) ? null : ($this->stock->sku ?? ''));
        }

        return $this->temp_sku ?? '';
    }


    public function setCurrentStockAttribute($value) {
        $this->current_stock = $value;
    }

    public function getCurrentStockAttribute() {
        if(!isset($this->current_stock)) {
            if($this->getUseSerialAttribute()) {
                $this->current_stock = (int) $this->serial_numbers()->where('status', 'in_stock')->count(); // Get the count of all IN_STOCK serial_numbers of the targeted model
            } else {
                $this->current_stock = (float) (empty($this->stock) ? null : ($this->stock->qty ?? 0));
            }
        }

        return $this->current_stock;
    }

    public function setLowStockQtyAttribute($value) {
        $this->low_stock_qty = $value;
    }

    public function getLowStockQtyAttribute() {
        if(!isset($this->low_stock_qty)) {
            $this->low_stock_qty = (float) (empty($this->stock) ? null : ($this->stock->low_stock_qty ?? 0));
        }

        return $this->low_stock_qty;
    }


    /**********************************
     * Stock Management Functions *
     **********************************/
    public function isInStock() {
        return $this->getCurrentStockAttribute() > 0;
    }

    public function isLowStock() {
        return $this->getCurrentStockAttribute() <= $this->getLowStockQtyAttribute();
    }

    public function reduceStock($quantity = null) {
        $quantity = (!empty($quantity) && $quantity > 0) ? $quantity : $this->purchase_quantity;

        if($this->current_stock >= $quantity) {
            if($this->use_serial) {
                // If item uses serial numbers, assign X available serial numbers to the Order item and change their status to reserved
                $in_stock_serial_numbers = $this->getInStockSerials()->slice(0, $quantity); // get first X in_stock serial numbers

                // Change selected serial numbers statuses to reserved
                $in_stock_serial_numbers->each(function($item, $key) {
                    $item->status = 'reserved';
                    $item->save();
                });

                return $in_stock_serial_numbers->pluck('serial_number')->toArray(); // pluck serial_numbers and transform to array
            } else {
                $stock = $this->stock;
                $stock->qty -= $quantity;
                $stock->save();

                return true;
            }
        }
    }

    /**********************************
     * Serial Numbers Stock Functions *
     **********************************/
    public function getSerialNumbersStockStats() {
        $all_serials = $this->serial_numbers()->orderBy('status', 'ASC')->withTrashed();

        $stats = [
            'in_stock' => 0,
            'out_of_stock' => 0,
            'reserved' => 0,
            'trashed' => 0,
            'total' => 0,
            'total_with_trashed' => 0
        ];

        $all_serials->each(function ($model, $key) use (&$stats) {
            if($model->trashed()) {
                ++$stats['trashed'];
            } else if($model->status === 'in_stock') {
                ++$stats['in_stock'];
            } else if($model->status === 'out_of_stock') {
                ++$stats['out_of_stock'];
            } else if($model->status === 'reserved') {
                ++$stats['reserved'];
            }

            if(!$model->trashed()) {
                ++$stats['total'];
            }

            ++$stats['total_with_trashed'];
        });

        return $stats;
    }

    public function getInStockSerials($count = false) {
        return $count ? $this->serial_numbers->where('status', 'in_stock')->count() : $this->serial_numbers->where('status', 'in_stock');
    }

    public function getOutOfStockSerials($count = false) {
        return $count ? $this->serial_numbers->where('status', 'out_of_stock')->count() : $this->serial_numbers->where('status', 'out_of_stock');
    }

    public function getReservedSerials($count = false) {
        return $count ? $this->serial_numbers->where('status', 'reserved')->count() : $this->serial_numbers->where('status', 'reserved');
    }
}
