<?php

namespace App\View\Components\Dashboard\Form\Blocks;

use Illuminate\View\Component;

class AttributesSelectionForm extends Component
{
    public $formId;
    public $attributesField;
    public $selectedAttributesField;
    public $noVariations;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($formId = '', $attributesField = 'attributes', $selectedAttributesField = 'selected_attribute_values', $noVariations = false)
    {
        $this->formId = $formId;
        $this->attributesField = $attributesField;
        $this->selectedAttributesField = $selectedAttributesField;
        $this->noVariations = $noVariations;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.form.blocks.attributes-selection-form');
    }
}
