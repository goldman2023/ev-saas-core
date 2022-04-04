<?php

namespace App\View\Components\TailwindUi\Sections\Marketing\FeatureSections;

use App\View\Components\TailwindUi\WeComponent;
use Illuminate\View\Component;

class FeatureSection extends WeComponent
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.sections.marketing.feature-sections.feature-section');
    }
}
