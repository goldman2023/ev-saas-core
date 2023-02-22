<?php

namespace App\Http\Livewire\Modals;

use App\Http\Controllers\OrderController;
use App\Models\Order;
use App\Traits\Livewire\DispatchSupport;
use Livewire\Component;
use WeThemes\WeBaltic\App\Enums\OrderCycleStatusEnum;

class OrderStatusChangeModal extends Component
{
    use DispatchSupport;


    public $order;

    public function mount($order) {
        $this->order = $order;
    }

    public function incrementOrderCycleStatus($order_id = null)
    {

        $controller = app()->make(OrderController::class);

        $order = $controller->change_cycle_status(order_id: $order_id, standalone: true);

        if ($order instanceof Order) {
            $new_status_label = OrderCycleStatusEnum::labels()[$order->getWEF('cycle_status', true)] ?? '?';

            $this->inform(translate('Order cycle status successfully incremented!'), translate('Order (#') . $order_id . translate(') has the cycle status: ') . $new_status_label, 'success');
            $this->emit('refreshDatatable');
            $this->dispatchBrowserEvent('close-modal');
        } else {
            $this->inform(translate('Order cycle status could not be incremented'), translate('Order (#') . $order_id . translate(') could not increment the cycle status...'), 'fail');
        }
    }

    public function render()
    {
        return view('livewire.modals.order-status-change-modal');
    }
}
