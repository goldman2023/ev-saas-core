<?php

namespace App\View\Components\Default\Categories;

use Illuminate\View\Component;

class SubCategoryCards extends Component
{
    public $categories;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($categories = null)
    {
        $this->categories = $categories->children ?? null;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.categories.sub-category-cards');
    }
}