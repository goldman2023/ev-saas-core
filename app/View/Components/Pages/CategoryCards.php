<?php

namespace App\View\Components\Pages;

use App\Models\Category;
use Illuminate\View\Component;

class CategoryCards extends Component
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
        $this->categories = Category::where('featured', true)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pages.category-cards');
    }
}
