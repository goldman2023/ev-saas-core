<?php

namespace App\View\Components\Dashboard\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public $field;
    public $placeholder;
    public $nullable;
    public $required;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field = '', $placeholder = '', $nullable = true, $required = false)
    {
        $this->field = $field;
        $this->placeholder = $placeholder;
        $this->nullable = $nullable;
        $this->required = $required;
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
