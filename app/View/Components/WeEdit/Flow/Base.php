<?php

namespace App\View\Components\WeEdit\Flow;

use Illuminate\View\Component;

class Base extends Component
{
    public $weEditData;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($weEditData)
    {
        $this->weEditData = $weEditData;
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.we-edit.flow.base');
    }
}
