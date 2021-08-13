<?php

namespace App\View\Components\Tenant\Footer;

use Illuminate\View\Component;

class FourColumnWithCompanyMission extends Component
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
        return view('components.tenant.footer.four-column-with-company-mission');
    }
}
