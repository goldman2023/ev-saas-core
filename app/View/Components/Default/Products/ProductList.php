<?php

namespace App\View\Components\Default\Products;
use App\Models\Product;

use Illuminate\View\Component;

class ProductList extends Component
{
    public $products;
    public $items;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($items = 8)
    {
        //
        $products = Product::paginate($items);
        $this->products = $products;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.products.product-list');
    }
}
