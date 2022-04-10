<?php

namespace App\View\Components\Feed\Elements;

use App\Models\Product;
use Illuminate\View\Component;

class Pagination extends Component
{

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.feed.elements.pagination');
    }
}
