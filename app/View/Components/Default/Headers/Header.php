<?php

namespace App\View\Components\Default\Headers;

use Illuminate\View\Component;

class Header extends Component
{
    public $style;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($style = 'with-top-nav-bar')
    {
        //
        $this->style = $style;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.headers.' . $this->style);
    }
}
