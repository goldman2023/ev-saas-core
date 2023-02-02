<?php

namespace WeThemes\WeBaltic\App\View\Components\Dashboard\Orders;

use Illuminate\View\Component;
use WeThemes\WeBaltic\App\Enums\OrderCycleStatusEnum;

class CustomerOrderSteps extends Component
{
    public $steps;
    public $order;
    public $order_cycle_status;
    public $steps_description;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($order, $class = '')
    {
        $this->class = $class;
        $this->order = $order;
        $this->steps = OrderCycleStatusEnum::getPublicStatusesLabels();
        $this->steps_description = OrderCycleStatusEnum::getPublicStatusesDescriptions();

        $this->order_cycle_status = $this->order->getWEF('cycle_status');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.orders.customer-order-steps');
    }
}
