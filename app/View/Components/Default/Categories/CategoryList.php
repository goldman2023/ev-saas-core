<?php

namespace App\View\Components\Default\Categories;

use App\Models\Category;
use Illuminate\View\Component;

class CategoryList extends Component
{

    public $categories;
    public bool $slider;
    public $style;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($categories = null, $slider = false, $style = 'category-list-small')
    {
        //
        if ($categories === null) {
            $this->categories = Category::where('level', 0)
                ->orderBy('order_level', 'desc')
                ->get();
        } else {
            $this->categories = $categories;
        }

        $this->slider = $slider;
        $this->style = $style;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.categories.list.' . $this->style );
    }
}
