<?php

namespace App\View\Components\Dashboard\Form;

use Illuminate\View\Component;

class EditorJs extends Component
{
    public $field;
    public $structureField;
    public $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field = 'description', $structureField = 'description', $id = '')
    {
        $this->field = $field;
        $this->structureField = $structureField;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.form.editor-js');
    }
}
