<?php

namespace App\View\Components\Default\Cards;

use Illuminate\View\Component;

class HeroBenfitCard extends Component
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
        return view('components.default.cards.hero-benfit-card');
    }
}
