<?php

namespace App\View\Components\EV\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public $class;
    public $id;
    public $name;
    public $label;
    public $type;
    public $required;
    public $placeholder;
    public $icon_placement;
    public $icon;
    public $merge;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'text', $name = '', $label = '', $required = false,  $class = '', $id = '', $placeholder = '', $icon_placement = 'prepend', $icon = null, $merge = false)
    {
        $this->type = $type;
        $this->label = $label;
        $this->name = $name;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->class = $class;
        $this->id = $id;
        $this->merge = $merge;
        $this->icon_placement = $icon_placement;
        $this->icon = $icon;
        $this->merge = $merge;
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
