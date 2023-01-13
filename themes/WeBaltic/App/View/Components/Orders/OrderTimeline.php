<?php

namespace WeThemes\WeBaltic\App\View\Components\Orders;

use Illuminate\View\Component;
use WeThemes\WeBaltic\App\Enums\OrderCycleStatusEnum;

class OrderTimeline extends Component
{
    public $statuses = [];
    public $order;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;

        //
        $this->statuses[] = [
            "title" => translate('Contract'),
            "description" => translate('Pending signature'),
            "description_completed" => translate('Signed'),
        ];

        $this->statuses[] = [
            "title" => translate('Manufacturing order approval'),
            "description" => translate('Pending approval'),
            "action_label" => translate('Approve'),
            "action" => 'generate_invoice',
            "description_completed" => translate('Signed'),
        ];

        $this->statuses = OrderCycleStatusEnum::labels();
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
