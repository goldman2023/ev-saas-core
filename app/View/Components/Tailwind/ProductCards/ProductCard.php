<?php

namespace App\View\Components\Tailwind\ProductCards;

use Illuminate\View\Component;

class ProductCard extends Component
{
    public $product;
    public $template = 'product-card-simple'; // product-card-with-overlay-and-button
    /* TODO: Define available templates somehow */
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($product, $template = 'product-card-simple')
    {
        //
        $this->template = $template;
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind.product-cards.' . $this->template);
    }
}
