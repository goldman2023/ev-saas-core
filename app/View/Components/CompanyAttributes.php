<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CompanyAttributes extends Component
{
    public $items, $selected;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($items, $selected)
    {
        $this->items = $items;
        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.company-attributes');
    }
}
