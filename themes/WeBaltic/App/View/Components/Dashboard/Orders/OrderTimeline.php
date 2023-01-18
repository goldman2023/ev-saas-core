<?php

namespace WeThemes\WeBaltic\App\View\Components\Dashboard\Orders;

use Illuminate\View\Component;
use WeThemes\WeBaltic\App\Enums\OrderCycleStatusEnum;

class OrderTimeline extends Component
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
        $this->steps = OrderCycleStatusEnum::labels();
        $this->order = $order;
        $this->order_cycle_status = $this->order->getWEF('cycle_status');

        //
        // $this->steps[] = [
        //     "title" => translate('Contract'),
        //     "description" => translate('Pending signature'),
        //     "description_completed" => translate('Signed'),
        // ];

        // $this->steps[] = [
        //     "title" => translate('Manufacturing order approval'),
        //     "description" => translate('Pending approval'),
        //     "action_label" => translate('Approve'),
        //     "action" => 'generate_invoice',
        //     "description_completed" => translate('Signed'),
        // ];

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.orders.order-timeline');
    }
}
