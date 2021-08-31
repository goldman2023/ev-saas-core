<?php

namespace App\View\Components\Default\Categories;

use Illuminate\View\Component;

class CategoryTabsWithProducts extends Component
{

    public $categories;

    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct($categories)
    {
        //
        $this->categories = $categories;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.categories.category-tabs-with-products');
    }
}
