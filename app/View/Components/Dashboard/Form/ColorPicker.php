<?php

namespace App\View\Components\Dashboard\Form;

use Illuminate\View\Component;

class ColorPicker extends Component
{
    public $field;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field = '')
    {
        $this->field = $field;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.form.color-picker');
    }
}
