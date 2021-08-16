<?php

namespace App\View\Components\Tenant\CTA;

use Illuminate\View\Component;

class BrandPanelWithAppScreenshot extends Component
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
        return view('components.tenant.c-t-a.brand-panel-with-app-screenshot');
    }
}
