<?php

namespace App\View\Components\Tenant\System\Filtering;

use Illuminate\View\Component;

class CategortFilters extends Component
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
        return view('components.tenant.system.filtering.categort-filters');
    }
}
