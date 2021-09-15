<?php

namespace App\View\Components\Default\Headers;

use Illuminate\View\Component;

class WithTopNavBar extends Component
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
        return view('components.default.headers.with-top-nav-bar');
    }
}
