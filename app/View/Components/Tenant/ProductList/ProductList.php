<?php

namespace App\View\Components\Tenant\ProductList;

use App\Models\Product;
use Illuminate\View\Component;

class ProductList extends Component
{

    public $products;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($products = [])
    {
        //
        $products = Product::all();

        $this->products = $products;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tenant.product-list.with-inline-price');
    }
}
