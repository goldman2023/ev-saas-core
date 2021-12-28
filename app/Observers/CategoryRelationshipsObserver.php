<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\TenantSetting;
use Cache;

class CategoryRelationshipsObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the CategoryRelationships "saved" event.
     *
     * @param Product $product
     * @return void
     */
    public function saved(Product $product)
    {
        // When product is saved
    }
}
