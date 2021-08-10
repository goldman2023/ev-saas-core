<?php

namespace App\View\Components;

use App\Models\Product;
use Illuminate\View\Component;

class ProductGridCard extends Component
{

    public Product $product;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Product $product)
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
        return view('components.product-grid-card');
    }
}
