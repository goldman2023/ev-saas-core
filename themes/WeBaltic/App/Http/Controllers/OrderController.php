<?php

namespace WeThemes\WeBaltic\App\Http\Controllers;

use DB;
use App\Models\Task;
use App\Models\Order;
use App\Models\CoreMeta;
use App\Enums\TaskStatusEnum;
use App\Http\Controllers\Controller;
use WeThemes\WeBaltic\App\Enums\TaskTypesEnum;
use WeThemes\WeBaltic\App\Enums\OrderCycleStatusEnum;

class OrderController extends Controller
{
    public function change_cycle_status($order_id, $standalone = false)
    {
        $order = Order::findOrFail($order_id);
        $current_status = $order->getWEF('cycle_status', true); // get it fresh baby :)

        $new_status = null;

        if (is_integer($current_status)) {
            $new_status = $current_status + 1; // Increment status by 1
        } else {
            $order->setWEF('cycle_status', 0); // set first to 0, then change later
            $current_status = $order->getWEF('cycle_status', true);
            $new_status = 1; // Default is 'contract'!
        }

        if(!isset(OrderCycleStatusEnum::values()[$new_status])) {
            // If $new_status does not exist in enum, thwo an error
            if($standalone) {
                return false;
            }

            session()->flash('message', translate('Order cycle status was not updated. New status does not exist in Enum'));
            return redirect()->back();
        }

        $reason = '';

        DB::beginTransaction();



        try {
            if ($new_status == 1) { // contract
                $reason = translate('Proposal & Contract Created');

                baltic_generate_order_document($order, 'documents-templates.contract', 'contract', translate('Contract for Order #').$order->id);
            } else if ($new_status == 2) { // approved
                $reason = translate('Contract Created');

                // Only customer can sign the contract
                // TODO: Sign the contract here

            } else if ($new_status == 3) { // welding
                $reason = translate('Approved for manufacturing');

            } else if ($new_status == 6) { // delivery_to_warehouse
                $reason = translate('Delivering to warehouse');

                // 1. Create Delivery Task
                $new_task = new Task();

                $new_task->user_id = auth()->user()->id;
                $new_task->assignee_id = auth()->user()->id;
                $new_task->type = TaskTypesEnum::delivery()->value;
                $new_task->status = TaskStatusEnum::in_progress()->value;
                $new_task->name = translate('Generating delivery to warehouse document for Order #').$order->id;
                $new_task->save();

                // 2. Attach Order to Task
                $new_task->orders()->sync([$order->id]);

                // TODO: Make a reasonable logic to make Tasks have their own actions (to init action by $task->runAction({action_name})), and make hooks so we can inject theme specific actions to any Task
                // 3. Generate delivery document
                baltic_generate_order_document($order, 'documents-templates.delivery-to-warehouse', 'delivery_to_warehouse', translate('Delivery to warehouse document for Order #').$order->id);

                // 4. Change Task status to done
                $new_task->status = TaskStatusEnum::done()->value;
                $new_task->save();
            }

            baltic_generate_order_document($order, 'documents-templates.manufacturing-sheet', 'manufacturing-details', translate('Manufacturing card for Order #').$order->id);
            baltic_generate_order_document($order, 'documents-templates.authenticity-certificate', 'authenticity-certificate', translate('Tapatumo pažyma for Order #').$order->id);
            baltic_generate_order_document($order, 'documents-templates.warrant', 'warrant', translate('Įgaliojimas for Order #').$order->id);
            baltic_generate_order_document($order, 'documents-templates.certificate', 'certificate', translate('Certificate for Order #').$order->id);

            // Change order cycle status
            $order->setWEF('cycle_status', $new_status);

            // Save meta about when change happened
            $order->setWEF('cycle_step_date_'.OrderCycleStatusEnum::values()[$new_status], time(), 'int');

            $current_status_label = OrderCycleStatusEnum::labels()[$current_status];
            $new_status_label = OrderCycleStatusEnum::labels()[$new_status];

            event('eloquent.updated: '.$order::class, $order); // send model `updated` event manually

            DB::commit();

            if($standalone) {
                return $order;
            }
        } catch(\Exception $e) {
            DB::rollback();

            if($standalone) {
                return false;
            }
        }


        session()->flash('message', translate('Order cycle status updated'));
        return redirect()->back();
    }
}
