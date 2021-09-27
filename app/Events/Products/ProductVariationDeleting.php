<?php

namespace App\Events\Products;

use App\Models\ProductStock;
use App\Models\ProductVariation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductVariationDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The Product Variation instance.
     *
     * @var \App\Models\ProductVariation
     */
    public $product_variation;

    /**
     * Remove all polymorphic relations of $product_variation (stock)
     *
     * @param  \App\Models\ProductVariation  $product_variation
     * @return void
     */
    public function __construct(ProductVariation $product_variation)
    {
        // Remove variation stock when variation is deleted!
        $this->product_variation = $product_variation;
        $stock = $this->product_variation->stock()->first();

        if($stock) {
            $stock->delete();
        }
    }
}
