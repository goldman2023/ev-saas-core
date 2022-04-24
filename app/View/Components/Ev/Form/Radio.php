<?php

namespace App\View\Components\EV\Form;

use Illuminate\View\Component;

class Radio extends Component
{
    public $isWired;

    public $class;

    //public $id;
    public $name;

    public $appendToName;

    public $label;

    public $required;

    public $items;

    public $icon;

    public $merge;

    public $style;

    public $value;

    public $errorBagName;

    public $valueProperty;

    public $labelProperty;

    public $wireType;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($isWired = true, $items = [], $style = 'vanilla', $value = '', $name = '', $appendToName = false, $label = '', $valueProperty = null, $labelProperty = null, $required = false, $class = '', $icon = null, $merge = false, $errorBagName = null, $wireType = 'defer')
    {
        $this->isWired = $isWired;
        $this->wireType = $wireType;
        $this->items = $items;
        $this->label = $label;
        $this->name = $name;
        $this->appendToName = $appendToName;
        $this->valueProperty = $valueProperty;
        $this->labelProperty = $labelProperty;
        $this->required = $required;
        $this->class = $class;
        //$this->id = $id;
        $this->merge = $merge;
        $this->icon = $icon;
        $this->style = $style;
        $this->value = $value;
        $this->errorBagName = $errorBagName ?: $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.form.radio');
    }
}
