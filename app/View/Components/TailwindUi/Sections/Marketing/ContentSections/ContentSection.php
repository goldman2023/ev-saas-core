<?php

namespace App\View\Components\TailwindUi\Sections\Marketing\ContentSections;

use App\View\Components\TailwindUi\WeComponent;
use Illuminate\View\Component;

class ContentSection extends WeComponent
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.sections.marketing.content-sections.content-section');
    }
}
