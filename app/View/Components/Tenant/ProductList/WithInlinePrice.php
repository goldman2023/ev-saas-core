<?php

namespace App\View\Components\Tenant\ProductList;

use App\Models\Product;
use Illuminate\View\Component;

class WithInlinePrice extends ProductList
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($products = [], $style = 'with-inline-price')
    {
        // Please add all product logic to ProductList Class and add all general dynamic options used accross the blocks
        parent::__construct($products, $style);
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
