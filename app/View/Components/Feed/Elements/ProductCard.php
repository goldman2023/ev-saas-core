<?php

namespace App\View\Components\Feed\Elements;

use App\Models\Product;
use Illuminate\View\Component;

class ProductCard extends Component
{
    public ?Product $product;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?Product $product = null)
    {
        //
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.feed.elements.product-card');
    }
}
