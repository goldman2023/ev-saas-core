<?php

namespace WeThemes\WeBaltic\App\View\Components\Dashboard\Orders;

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
    public function __construct($order = null)
    {
        $this->steps = OrderCycleStatusEnum::labels();

        if ($order) {
            $this->order = $order;

            $this->order_cycle_status = $this->order->getWEF('cycle_status');
        } else {
            $this->order_cycle_status = 0;

        }
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
