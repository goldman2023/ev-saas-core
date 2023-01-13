<?php

namespace WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tasks;

use App\Models\Task;
use App\Models\Order;
use App\Models\Upload;
use Livewire\Component;
use App\Traits\Livewire\DispatchSupport;

class LatestDeliveryTask extends Component
{
    use DispatchSupport;

    public $upload = null;
    public $order = null;
    public $deliveryTask = null;

    protected $listeners = [
        'refreshDatatable' => '$refresh',
        'refreshLatestDeliveryTask' => '$refresh'
    ];

    public function mount()
    {
        $this->upload = Upload::whereWEF('upload_tag', 'delivery_to_warehouse')
            ->orderBy('created_at', 'DESC')
            ->first();

        $this->order = $this->upload->load('related.subject')->related->where(function($item) {
            return $item->subject instanceof Order;
        })->first()?->subject ?? null;
        $this->deliveryTask = $this->order->tasks->firstWhere('type', 'delivery');
    }

    public function render()
    {
        return view('livewire.dashboard.tasks.latest-delivery-task');
    }
}
