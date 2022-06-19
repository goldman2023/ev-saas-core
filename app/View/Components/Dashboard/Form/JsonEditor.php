<?php

namespace App\View\Components\Dashboard\Form;

use Illuminate\View\Component;

class JsonEditor extends Component
{
    public $field;
    public $mode;
    public $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field = '', $id = '', $mode = 'form')
    {
        $this->field = $field;
        $this->id = $id;
        $this->mode = $mode;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.form.json-editor');
    }
}
