<?php

namespace App\View\Components\Default\Merchant\Promo;

use Illuminate\View\Component;

class ImageSlider extends Component
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
        return view('components.default.merchant.promo.image-slider');
    }
}