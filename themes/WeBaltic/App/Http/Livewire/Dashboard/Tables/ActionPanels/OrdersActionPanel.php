<?php

namespace WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tables\ActionPanels;

use App\Models\Task;
use App\Models\Order;
use Livewire\Component;
use App\Enums\TaskStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Traits\Livewire\DispatchSupport;
use WeThemes\WeBaltic\App\Enums\TaskTypesEnum;

class OrdersActionPanel extends Component
{
    use DispatchSupport;

    public $tableId;
    public $items = [];
    public $action;
    public $availableActions;

    protected function rules()
    {
        $rules = [
            'items' => ['required'],
            'action' => ['required']
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'items.required' => translate('At least one order must be selected'),
            'action' => translate('Action not selected'),
        ];
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($tableId = null)
    {
        $this->tableId = $tableId;

        $this->setAvailableActions();
    }

    public function setAvailableActions() {
        $this->availableActions = [
            'generate_printing_task' => translate('Generate printing label - Certificate'),
            'generate_delivery_task' => translate('Generate Delivery List'),
            'export_to_pdf' => translate('Export to PDF'),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('livewire.dashboard.tables.action-panels.orders-action-panel');
    }

    public function runAction() {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

        // IMPORTANT: Move printing and delivery actions to WeBaltic!
        if($this->action === 'generate_printing_task') {
            $this->generatePrintingTask();
        } else if($this->action === 'generate_delivery_task') {
            $this->generateDeliveryTask();
        } else if($this->action === 'export_to_pdf') {
            $this->exportToPdf();
        }

        $this->emit('refreshDatatable');
        $this->resetActions();
    }

    public function resetActions() {
        $this->action = null;
        $this->items = [];

    }

    public function generatePrintingTask() {
        // Create new Task
        DB::beginTransaction();

        try {
            $new_task = new Task();

            $new_task->user_id = auth()->user()->id;
            $new_task->assignee_id = auth()->user()->id;
            $new_task->type = TaskTypesEnum::printing()->value;
            $new_task->status = TaskStatusEnum::backlog()->value;
            $new_task->name = translate('Printing orders labels/certificates');
            // $new_task->excerpt = translate('Printing order labels (certificates)');
            $new_task->save();

            $orders = Order::whereIn('id', $this->items)->get();

            $new_task->orders()->syncWithoutDetaching($orders);

            DB::commit();

            $this->inform(translate('Printing task successfully created!'), '', 'success');


        } catch(\Exception $e) {
            DB::rollBack();
            $this->dispatchGeneralError(translate('There was an error while creating a printing task...Please try again.'));
            $this->inform(translate('There was an error while creating a printing task...Please try again.'), '', 'fail');
            dd($e);
        }

    }

    public function generateDeliveryTask() {
        // Create new Task
        DB::beginTransaction();

        try {
            $new_task = new Task();

            $new_task->user_id = auth()->user()->id;
            $new_task->assignee_id = auth()->user()->id;
            $new_task->type = TaskTypesEnum::delivery()->value;
            $new_task->status = TaskStatusEnum::in_progress()->value;
            $new_task->name = translate('Delivery task');
            // $new_task->excerpt = translate('Printing order labels (certificates)');
            $new_task->save();

            $orders = Order::whereIn('id', $this->items)->get();

            $new_task->orders()->syncWithoutDetaching($orders);

            DB::commit();

            $this->inform(translate('Delivery task successfully created!'), '', 'success');


        } catch(\Exception $e) {
            DB::rollBack();
            $this->dispatchGeneralError(translate('There was an error while creating a printing task...Please try again.'));
            $this->inform(translate('There was an error while creating a printing task...Please try again.'), '', 'fail');
            dd($e);
        }
    }

    public function exportToPdf() {

    }
}
