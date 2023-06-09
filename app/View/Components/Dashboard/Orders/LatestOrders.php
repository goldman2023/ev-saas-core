<?php

namespace App\View\Components\Dashboard\Orders;

use App\Models\Order;
use Illuminate\View\Component;

class LatestOrders extends Component
{
    public $orders;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($orders = null)
    {
        //
        $this->orders = Order::take(5)->orderBy('updated_at', 'desc')->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.orders.latest-orders');
    }
}
