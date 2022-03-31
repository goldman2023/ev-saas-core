<?php

namespace App\View\Components\System;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\View\Component;
use App\Facades\CartService;
use Session;

class AddToCartButton extends Component
{
    public $model;
    public $class;
    public $icon;
    public $label;
    public $labelNotInStock;
    public $qty;
    public $processing;
    public $disabled;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model = null, $class = '', $icon = '', $label = 'Add to cart', $labelNotInStock = 'Not in stock')
    {
        $this->model = $model;
        $this->disabled = !$model->isInStock();
        $this->label = $label;
        $this->labelNotInStock = $labelNotInStock;
        $this->class = $class;
        $this->icon = $icon;
        $this->qty = 0;
        $this->processing = false;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() {
        return view('components.tailwind-ui.system.add-to-cart-button');
    }
}
