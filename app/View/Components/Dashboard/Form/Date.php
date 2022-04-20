<?php

namespace App\View\Components\Dashboard\Form;

use Illuminate\View\Component;

class Date extends Component
{
    public $field;

    public $mode;

    public $enableTime;

    public $dateFormat;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field = '', $mode = 'single', $enableTime = false, $dateFormat = 'd.m.Y.')
    {
        $this->field = $field;
        $this->mode = $mode;
        $this->enableTime = $enableTime;
        $this->dateFormat = $dateFormat;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.form.date');
    }
}
