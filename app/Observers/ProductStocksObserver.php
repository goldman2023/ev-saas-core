<?php

namespace App\Observers;

use App\Models\ProductStock;
use App\Support\CacheRegenerator;
use Cache;

class ProductStocksObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the ProductStock "saved" event.
     *
     * @param ProductStock $product_stock
     * @return void
     */
    public function saved(ProductStock $product_stock)
    {
        // When product stock is saved, invalidate subject Cache!
        CacheRegenerator::forgetModel($product_stock->subject_type, $product_stock->subject_id);
    }
}
