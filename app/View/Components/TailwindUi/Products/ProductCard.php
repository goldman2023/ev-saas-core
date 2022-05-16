<?php

namespace App\View\Components\TailwindUi\Products;

use App\View\Components\TailwindUi\WeComponent;
use Illuminate\View\Component;

class ProductCard extends WeComponent
{
    public $product;
    public $template;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($product, $template = null)
    {
        $this->product = $product;
        $this->template = $template;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if(!empty($this->template)) {
            return view('components.tailwind-ui.products.product-card-'.$this->template);
        } else {
            return view('components.tailwind-ui.products.product-card');
        }
    }
}
