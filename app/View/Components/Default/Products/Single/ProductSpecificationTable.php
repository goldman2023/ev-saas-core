<?php

namespace App\View\Components\Default\Products\Single;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\View\Component;

class ProductSpecificationTable extends Component
{
    public Product $product;
    public $product_attributes;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        //
        $this->product = $product;
        $this->product_attributes = Attribute::where('content_type', 'App\Models\Product')->orderBy('created_at', 'desc')->get();

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.products.single.product-specification-table');
    }
}
