<?php

namespace App\View\Components\Default\Products;
use App\Models\Product;

use Illuminate\View\Component;

class ProductList extends Component
{
    public $products;
    public $items;
    public bool $slider;
    public $sliderOptions;
    public $style = 'product-list'; // Available styles products-list/ top-products-slider / products-slider
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($items = 8, $slider = false, $products = null, $style = 'product-list')
    {
        if($products != null) {
            $this->products = $products;
        } else {
            $products = Product::paginate($items);
        }
        $this->products = $products;
        $this->slider = $slider;
        $this->style = $style;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.products.product-list.' . $this->style);
    }
}
