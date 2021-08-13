<?php

namespace App\View\Components\Tenant\Incentives;

use Illuminate\View\Component;

class FourColumnWithIlustrations extends Component
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
        return view('components.tenant.incentives.four-column-with-ilustrations');
    }
}
