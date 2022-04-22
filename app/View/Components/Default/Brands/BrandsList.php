<?php

namespace App\View\Components\Default\Brands;

use Illuminate\View\Component;

class BrandsList extends Component
{
    public $brands;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //

        $this->brands = \App\Models\Brand::take(15)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.brands.brands-list');
    }
}
