<?php

namespace App\View\Components\Tailwind\Category\List;

use App\Facades\Categories;
use App\Http\Services\CategoryService;
use App\Models\Category;
use App\Support\Eloquent\Collection;
use Illuminate\View\Component;

class CategoryListBasic extends Component
{
    public $categories;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($categories = null)
    {
        //
        if($categories) {
            $this->categories = $categories;
        } else {
            $this->categories = Categories::getAll();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind.category.list.category-list-basic');
    }
}
