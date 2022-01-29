<?php

namespace App\View\Components\Default\System;

use Illuminate\View\Component;

class InvalidMsg extends Component
{
    public $field;
    public $message;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field = '', $message = '', $class = 'mt-3')
    {
        $this->field = $field;
        $this->message = $message;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.system.invalid-msg');
    }
}
