<?php

namespace App\View\Components\Tailwind\ProductCards;

use Illuminate\View\Component;

class ProductCardWithOverlayAndButton extends ProductCard
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
        return view('components.tailwind.product-cards.product-card-with-overlay-and-button');
    }
}
