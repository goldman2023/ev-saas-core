<?php

namespace App\View\Components\Default\Categories\List;

use App\Models\Category;
use Illuminate\View\Component;

class CategoryListWithLeftTabs extends Component
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
        if ($categories === null) {
            $this->categories = Category::where('level', 0)
                ->orderBy('order_level', 'desc')
                ->take(5)
                ->get();
        } else {
            $this->categories = $categories;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.categories.list.category-list-with-left-tabs');
    }
}
