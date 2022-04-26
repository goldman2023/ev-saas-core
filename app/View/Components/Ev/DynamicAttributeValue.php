<?php

namespace App\View\Components\Ev;

use Illuminate\View\Component;

class DynamicAttributeValue extends Component
{
    public $data;

    public $attribute;

    public $attribute_value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($data, $attribute = 7)
    {
        //
        $this->data = $data;
        $this->attribute = $attribute;

        $this->attribute_value = $this->data
            ->custom_attributes()
            ->where('attribute_id', $this->attribute->value)->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.dynamic-attribute-value');
    }
}
