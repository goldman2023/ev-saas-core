<?php

namespace App\View\Components\Tenant\Category\Previews;

use App\Models\Category;
use Illuminate\View\Component;

class WithScrollingCards extends Component
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
        $this->categories = Category::where('level', 0)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tenant.category.previews.with-scrolling-cards');
    }
}
