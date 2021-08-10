<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CompanyContactForm extends Component
{
    public $seller;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($seller)
    {
        //
        $this->seller = $seller;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.company-contact-form');
    }
}
