<?php

namespace App\View\Components\Default\Categories\List;

use Illuminate\View\Component;

class CategoryListSmall extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //

        dd("11");
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.categories.list.category-list-small');
    }
}
