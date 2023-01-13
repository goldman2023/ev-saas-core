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
            'action.required' => translate('Action not selected'),
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
            'generate_printing_tasks' => translate('Generate printing labels - Certificates'),
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

        if($this->action === 'generate_printing_tasks') {
            $this->generatePrintingTasks();
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

    public function generatePrintingTasks() {
        $orders = Order::whereIn('id', $this->items)->get();

        if(!empty($orders)) {
            DB::beginTransaction();

            try {
                foreach($orders as $order) {
                    $new_task = new Task();

                    $new_task->user_id = auth()->user()->id;
                    $new_task->assignee_id = auth()->user()->id;
                    $new_task->type = TaskTypesEnum::printing()->value;
                    $new_task->status = TaskStatusEnum::backlog()->value;
                    $new_task->name = translate('Printing orders labels/certificates for Order #').$order->id;
                    $new_task->save();

                    // Attach Order to Task
                    $new_task->orders()->sync([$order->id]);
                }

                DB::commit();

                $this->inform(translate('Printing tasks successfully created!'), 'Keep in mind that newly created tasks are currently in backlog', 'success');

            } catch(\Exception $e) {
                DB::rollBack();
                $this->dispatchGeneralError(translate('There was an error while creating a printing task...Please try again.'));
                $this->inform(translate('There was an error while creating a printing task...Please try again.'), '', 'fail');
                dd($e);
            }
        }
    }

    public function exportToPdf() {

    }
}
