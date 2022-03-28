<?php

namespace App\View\Components\TailwindUi\Sections\Marketing\CtaSections;

use App\View\Components\TailwindUi\WeComponent;
use Illuminate\View\Component;

class CtaSection extends WeComponent
{


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.sections.marketing.cta-sections.cta-section');
    }
}
