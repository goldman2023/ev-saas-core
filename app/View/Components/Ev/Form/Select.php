<?php

namespace App\View\Components\EV\Form;

use Illuminate\View\Component;

class Select extends Component
{
    public $isWired;
    public $class;
    public $id;
    public $name;
    public $label;
    public $type;
    public $required;
    public $placeholder;
    public $icon;
    public $merge;
    public $items;
    public $valueProperty;
    public $labelProperty;
    public $selected;
    public $search;
    public $multiple;
    public $tags;
    public $options;
    public $errorBagName;
    public $disabled;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($isWired = true, $type = 'text', $name = '', $label = '', $items = [], $valueProperty = null, $labelProperty = null, $selected = null, $search = false, $multiple = false, $tags = false, $required = false,  $class = '', $id = '', $placeholder = '', $icon = null, $merge = false, $errorBagName = null, $disabled = false)
    {
        $this->isWired = $isWired;
        $this->type = $type;
        $this->label = $label;
        $this->items = collect($items);
        $this->valueProperty = $valueProperty;
        $this->labelProperty = $labelProperty;
        $this->selected = $selected;
        $this->search = $search;
        $this->name = $name;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->icon = $icon;
        $this->merge = $merge;
        $this->multiple = $multiple;
        $this->tags = $tags;
        $this->class = $class;
        $this->id = $id;
        $this->errorBagName = $errorBagName ?: $name;
        $this->disabled = $disabled;

        /*$this->options = [
            'customClass' => 'custom-select',
        ];*/
        if(!$search) {
            $this->options['minimumResultsForSearch'] = 'Infinity';
        } else {
            $this->options['searchInputPlaceholder'] = translate('Search...');
        }

        if($placeholder) {
            $this->options['placeholder'] = $placeholder;
        }

        if($tags) {
            $this->options['tags'] = true;
        }

        if($disabled) {
            $this->options['disabled'] = true;
        }
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.form.select');
    }
}
