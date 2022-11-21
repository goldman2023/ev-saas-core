<?php

namespace App\View\Components\Default\Categories;

use App\Models\Category;
use Categories;
use Illuminate\View\Component;

class CategoryList extends Component
{
    public $categories;

    public $selectedCategory;

    public bool $slider;

    public $style;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selectedCategory = null, $slider = false, $style = 'category-list')
    {
        $this->categories = Categories::getAll();
        $this->selectedCategory = $selectedCategory;
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
        return view('components.default.categories.list.'.$this->style);
    }
}
