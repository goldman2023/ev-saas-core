<?php

namespace App\View\Components\TailwindUi\Headers;

use Illuminate\View\Component;

class HeaderWithSearchDark extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.headers.header-with-search-dark');
    }
}