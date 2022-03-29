<?php

namespace App\View\Components\TailwindUi\Sections\Marketing\HeroSections;

use App\View\Components\TailwindUi\WeComponent;
use Illuminate\View\Component;

class HeroSection02 extends HeroSection
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.sections.marketing.hero-sections.hero-section_02');
    }
}
