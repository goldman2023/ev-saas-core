<?php

namespace App\View\Components\WeEdit\FieldPartials;

use Illuminate\View\Component;

class Slot extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.we-edit.field-partials.slot');
    }
}
