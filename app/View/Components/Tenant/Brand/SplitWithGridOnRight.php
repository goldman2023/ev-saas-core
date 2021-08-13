<?php

namespace App\View\Components\Tenant\Brand;

use Illuminate\View\Component;

class SplitWithGridOnRight extends Component
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
        return view('components.tenant.brand.split-with-grid-on-right');
    }
}
