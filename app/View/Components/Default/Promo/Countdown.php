<?php

namespace App\View\Components\Default\Promo;

use Illuminate\View\Component;

class Countdown extends Component
{
    public $date;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($date = '2021/09/04')
    {
        //
        $this->date = $date;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.promo.countdown');
    }
}
