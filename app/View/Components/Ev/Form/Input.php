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
    public $placement;
    public $icon;
    public $text;
    public $merge;
    public $groupclass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'text', $name = '', $label = '',  $required = false,  $class = '', $groupclass = '', $id = '', $placeholder = '', $placement = 'prepend', $icon = null, $text = null, $merge = false)
    {
        $this->type = $type;
        $this->label = $label;
        $this->name = $name;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->class = $class;
        $this->groupclass = $groupclass;
        $this->id = $id;
        $this->merge = $merge;
        $this->placement = $placement;
        $this->icon = $icon;
        $this->text = $text;
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
