<?php

namespace App\View\Components\Default\Products\Single;

use App\Models\Product;
use Illuminate\View\Component;

class ProductSlider extends Component
{

    public Product $product;
    public $photos;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        //
        $this->photos = explode(',', $product->photos);

        /* TODO: add placeholder images if there is less than 3 photos (needed for product single) */
        if(count($this->photos) > 2) {

        }

        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.products.single.product-slider');
    }
}
