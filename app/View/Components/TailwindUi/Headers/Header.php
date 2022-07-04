<?php

namespace App\View\Components\TailwindUi\Headers;

use App\View\Components\TailwindUi\WeComponent;
use Illuminate\View\Component;

class Header extends WeComponent
{
    public $template;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($template = 'header_01')
    {

        $this->template = $template;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.headers.'.$this->template);
    }
}
