<?php

namespace App\View\Components\Default\Companies\Cards;

use App\Models\Shop;
use Illuminate\View\Component;

class CompanyCard extends Component
{
    public Shop $company;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Shop $company)
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
        return view('components.default.companies.cards.company-card');
    }
}
