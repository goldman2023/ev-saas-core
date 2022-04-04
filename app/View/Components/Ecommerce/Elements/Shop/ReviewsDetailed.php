<?php

namespace App\View\Components\Ecommerce\Elements\Shop;

use Illuminate\View\Component;

class ReviewsDetailed extends Component
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
        return view('components.ecommerce.elements.shop.reviews-detailed');
    }
}
