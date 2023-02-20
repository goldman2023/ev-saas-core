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

    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model = null, $class = '')
    {
        $this->model = $model;
        $this->class = $class;
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
