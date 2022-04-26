<?php

namespace App\View\Components\Tenant\Product\Cards;

use App\Models\Product;
use Illuminate\View\Component;

class ImageOverlayAndButton extends Component
{
    public Product $product;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($product)
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
        return view('components.tenant.product.cards.image-overlay-and-button');
    }
}
