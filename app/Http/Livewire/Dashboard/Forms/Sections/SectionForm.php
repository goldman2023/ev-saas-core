<?php

namespace App\Http\Livewire\Dashboard\Forms\Sections;

use App\Enums\AmountPercentTypeEnum;
use App\Enums\StatusEnum;
use App\Facades\MyShop;
use App\Models\Category;
use App\Models\Section;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\RulesSets;
use Categories;
use DB;
use EVS;
use FX;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Permissions;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use App\Enums\PageTypeEnum;
use App\Enums\SectionTypeEnum;
use Theme;
use File;

class SectionForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $section;
    public $is_update;
    public $section_uuid;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($section = null)
    {
        $this->section = empty($section) ? new Section() : $section;
        $this->is_update = isset($this->section->id) && ! empty($this->section->id);

        if (!$this->is_update) {
            // If insert
            $this->section->status = StatusEnum::draft()->value;
            $this->section->type = SectionTypeEnum::twig()->value;
        } else {
            // $this->section->content = base64_encode($this->section->content);
        }

        

        $this->section_uuid = \UUID::generate(4)->string;
    }

    protected function rules()
    {
        $rules =  [
            'section.title' => 'required|min:2',
            'section.status' => [Rule::in(StatusEnum::toValues('archived'))],
            'section.type' => [Rule::in(SectionTypeEnum::toValues())],
            'section.content' => ['nullable'],
        ];

        if($this->is_update) {
            $rules['section.slug'] = 'required|unique:App\Models\Section,slug,'.$this->section->id;
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            
        ];
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    public function saveSection()
    {
        $this->section->content = base64_decode($this->section->content);

        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->section->status = StatusEnum::draft()->value;
            $this->validate();
        }

        try {
            $this->section->status = 'draft';
            $this->section->save();

            $this->inform(translate('Section saved successfully!'), '', 'success');
            // $this->emit('refreshPagesAndOpenNewPage', $this->section->id); //
        } catch (\Exception $e) {
            $this->inform(translate('There was an error while saving a section...Please try again.'), $e->getMessage(), 'fail');
        }
    }

    public function removeSection()
    {
    //    $address = app($this->currentAddress::class)->find($this->currentAddress->id)->fill($this->currentAddress->toArray());
    //    $address->remove();
    }

    public function render()
    {
        return view('livewire.dashboard.forms.sections.section-form');
    }
}
