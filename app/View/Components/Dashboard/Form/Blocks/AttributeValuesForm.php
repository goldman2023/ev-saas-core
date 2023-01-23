<?php

namespace App\View\Components\Dashboard\Form\Blocks;

use Illuminate\View\Component;

class AttributeValuesForm extends Component
{
    public $formId;
    public $attribute;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($formId = '', $attribute = null)
    {
        $this->formId = $formId;
        $this->attribute = $attribute;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.form.blocks.attribute-values-form');
    }
}
