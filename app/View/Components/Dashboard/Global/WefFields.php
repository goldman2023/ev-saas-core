<?php

namespace App\View\Components\Dashboard\Global;

use Illuminate\View\Component;

class WefFields extends Component
{
    public $model;
    public $wefFields;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model, $wefFields)
    {
        //
        $this->model = $model;
        $this->wefFields = $wefFields;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.global.wef-fields');
    }
}
