<?php

namespace App\View\Components\Panels;

use App\Facades\Categories;
use Illuminate\View\Component;

class FlyoutCategories extends Component
{
    public $categories;
    //public $count;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categories = Categories::getAll();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.panels.flyout-categories');
    }
}
