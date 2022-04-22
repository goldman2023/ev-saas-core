<?php

namespace App\View\Components\Default\Footers;

use Illuminate\View\Component;

class Footer extends Component
{
    public $style = 'default';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($style = 'default')
    {
        //
        $this->style = $style;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.footers.'.$this->style);
    }
}
