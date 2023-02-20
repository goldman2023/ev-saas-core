<?php

namespace App\View\Components\System;

use Session;
use App\Models\Product;
use App\Facades\CartService;
use Illuminate\View\Component;
use App\Models\ProductVariation;

class WePrice extends Component
{
    public $model;
    public $withQty;
    public $class;

    public $base_price = 0;
    public $total_price = 0;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model = null, $withQty = false, $class = '')
    {
        $this->model = $model;
        $this->withQty = $withQty;
        $this->class = $class;

        if(!empty($model)) {
            if($this->withQty) {
                $this->base_price = \FX::formatPrice($model->purchase_quantity * $model->getBasePrice());
                $this->total_price = \FX::formatPrice($model->purchase_quantity * $model->getTotalPrice());
            } else {
                $this->base_price = $model->getBasePrice(true);
                $this->total_price = $model->getTotalPrice(true);
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.system.we-price');
    }
}
