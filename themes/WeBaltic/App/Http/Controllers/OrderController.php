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
            $new_status = 1; // Default is 'contract'!
        }

        $reason = '';

        DB::beginTransaction();

        try {
            if ($new_status == 1) { // contract
                $reason = translate('Contract Created');
    
                baltic_generate_order_document($order, 'documents-templates.contract', 'contract', translate('Contract for Order #').$order->id);
            } else if ($new_status == 2) { // approved
                $reason = translate('Contract Signed');
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

            // Change order cycle status
            $order->setWEF('cycle_status', $new_status);

            // Save meta about when change happened
            $order->setWEF('cycle_step_date_'.OrderCycleStatusEnum::values()[$new_status], time(), 'int');

            $current_status_label = OrderCycleStatusEnum::labels()[$current_status];
            $new_status_label = OrderCycleStatusEnum::labels()[$new_status];

            activity()
                ->performedOn($order)
                ->causedBy(auth()->user())
                ->event('changed_order_cycle_status')
                ->withProperties([
                    'action' => 'changed_order_cycle_status',
                    'action_title' => 'Updated cycle status of order(#'.$order->id.') to: ' . $new_status_label.' ('.$reason.')',
                ])
                ->log( 'Changed Order(#'.$order->id.') cycle status from <b>'.$current_status_label.'</b> to <b>'.$new_status_label.'</b>. '. $reason);

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