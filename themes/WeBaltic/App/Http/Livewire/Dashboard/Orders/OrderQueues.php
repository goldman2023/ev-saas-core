<?php

namespace WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Orders;

use Log;
use App\Models\Task;
use App\Models\Order;
use Livewire\Component;
use App\Enums\TaskStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Traits\Livewire\DispatchSupport;
use WeThemes\WeBaltic\App\Enums\TaskTypesEnum;

class OrderQueues extends Component
{
    use DispatchSupport;

    public $order;
    public $class;
    public $deliveryTask;
    public $deliveryPDF;

    public function mount($order = null, $class = '')
    {
        $this->order = $order;
        $this->class = $class;
        $this->deliveryTask = $order->tasks->firstWhere('type', 'delivery');
        $this->deliveryPDF = $this->order->getUploadsWhere('documents', wef_params: [
            ['upload_tag', 'delivery_to_warehouse']
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard.orders.order-queues');
    }

    public function addToPrintingQueue() {
        // Create new Task
        DB::beginTransaction();

        try {
            $new_task = new Task();

            $new_task->user_id = auth()->user()->id;
            $new_task->assignee_id = auth()->user()->id;
            $new_task->type = TaskTypesEnum::printing()->value;
            $new_task->status = TaskStatusEnum::backlog()->value;
            $new_task->name = translate('🖨️ Printing orders labels/certificates for Order #').$this->order->id;
            $new_task->save();

            $new_task->orders()->sync([$this->order->id]);

            DB::commit();

            $this->order->load('tasks');

            $this->inform(translate('Printing task successfully created!'), '', 'success');
        } catch(\Exception $e) {
            DB::rollBack();
            
            Log::error($e);
            $this->dispatchGeneralError(translate('There was an error while creating a printing task...Please try again.'));
            $this->inform(translate('There was an error while creating a printing task...Please try again.'), '', 'fail');
        }
    }

    public function addToDeliveryQueue() {
        // Create new Task
        DB::beginTransaction();

        try {
            $new_task = new Task();

            $new_task->user_id = auth()->user()->id;
            $new_task->assignee_id = auth()->user()->id;
            $new_task->type = TaskTypesEnum::delivery()->value;
            $new_task->status = TaskStatusEnum::backlog()->value;
            $new_task->name = translate('📦 Generating delivery to warehouse document for Order #').$this->order->id;
            $new_task->save();

            $new_task->orders()->sync([$this->order->id]);

            DB::commit();

            $this->order->load('tasks');
            $this->deliveryTask = $new_task;

            $this->inform(translate('Delivery to warehouse document generation task successfully created!'), '', 'success');
        } catch(\Exception $e) {
            DB::rollBack();
            
            Log::error($e);
            $this->dispatchGeneralError(translate('There was an error while creating a delivery to warehouse document generation task...Please try again.'));
            $this->inform(translate('There was an error while creating a delivery to warehouse document generation task...Please try again.'), '', 'fail');
        }
    }
}
