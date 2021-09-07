<?php

namespace App\View\Components\EV\Form;

use Illuminate\View\Component;

class DateTimePicker extends Component
{
    public $groupclass;
    public $class;
    public $id;
    public $options;
    public $name;
    public $value;
    public $label;
    public $required;
    public $placeholder;
    public $placement;
    public $icon;
    public $merge;
    public $errorBagName;
    public $valueProperty;
    public $labelProperty;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($options = ['dateFormat' => 'd/m/Y'], $name = '', $label = '',  $valueProperty = null, $labelProperty = null, $required = false,  $class = '', $groupclass = '', $id = '', $value = null, $placeholder = '', $placement = 'prepend', $icon = null, $merge = false, $errorBagName = null)
    {
        $this->options = $options;
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
        $this->placement = $placement;
        $this->merge = $merge;
        $this->icon = $icon;
        $this->errorBagName = $errorBagName ?: $name;

        if(!empty($this->icon)) {
            $this->options['appendTo'] = '#'.$this->id;
            $this->options['wrap'] = true;
        }
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.form.date-time-picker');
    }
}
