<?php

namespace App\View\Components\Blog;

use App\Models\Category;
use Illuminate\View\Component;

class CategoriesList extends Component
{
    public $all_categories;
    public $category;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($category = null)
    {
        //
        $this->all_categories = \Categories::getAll(false);
        $this->category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.blog.categories-list');
    }
}
