<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CreditReportBox extends Component
{

    public $company;
    public $company_country;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($company)
    {
        //
        $this->company = $company;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.credit-report-box');
    }
}
