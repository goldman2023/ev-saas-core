<?php

namespace App\View\Components\EV\Form;

use Illuminate\View\Component;

class FileSelector extends Component
{
    public $class;
    public $id;
    public $name;
    public $label;
    public $datatype;
    public $required;
    public $multiple;
    public $placeholder;
    public $icon_placement;
    public $icon;
    public $merge;
    public $sortable;
    public $sortableOptions;
    public $errorBagName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($datatype = 'image', $name = '', $label = '', $multiple = false, $required = false,  $class = '', $id = '', $placeholder = 'Choose File', $icon_placement = 'prepend', $icon = null, $merge = false, $sortable = false, $sortableOptions = [], $errorBagName = null)
    {
        $this->datatype = $datatype;
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
        $this->sortable = $sortable;
        $this->sortableOptions = $sortableOptions;
        $this->errorBagName = $errorBagName ?: $name;
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
