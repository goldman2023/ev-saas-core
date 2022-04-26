<?php

namespace App\View\Components\Ev;

use App\Facades\Categories;
use App\Models\Category;
use Illuminate\View\Component;

class CategoryMegaMenu extends Component
{
    public $categories;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $categories = Categories::getAll();
        $categories = Category::whereNull('parent_id')->withCount('products')->orderBy('products_count', 'desc')->paginate(15);
        $this->categories = $categories;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.category-mega-menu');
    }
}
