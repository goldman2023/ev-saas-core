<?php

namespace App\View\Components\Dashboard\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public $field;
    public $type;
    public $placeholder;
    public $nullable;
    public $required;
    public $min;
    public $max;
    public $step;
    public $x;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field = '', $type = 'text', $placeholder = '', $nullable = true, $required = false, $min = 0, $max = null, $step = 1, $x = false)
    {
        $this->field = $field;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->nullable = $nullable;
        $this->required = $required;
        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
        $this->x = $x;
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
