<?php

namespace App\View\Components\Tenant\System;

use Illuminate\View\Component;

class ProductAddToCart extends Component
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
        return view('components.tenant.system.product-add-to-cart');
    }
}
