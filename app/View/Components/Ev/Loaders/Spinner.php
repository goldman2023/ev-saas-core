<?php

namespace App\View\Components\EV\Loaders;

use Illuminate\View\Component;

class Spinner extends Component
{
    public $class;

    public $title;

    public $style;

    public $spinnerClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = '', $style = '', $spinnerClass = '', $title = 'Loading...')
    {
        $this->class = $class;
        $this->title = $title;
        $this->style = $style;
        $this->spinnerClass = $spinnerClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.loaders.spinner');
    }
}
