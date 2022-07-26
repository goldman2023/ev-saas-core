<?php

namespace App\View\Components\System;

use Illuminate\View\Component;

class Countdown extends Component
{
    public $date;
    public $item;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($date, $item = null)
    {
        $this->date = $date * 1000;
        if($item) {
            $this->item = $item;
        }
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.system.countdown');
    }
}
