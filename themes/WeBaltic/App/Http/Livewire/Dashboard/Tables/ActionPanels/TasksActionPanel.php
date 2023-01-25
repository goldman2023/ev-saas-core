<?php

namespace WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tables\ActionPanels;

use UUID;
use PDF;
use MediaService;
use Log;
use App\Models\Task;
use App\Models\Order;
use Livewire\Component;
use App\Enums\TaskStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Traits\Livewire\DispatchSupport;
use WeThemes\WeBaltic\App\Enums\TaskTypesEnum;
use App\View\Components\Dashboard\Orders\OrderDetailsCard;

class TasksActionPanel extends Component
{
    use DispatchSupport;

    public $tableId;
    public $items = [];
    public $action;
    public $availableActions;
    public $tasksType;

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
            'items.required' => translate('At least one task must be selected.'),
            'action.required' => translate('Action not selected. Please select one.'),
        ];
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($tableId = null, $tasksType = 'printing')
    {
        $this->tableId = $tableId;
        $this->tasksType = $tasksType;

        $this->setAvailableActions();
    }

    public function setAvailableActions() {
        if($this->tasksType === 'printing') {
            $this->availableActions = [
                'print_labels' => translate('Print labels'),
            ];
        } else if($this->tasksType === 'delivery') {
            $this->availableActions = [
                'generate_delivery_documents' => translate('Generate delivery documents')
            ];
        }        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('livewire.dashboard.tables.action-panels.tasks-action-panel');
    }

    public function runAction() {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

        if($this->action === 'print_labels') {
            $this->printLabels();
        } else if($this->action === 'generate_delivery_documents') {
            $this->generateDeliveryDocuments();
        }

        $this->emit('refreshDatatable');
        $this->resetActions();
    }

    public function resetActions() {
        $this->action = null;
        $this->items = [];

    }

    /**
     * printLabels
     *
     * This function does the following:
     * 1) Gets all the selected tasks and combines all orders attached to the task
     * 2) Created the PDF filled with orders generated certificates/labels
     * 3) Saves the generated PDF containing all orders certificates/labels to Uploads and attaches it to each Task and Order
     * 4) Stores the `batch_id` and `batch_items` WEF to Upload
     * 5) Changes the task status to `done`
     *
     * @return void
     */
    public function printLabels() {
        $tasks = Task::whereIn('id', $this->items)->get();

        if(!empty($tasks)) {
            DB::beginTransaction();

            try {
                $orders = collect();

                foreach($tasks as $task) {
                    $orders = $orders->merge($task->orders);
                }

                // Filter $orders collection to include only unique Orders
                $orders = $orders->unique(function ($item) {
                    return $item->id;
                });

                if(!empty($orders)) {
                    // batch ID and items array will be stored as WEFs to attached Upload
                    $batch_id = UUID::generate(4)->string; // TODO: Generate batch IDs by incrementing count of all previous $uploads whose upload_tag WEF is printing-label
                    $batch_items = $tasks->map(function($task) {
                        return [
                            'subject_id' => $task->id,
                            'subject_type' => $task::class,
                        ];
                    })->toArray();

                    // Generate PDF with combined order certificates/labels
                    $template = 'documents-templates.printing-template';
                    $data = [
                        'orders' => $orders,
                    ];

                    $pdf = PDF::loadView($template, $data)->setPaper('a4', 'portrait')->output();

                    // Get all models to which we want to attach generated and uploaded PDF (includes both tasks and orders)
                    $all_models = collect($tasks)->merge($orders);

                    $upload = MediaService::uploadAndStore(
                        model: $all_models,
                        contents: $pdf,
                        path: 'orders/prints/labels',
                        name: 'printing-label-batch-'.$batch_id,
                        extension: 'pdf',
                        property_name: 'documents',
                        with_hash: false,
                        file_display_name: translate('Printing labels batch ').$batch_id,
                        upload_tag: 'printing-label',
                        user_id: auth()->user()->id,
                        shop_id: auth()->user()->shop->first()->id
                    );

                    if(empty($upload)) {
                        throw new Exception(translate('Could not upload PDF and attach it to tasks/orders...'));
                    }

                    // Set batch info WEFs
                    $upload->setWEF('batch_id', $batch_id);
                    $upload->setWEF('batch_items', json_encode($batch_items));

                    // Set tasks status to `done`
                    foreach($tasks as $task) {
                        $task->status = TaskStatusEnum::done()->value;
                        $task->save();
                    }
                }

                DB::commit();

                $this->inform(translate('Orders printing labels PDF successfully created!'), '', 'success');
            } catch(\Exception $e) {
                DB::rollBack();

                Log::error($e);
                $this->dispatchGeneralError(translate('There was an error while performing printing-label action...Please try again.'));
                $this->inform(translate('There was an error while performing printing-label action...Please try again.'), '', 'fail');
            }
        }
    }

    public function generateDeliveryDocuments() {
        $tasks = Task::whereIn('id', $this->items)->get();

        if(!empty($tasks)) {
            DB::beginTransaction();

            try {
                foreach($tasks as $task) {
                    if($task->orders->isNotEmpty()) {
                        foreach($task->orders as $order) {
                            baltic_generate_order_document(
                                order: $order, 
                                template: 'documents-templates.delivery-to-warehouse', 
                                upload_tag: 'delivery_to_warehouse', 
                                display_name: translate('Delivery to warehouse document for Order #').$order->id
                            );
                        }

                        $task->status = TaskStatusEnum::done()->value;
                        $task->save();
                    }
                }

                DB::commit();

                $this->inform(translate('Delivery to warehouse documents successfully created!'), '', 'success');
            } catch(\Exception $e) {
                DB::rollBack();

                Log::error($e);
                $this->dispatchGeneralError(translate('There was an error while performing delivery documents generation...Please try again.'));
                $this->inform(translate('There was an error while  performing delivery documents generation...Please try again.'), '', 'fail');
            }
        }
    }
}
