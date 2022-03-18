<?php

namespace App\View\Components\TailwindUi\Sections\Marketing\FeatureSections;

use Illuminate\View\Component;

class FeatureSection01 extends FeatureSection
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.sections.marketing.feature-sections.feature-section01');
    }
}
