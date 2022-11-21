<?php

namespace App\View\Components\Dashboard\Forms;

use Illuminate\View\Component;

class CoreMetaField extends Component
{
    public $field;
    public $subject;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field)
    {
        //
        $this->field = $field;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.forms.core-meta-field');
    }
}
