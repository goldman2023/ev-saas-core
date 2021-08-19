<?php

namespace App\View\Components\Tenant\Product\Reviews;

use App\Models\Product;
use Illuminate\View\Component;

class ShowReviews extends Component
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
        return view('components.tenant.product.reviews.show-reviews');
    }
}
