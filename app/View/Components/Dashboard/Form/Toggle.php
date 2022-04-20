<?php

namespace App\View\Components\Dashboard\Form;

use Illuminate\View\Component;

class Toggle extends Component
{
    public $field;

    public $label;

    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field = '', $label = '', $class = '')
    {
        $this->field = $field;
        $this->label = $label;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.form.toggle');
    }
}
