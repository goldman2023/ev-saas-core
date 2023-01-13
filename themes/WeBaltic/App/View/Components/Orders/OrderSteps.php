<?php

namespace WeThemes\WeBaltic\App\View\Components\Orders;

use Illuminate\View\Component;
use WeThemes\WeBaltic\App\Enums\OrderCycleStatusEnum;

class OrderSteps extends Component
{
    public $steps;
    public $order;
    public $order_cycle_status;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        //
        $this->order = $order;
        $this->steps = OrderCycleStatusEnum::labels();

        $this->order_cycle_status = $this->order->getWEF('cycle_status');
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
