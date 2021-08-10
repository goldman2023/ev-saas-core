<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CategoriesSidebar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $category_id;
    public $type;

    public function __construct($categoryId, $type)
    {
        $this->category_id = $categoryId;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.categories-sidebar');
    }
}
