<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CompanyTabs extends Component
{
    public $seller, $type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($seller, $type)
    {
        //
        $this->seller = $seller;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.company-tabs');
    }
}
