<?php

namespace App\View\Components\EV\Form;

use Illuminate\View\Component;

class CategoriesSelector extends Component
{
    public $x;
    public $class;
    public $appendToName;
    public $name;
    public $label;
    public $required;
    public $items;
    public $icon;
    public $merge;
    public $style;
    public $errorBagName;
    public $multiple;
    public $placeholder;
    public $options;
    public $selectedCategories;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($x = false, $items = [], $name = '', $appendToName = false, $selectedCategories = [], $label = '',  $multiple = false, $placeholder = '', $required = false,  $class = '', $icon = null, $merge = false, $errorBagName = null)
    {
        $this->x = $x;
        $this->items = $items;
        $this->label = $label;
        $this->name = $name;
        $this->appendToName = $appendToName;
        $this->required = $required;
        $this->multiple = $multiple;
        $this->class = $class;
        $this->merge = $merge;
        $this->icon = $icon;
        $this->placeholder = $placeholder;
        $this->errorBagName = $errorBagName ?: $name;
        $this->selectedCategories = $selectedCategories;

        $this->options = '{"dropdownParent": ".categories-selector-wrapper", "selectionCssClass":"categories-selector-level-0 mt-2", "minimumResultsForSearch":-1, "placeholder":{"id":"-1","text":"'.translate('Select category...').'"}, "multiple":true, "closeOnSelect": false, "scrollAfterSelect": false }';
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if($this->x) {
            return view('components.ev.form.alpine.categories-selector');
        }

        return view('components.ev.form.categories-selector');
    }
}
