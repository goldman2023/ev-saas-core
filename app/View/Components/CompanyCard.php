<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CompanyCard extends Component
{
    public $company;
    public $new = false;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($company, $new = false)
    {
        $this->company = $company;
        $this->new = $new;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.company-card');
    }
}
