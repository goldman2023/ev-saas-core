<?php

namespace App\View\Components\TailwindUi\Sections\Marketing\ContentSections;

use App\Models\Section;
use App\View\Components\TailwindUi\WeComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Component;

class CustomSection extends WeComponent
{
    public $custom_section_id;
    public $custom_content;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if (isset($this->weData['hero_info_slot']['components']['hero_info_label']['data']['label'])) {
            $this->custom_section_id = $this->weData['hero_info_slot']['components']['hero_info_label']['data']['label'];

            $section = Section::find($this->custom_section_id);
            if(isset($section->html_blade)) {
                $this->custom_content = $section->html_blade;
            }

        }

        return $this->bladeCompile($this->custom_content);

        return view('components.tailwind-ui.sections.marketing.content-sections.custom-section');
    }

    public function bladeCompile($value, array $args = array())
    {
        $generated = Blade::compileString($value);


        ob_start() and extract($args, EXTR_SKIP);


        // We'll include the view contents for parsing within a catcher
        // so we can avoid any WSOD errors. If an exception occurs we
        // will throw it out to the exception handler.


        // If we caught an exception, we'll silently flush the output
        // buffer so that no partially rendered views get thrown out
        // to the client and confuse the user with junk.
        $content = ob_get_clean();


        return $generated;
    }
}
