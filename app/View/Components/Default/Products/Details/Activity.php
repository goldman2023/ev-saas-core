<?php

namespace App\View\Components\Default\Products\Details;

use App\Models\Product;
use Illuminate\View\Component;

class Activity extends Component
{
    public Product $product;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        //
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.products.details.activity');
    }
}