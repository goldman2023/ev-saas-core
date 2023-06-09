<?php

namespace App\Http\Livewire\WeEdit\Panels;

use App\Enums\WeEditLayoutEnum;
use Livewire\Component;
use WeBuilder;

class AvailableSections extends Component
{
    public $available_sections;

    public $available_sections_flat;

    public $html_section_template;

    public function mount()
    {
        $this->available_sections = WeBuilder::getAllThemeSections('tailwind-ui');
        $this->available_sections_flat = WeBuilder::getAllThemeSections('tailwind-ui', true);
        $this->html_section_template = WeBuilder::getHtmlSectionTemplate();
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initAvailableSectionsPanel');
    }

    public function addSectionToPreview($section_id)
    {
        if (isset($this->available_sections_flat[$section_id])) {
            $this->emit('addSectionToPreviewEvent', [
                'id' => $section_id,
                'section' => $this->available_sections_flat[$section_id],
            ]);
        }
    }

    public function addHtmlSectionToPreview()
    {
        $this->emit('addHtmlSectionToPreviewEvent', [
            'id' => 'html',
            'section' => $this->html_section_template,
        ]);
    }

    public function render()
    {
        return view('livewire.we-edit.panels.available-sections');
    }
}
