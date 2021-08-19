<?php

namespace App\View\Components\tenant\product\reviews;

use App\Models\Product;
use Illuminate\View\Component;

class AddReviewModal extends Component
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
        return view('components.tenant.product.reviews.add-review-modal');
    }
}
