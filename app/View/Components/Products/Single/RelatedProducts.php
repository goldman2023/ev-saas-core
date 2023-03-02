<?php

namespace App\View\Components\Products\Single;

use Illuminate\View\Component;

class RelatedProducts extends Component
{
    public $relatedProducts;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        //
        $this->relatedProducts = $product->relatedProducts();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.products.single.related-products');
    }
}
