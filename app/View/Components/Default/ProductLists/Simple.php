<?php

namespace App\View\Components\Default\ProductLists;

use Illuminate\View\Component;

class Simple extends Component
{
    public $products;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($products = null)
    {
        //
        if($products) {
            $this->products = $products;
        } else {
            $this->products = Product::orderBy('created_at')->take(10)->get();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.product-lists.simple');
    }
}
