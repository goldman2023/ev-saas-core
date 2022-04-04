<?php

namespace App\View\Components\TailwindUi\Headers;

use Illuminate\View\Component;

class Header extends Component
{
    public $template;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($template = 'header-with-search-dark')
    {
        //
        $this->template = $template;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.headers.' . $this->template);
    }
}
