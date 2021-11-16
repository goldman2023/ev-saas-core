<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\TenantSetting;
use Cache;

class ProductVariationsObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the ProductVariation "saved" event.
     *
     * @param ProductVariation $product_variation
     * @return void
     */
    public function saved(ProductVariation $product_variation)
    {
        // TODO: When ProductVariation is saved, clear the parent Product cache

    }

    /**
     * Handle the ProductVariation "deleting" event.
     *
     * @param ProductVariation $product_variation
     * @return void
     */
    public function deleting(ProductVariation $product_variation)
    {
        // Remove variation stock when variation is deleted!
        $stock = $product_variation->stock()->first();

        if($stock) {
            $stock->delete();
        }
    }
}
