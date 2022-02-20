<?php

namespace App\View\Components\Default\Products;

use Illuminate\View\Component;

class RecentlyViewedProducts extends Component
{
    public $products;

    public $columns = 3;
    public $style = 'grid';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($columns = 3, $style = 'grid')
    {
        //
        if(auth()->user()){
            $this->products = auth()->user()->recently_viewed_products();
        } else {
            /* TODO: If user is guest save product's in session storage */
            $this->products = collect([]);
        }

        $this->columns = $columns;
        $this->style = $style;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
if($this->style == 'grid'){
        return view('components.default.products.recently-viewed-products');
    } else {
        return view('components.default.products.recently-viewed-products-list');

    }
}
}
