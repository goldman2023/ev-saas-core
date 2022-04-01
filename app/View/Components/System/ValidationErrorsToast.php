<?php

namespace App\View\Components\System;

use Illuminate\View\Component;

class ValidationErrorsToast extends Component
{
    public $class;
    public $timeout;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = '', $timeout = 4000)
    {
        $this->class = $class;
        $this->timeout = $timeout;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.system.validation-errors-toast');
    }
}
