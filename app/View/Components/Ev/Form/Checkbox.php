<?php

namespace App\View\Components\EV\Form;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $class;
    public $id;
    public $name;
    public $label;
    public $required;
    public $items;
    public $icon;
    public $merge;
    public $style;
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($items = [], $style = 'vanilla', $value = '', $name = '', $label = '',  $required = false,  $class = '', $id = '', $icon = null, $merge = false)
    {
        $this->items = $items;
        $this->label = $label;
        $this->name = $name;
        $this->required = $required;
        $this->class = $class;
        $this->id = $id;
        $this->merge = $merge;
        $this->icon = $icon;
        $this->style = $style;
        $this->value = $value;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.form.checkbox');
    }
}
