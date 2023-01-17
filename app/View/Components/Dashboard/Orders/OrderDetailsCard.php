<?php

namespace App\View\Components\Dashboard\Orders;

use Illuminate\View\Component;

class OrderDetailsCard extends Component
{
    public $order;
    public $print;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($order, $print = false)
    {
        $this->order = $order;
        $this->print = $print;
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->print) {
            return view('components.dashboard.orders.order-details-card-print');
        } else {
            return view('components.dashboard.orders.order-details-card');
        }
    }
}
