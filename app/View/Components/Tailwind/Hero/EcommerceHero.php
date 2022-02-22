<?php

namespace App\View\Components\Tailwind\Hero;

use Illuminate\View\Component;

class EcommerceHero extends Component
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
        return view('components.tailwind.hero.ecommerce-hero');
    }
}
