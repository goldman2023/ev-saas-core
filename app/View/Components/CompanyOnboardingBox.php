<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CompanyOnboardingBox extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        // $this->shop = $shop;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.company-onboarding-box');
    }
}
