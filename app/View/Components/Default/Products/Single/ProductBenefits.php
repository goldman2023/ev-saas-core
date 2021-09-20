<?php

namespace App\View\Components\Default\Products\Single;

use Illuminate\View\Component;

class ProductBenefits extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.products.single.product-benefits');
    }
}
