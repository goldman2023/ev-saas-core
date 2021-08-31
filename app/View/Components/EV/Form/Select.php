<?php

namespace App\View\Components\EV\Form;

use Illuminate\View\Component;

class Select extends Component
{
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
    public $value_property;
    public $label_property;
    public $search;
    public $multiple;
    public $tags;
    public $options;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'text', $name = '', $label = '', $items = [], $value_property = null, $label_property = null, $search = false, $multiple = false, $tags = false, $required = false,  $class = '', $id = '', $placeholder = '', $icon = null, $merge = false)
    {
        $this->type = $type;
        $this->label = $label;
        $this->items = collect($items);
        $this->value_property = $value_property;
        $this->label_property = $label_property;
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

        $this->options = [
            'customClass' => 'custom-select',
        ];
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
