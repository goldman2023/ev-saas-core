<?php

namespace App\View\Components\Dashboard\Widgets;

use App\Facades\Categories;
use Illuminate\View\Component;

class TopCategories extends Component
{
    public $categories;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->categories = Categories::getAll(true)->sortBy('created_at')->take(5);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.widgets.top-categories');
    }
}
