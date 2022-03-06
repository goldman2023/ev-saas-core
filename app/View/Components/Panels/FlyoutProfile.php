<?php

namespace App\View\Components\Panels;

use Illuminate\View\Component;

class FlyoutProfile extends Component
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
        if(session('style_framework') === 'tailwind') {
            return view('components.tailwind-ui.panels.flyout-profile');
        }

        return view('components.bootstrap.panels.flyout-profile');
    }
}
