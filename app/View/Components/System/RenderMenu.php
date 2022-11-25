<?php

namespace App\View\Components\System;

use Illuminate\View\Component;

class RenderMenu extends Component
{
    public $menu;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($menu)
    {
        //
        $this->menu = $menu;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.system.render-menu');
    }
}
