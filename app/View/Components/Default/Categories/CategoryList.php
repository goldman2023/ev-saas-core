<?php

namespace App\View\Components\Default\Categories;

use Illuminate\View\Component;

class CategoryList extends Component
{

    public $categories;
    public bool $slider;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($categories, $slider = false)
    {
        //
        $this->categories = $categories;
        $this->slider = $slider;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.categories.category-list');
    }
}
