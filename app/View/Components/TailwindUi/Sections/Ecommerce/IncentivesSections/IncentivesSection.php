<?php

namespace App\View\Components\TailwindUi\Ecommerce\Incentives\HeroSections;

use App\View\Components\TailwindUi\WeComponent;
use Illuminate\View\Component;

class IncentivesSection extends WeComponent
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.sections.ecommerce.incentives-sections.incentives-section');
    }
}
