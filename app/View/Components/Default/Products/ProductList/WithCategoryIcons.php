<?php

namespace App\View\Components\Default\Products\ProductList;

use Illuminate\View\Component;

class WithCategoryIcons extends Component
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
        return view('components.default.products.product-list.with-category-icons');
    }
}
