<?php

namespace App\View\Components\Default\Modals;

use Illuminate\View\Component;

class ProductMessageModal extends Component
{
    public $product;
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
        return view('components.default.modals.product-message-modal');
    }
}
