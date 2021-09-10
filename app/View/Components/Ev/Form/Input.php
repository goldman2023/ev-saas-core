<?php

namespace App\View\Components\EV\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public $class;
    public $id;
    public $name;
    public $value;
    public $label;
    public $type;
    public $required;
    public $placeholder;
    public $placement;
    public $icon;
    public $text;
    public $merge;
    public $groupclass;
    public $errorBagName;
    public $valueProperty;
    public $labelProperty;
    public $wireType;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'text', $name = '', $label = '', $value = '', $valueProperty = null, $labelProperty = null, $required = false,  $class = '', $groupclass = '', $id = '', $placeholder = '', $placement = 'prepend', $icon = null, $text = null, $merge = false, $errorBagName = null, $wireType = 'defer')
    {
        $this->type = $type;
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->valueProperty = $valueProperty;
        $this->labelProperty = $labelProperty;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->class = $class;
        $this->groupclass = $groupclass;
        $this->id = $id;
        $this->merge = $merge;
        $this->placement = $placement;
        $this->icon = $icon;
        $this->text = $text;
        $this->wireType = $wireType;
        $this->errorBagName = $errorBagName ?: $name;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.form.input');
    }
}
