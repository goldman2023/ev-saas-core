<?php

namespace App\View\Components\Dashboard\Orders;

use App\Enums\OrderStatusEnum;
use Illuminate\View\Component;

class OrderSteps extends Component
{
    public $steps;
    public $order;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        //
        $this->order = $order;
        $this->steps = OrderStatusEnum::labels();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.orders.order-steps');
    }
}
