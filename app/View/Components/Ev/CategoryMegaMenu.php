<?php

namespace App\View\Components\Ev;

use Illuminate\View\Component;
use App\Facades\Categories;

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
