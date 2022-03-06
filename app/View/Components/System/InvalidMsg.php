<?php

namespace App\View\Components\System;

use Illuminate\View\Component;

class InvalidMsg extends Component
{
    public $field;
    public $message;
    public $class;
    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field = '', $message = '', $class = 'mt-2', $type = 'slim')
    {
        $this->field = $field;
        $this->message = $message;
        $this->class = $class;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if(session('style_framework') === 'tailwind') {
            return view('components.tailwind-ui.system.invalid-msg');
        }

        return view('components.bootstrap.system.invalid-msg');
    }
}
