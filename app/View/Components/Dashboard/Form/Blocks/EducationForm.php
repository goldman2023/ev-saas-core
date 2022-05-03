<?php

namespace App\View\Components\Dashboard\Form\Blocks;

use Illuminate\View\Component;

class EducationForm extends Component
{
    public $field;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field = 'meta.education.value')
    {
        $this->field = $field;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.form.blocks.education-form');
    }
}
