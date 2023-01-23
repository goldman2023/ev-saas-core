<?php

namespace App\View\Components\Dashboard\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public $inputId;
    public $field;
    public $type;
    public $value;
    public $placeholder;
    public $nullable;
    public $required;
    public $min;
    public $max;
    public $step;
    public $x;
    public $class;
    public $inputClass;
    public $disabled;
    public $errorField;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $inputId = null,
        $field = '', 
        $errorField = '', 
        $type = 'text', 
        $placeholder = '', 
        $nullable = true, 
        $required = false, 
        $min = 0, 
        $max = null, 
        $step = 1, 
        $x = false, 
        $class = '', 
        $inputClass = '', 
        $disabled = false, 
        $value = null
    )
    {
        $this->inputId = $inputId;
        $this->field = $field;
        $this->type = $type;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->nullable = $nullable;
        $this->required = $required;
        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
        $this->x = $x;
        $this->class = $class;
        $this->disabled = $disabled;
        $this->errorField = $errorField;

        if($type === 'radio') {
            $this->inputClass = $inputClass;
        } else if($type === 'radio') {
            $this->inputClass = $inputClass;
        } else {
            $this->inputClass = 'form-standard '.$inputClass;
        }


    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.form.input');
    }
}
