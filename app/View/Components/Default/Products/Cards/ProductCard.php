<?php

namespace App\View\Components\Default\Products\Cards;

use App\Models\Product;
use Illuminate\View\Component;

class ProductCard extends Component
{
    public Product $product;
    public string $style; // Available styles now: product-card / product-card-detailed
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Product $product, string $style = 'product-card-detailed')
    {
        //
        $this->style = $style;
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.products.cards.' . $this->style);
    }
}
