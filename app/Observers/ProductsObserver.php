<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\TenantSetting;
use Cache;
use Payments;
use StripeService;

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
        $product = Product::find($product->id); // For some reason, prices are not correct and show previous prices (if they are changed) if used product is $product given as parameter
        $product->cache()->invalidate(true);

        if(Payments::isStripeEnabled()) {
            // Update Stripe product
            StripeService::saveStripeProduct($product);
        }

        auth()->user()->notify(new InvoicePaid($invoice));

    }

    /**
     * Handle the Products "deleting" event.
     *
     * @param Product $product
     * @return void
     */
    public function deleting(Product $product)
    {
        // TODO: Add removing stocks/uplaods-relations/attribute-relations/and other polymorphic relations!
        //TODO: IT SHOULD BE ON FORCE DELETE!!!
    }
}
