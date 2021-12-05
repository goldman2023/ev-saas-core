<?php

namespace App\Traits;

trait Purchasable
{
    public bool $is_purchasable = true;
    public $purchase_quantity = 0;

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializePurchasable(): void
    {
        $this->append(['purchase_quantity']);
        $this->fillable(array_unique(array_merge($this->fillable, ['purchase_quantity'])));
    }

    /**
     * @return void
     */
    public function setPurchaseQuantityAttribute($value)
    {
        $this->purchase_quantity = $value;
    }

    /**
     * @return mixed $purchase_quantity
     */
    public function getPurchaseQuantityAttribute()
    {
        return $this->purchase_quantity;
    }

}
