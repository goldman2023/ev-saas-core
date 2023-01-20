<?php

namespace App\View\Components\Dashboard\Orders;

use Illuminate\View\Component;

class OrderDetailsCard extends Component
{
    public $order;
    public $print;
    public $product;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($order, $print = false)
    {
        $this->order = $order;
        $this->print = $print;
        $this->product = $order->get_primary_order_item()->subject;

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
