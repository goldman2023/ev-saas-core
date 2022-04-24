<?php

namespace App\View\Components\TailwindUi\Sections\Marketing\PricingSections;

use App\View\Components\TailwindUi\WeComponent;
use Illuminate\View\Component;

class PricingSection01 extends WeComponent
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        //TODO: This should depend on selected content type
        return view('components.tailwind-ui.sections.marketing.pricing-sections.pricing-section_01')->with([
            'models' => \App\Models\Plan::published()->get(),
        ]);
    }
}
