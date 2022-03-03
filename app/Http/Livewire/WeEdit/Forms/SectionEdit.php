<?php

namespace App\Http\Livewire\WeEdit\Forms;

use Livewire\Component;
use App\Traits\Livewire\DispatchSupport;
use App\Enums\WeEditLayoutEnum;

class SectionEdit extends Component
{
    use DispatchSupport;

    public $section;
    public $current_preview;

    public function mount($current_preview, $section = null)
    {
        $this->current_preview = $current_preview;
        $this->section = $section;
    }

    public function rules() {
        return [
            'current_preview.id' => '',
            'current_preview.content' => '',
            'current_preview.content.*' => '',
            'section' => '',
        ];
    }

    public function messages() {
        return [];
    }

    public function dehydrate() {
        // $this->dispatchBrowserEvent('');
    }

    public function setSection($section_uuid) {
        $this->section = collect($this->current_preview->content)->firstWhere('uuid', $section_uuid);
    }
    
    public function render()
    {
        return view('livewire.we-edit.forms.section-edit');
    }
}