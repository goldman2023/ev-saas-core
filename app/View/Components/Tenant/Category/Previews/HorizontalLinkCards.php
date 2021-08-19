<?php

namespace App\View\Components\Tenant\Category\Previews;

use Illuminate\View\Component;

class HorizontalLinkCards extends Component
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
        $this->categories = \App\Models\Category::where('level', 0)->get();

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tenant.category.previews.horizontal-link-cards');
    }
}
