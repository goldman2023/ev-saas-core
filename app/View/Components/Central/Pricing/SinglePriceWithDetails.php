<?php

namespace App\View\Components\Central\Pricing;

use Illuminate\View\Component;

class SinglePriceWithDetails extends Component
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
        return view('components.central.pricing.single-price-with-details');
    }
}
