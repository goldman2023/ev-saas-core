<?php

namespace App\View\Components\EV\Form;

use Illuminate\View\Component;

class FileSelector extends Component
{
    public $class;
    public $id;
    public $name;
    public $label;
    public $data_type;
    public $required;
    public $multiple;
    public $placeholder;
    public $icon_placement;
    public $icon;
    public $merge;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($data_type = 'image', $name = '', $label = '', $multiple = false, $required = false,  $class = '', $id = '', $placeholder = 'Choose File', $icon_placement = 'prepend', $icon = null, $merge = false)
    {
        $this->data_type = $data_type;
        $this->label = $label;
        $this->name = $name;
        $this->required = $required;
        $this->multiple = $multiple;
        $this->placeholder = $placeholder;
        $this->class = $class;
        $this->id = $id;
        $this->merge = $merge;
        $this->icon_placement = $icon_placement;
        $this->icon = $icon;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.form.file-selector');
    }
}
