<?php

namespace App\View\Components\TailwindUi\Sections\Marketing\ContentSections;

use Illuminate\View\Component;

class ContentSection01 extends ContentSection
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.sections.marketing.content-sections.content-section_01');
    }
}
