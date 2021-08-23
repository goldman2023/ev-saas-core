<?php

namespace App\View\Components\Tenant\Promo;

use Illuminate\View\Component;

class WithImageTitles extends Component
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
        return view('components.tenant.promo.with-image-titles');
    }
}
