<?php

namespace App\Observers;

use App\Models\Product;
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
     * @param Product $product
     * @return void
     */
    public function saved(Product $product)
    {
        // TODO: When ProductVariation is saved, clear the parent Product cache

    }
}
