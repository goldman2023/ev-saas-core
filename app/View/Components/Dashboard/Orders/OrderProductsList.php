<?php

namespace App\View\Components\Dashboard\Orders;

use Illuminate\View\Component;

class OrderProductsList extends Component
{
    public $order_items;
    public $order;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($orderItems, $order)
    {
        //
        $this->order = $order;
        $this->order_items = $orderItems;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.orders.order-products-list');
    }
}
