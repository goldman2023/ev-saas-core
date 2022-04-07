<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\TenantSetting;
use Cache;

class ProductsObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the Products "saved" event.
     *
     * @param Product $product
     * @return void
     */
    public function saved(Product $product)
    {
        // When product is saved - invalidate the cache!
        $product->cache()->invalidate(true);
    }

    /**
     * Handle the Products "deleting" event.
     *
     * @param Product $product
     * @return void
     */
    public function deleting(Product $product) {
        // TODO: Add removing stocks/uplaods-relations/attribute-relations/and other polymorphic relations!
        //TODO: IT SHOULD BE ON FORCE DELETE!!!
    }


}
