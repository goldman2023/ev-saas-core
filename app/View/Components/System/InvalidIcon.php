<?php

namespace App\View\Components\System;

use Illuminate\View\Component;

class InvalidIcon extends Component
{
    public $icon;
    public $field;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field, $icon = 'lineawesome-exclamation-circle-solid')
    {
        $this->icon = $icon;
        $this->field = $field;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if(session('style_framework') === 'tailwind') {
            return view('components.tailwind-ui.system.invalid-icon');
        }

        return view('components.bootstrap.system.invalid-icon');
    }
}
