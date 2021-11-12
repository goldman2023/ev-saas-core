<?php

namespace App\Traits;

use App\Models\ProductStock;
use App\Models\SerialNumber;

/**
 * We'll combine classic stock management with serial numbers stock management in this trait.
 */
trait StockManagementTrait
{
    public string $temp_sku;
    public float|int $current_stock;
    public float|int $low_stock_qty;
    public bool $use_serial;

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootStockManagementTrait()
    {
        // When model data is retrieved, populate model stock data!
        static::retrieved(function ($model) {
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

    /**
     * Get the casts array.
     * Note: Appends the `use_serial` cast to bool
     *
     * @return array
     */
    public function getCasts()
    {
        $this->casts = array_unique(
            array_merge($this->casts, [
                'use_serial' => 'bool'
            ])
        );

        return parent::getCasts();
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
        return $this->morphMany(SerialNumber::class, 'subject');
    }

    /************************************
     * Stock Attributes Getters/Setters *
     ************************************/
    public function getUseSerialAttribute() {
        if(empty($this->use_serial)) {
            $this->use_serial = (bool) (empty($this->stock) ? false : ($this->stock->use_serial ?? false));
        }

        return $this->use_serial;
    }

    public function setTempSkuAttribute($value)
    {
        $this->temp_sku = $value;
    }

    public function getTempSkuAttribute() {
        if(empty($this->temp_sku)) {
            $this->temp_sku = (string) (empty($this->stock) ? null : ($this->stock->sku ?? ''));
        }

        return $this->temp_sku;
    }


    public function setCurrentStockAttribute($value) {
        $this->current_stock = $value;
    }

    public function getCurrentStockAttribute() {
        if(empty($this->current_stock)) {
            if($this->use_serial) {
                $this->current_stock = (int) $this->serial_numbers->where('status', 'in_stock')->count(); // Get the count of all IN_STOCK serial_numbers of the targeted model
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
        if(empty($this->low_stock_qty)) {
            $this->low_stock_qty = (float) (empty($this->stock) ? null : ($this->stock->low_stock_qty ?? 0));
        }

        return $this->low_stock_qty;
    }

    /**********************************
     * Serial Numbers Stock Functions *
     **********************************/
    public function getOutOfStockSerials($count = false) {
        return $count ? $this->serial_numbers->where('status', 'out_of_stock')->count() : $this->serial_numbers->where('status', 'out_of_stock');
    }

    public function getReservedSerials($count = false) {
        return $count ? $this->serial_numbers->where('status', 'reserved')->count() : $this->serial_numbers->where('status', 'reserved');
    }
}
