<?php

namespace App\Traits;

trait StockManagementTrait
{
    public string $temp_sku;
    public float $current_stock;
    public float $low_stock_qty;

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootStockManagementTrait()
    {
        // When model data is retrieved, populate model prices data!
        static::retrieved(function ($model) {
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
        $this->append(['temp_sku', 'current_stock', 'low_stock_qty']);
        $this->fillable(array_unique(array_merge($this->fillable, ['temp_sku', 'current_stock', 'low_stock_qty'])));
    }

    public function setTempSkuAttribute($value)
    {
        $this->temp_sku = $value;
    }

    public function getTempSkuAttribute() {
        if(empty($this->temp_sku)) {
            $stock = $this->stock()->first();

            return (string) ($stock->sku ?? '');
        }

        return $this->temp_sku;
    }


    public function setCurrentStockAttribute($value) {
        $this->current_stock = $value;
    }

    public function getCurrentStockAttribute() {
        if(empty($this->current_stock)) {
            $stock = $this->stock()->first();

            return (float) ($stock->qty ?? 0);
        }

        return $this->current_stock;
    }

    public function setLowStockQtyAttribute($value) {
        $this->low_stock_qty = $value;
    }

    public function getLowStockQtyAttribute() {
        if(empty($this->low_stock_qty)) {
            $stock = $this->stock()->first();

            return (float) ($stock->low_stock_qty ?? 0);
        }

        return $this->low_stock_qty;
    }
}
