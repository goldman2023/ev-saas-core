<?php

use App\Models\Order;
use App\Facades\MailerService;
use Illuminate\Support\Facades\Log;
use WeThemes\WeBaltic\App\Enums\OrderCycleStatusEnum;
use App\Notifications\Orders\RequestQuoteOrderCreatedNotification;
use WeThemes\WeBaltic\App\Notifications\Orders\OrderContractNotification;
use WeThemes\WeBaltic\App\Notifications\Orders\OrderSignedContractNotification;
use WeThemes\WeBaltic\App\Notifications\Orders\OrderCycleStatusChangedNotification;

if (!function_exists('orderCreatedObserved')) {
    function orderCreatedObserved(Order $order) {
        if(!$order->is_temp && !empty($order->user)) {

            $order_cycle_status = $order->getWEF('cycle_status');

            // Check the cycle_status step of the order and send different emails based on that
            if($order_cycle_status === 0) {
                
                // Cycle status is 'Request'
                try {
                    MailerService::notify($order->user, new RequestQuoteOrderCreatedNotification($order, throw_error: true));

                    // Set $order core_meta `request_a_quote_email_sent_timestamp` to current time
                    $order->setWEF('request_quote_email_sent_timestamp', time(), 'unix_timestamp');
                } catch(\Exception $e) {
                    Log::error($e->getMessage());
                }

            } else if($order_cycle_status === 2) {
                // Cycle status is 'Approved'

                // If order_signed_contract_email is not sent
                if($order->getWEF('order_signed_contract_email_sent_timestamp', 'unix_timestamp') === null) {
                    try {
                        // Send signed contract for order email
                        MailerService::notify($order->user, new OrderSignedContractNotification($order, throw_error: true));
    
                        // Set $order core_meta `order_signed_contract_email_sent_timestamp` to current time
                        $order->setWEF('order_signed_contract_email_sent_timestamp', time(), 'unix_timestamp');
                    } catch(\Exception $e) {
                        Log::error($e->getMessage());
                    }
                }
            }

            return true;
        }
    }
}

if (!function_exists('orderUpdatedObserved')) {
    function orderUpdatedObserved(Order $order) {
        if(!$order->is_temp && !empty($order->user)) {

            $order_cycle_status = $order->getWEF('cycle_status');
            $current_timestamp = time();

            if($order_cycle_status === 1) {
                // Cycle status: `contract` (waiting to be signed by customer)

                if($order->getWEF('order_contract_email_sent_timestamp', 'unix_timestamp') === null) {
                    try {
                        // Send signed contract for order email
                        MailerService::notify($order->user, new OrderContractNotification($order, throw_error: true));
    
                        // Set $order core_meta `order_contract_email_sent_timestamp` to current time
                        $order->setWEF('order_contract_email_sent_timestamp', $current_timestamp, 'unix_timestamp');
                    } catch(\Exception $e) {
                        Log::error($e->getMessage());
                    }
                }
            } else if($order_cycle_status === 2) {
                // Cycle status: `approved` (contract signed by the customer)
                // Send the signed contract notification to the user!

                if($order->getWEF('order_signed_contract_email_sent_timestamp', 'unix_timestamp') === null) {
                    try {
                        // Send signed contract for order email
                        MailerService::notify($order->user, new OrderSignedContractNotification($order, throw_error: true));

                        // Set $order core_meta `order_signed_contract_email_sent_timestamp` to current time
                        $order->setWEF('order_signed_contract_email_sent_timestamp', $current_timestamp, 'unix_timestamp');
                    } catch(\Exception $e) {
                        Log::error($e->getMessage());
                    }
                }
            }

            // Send notification to customer about the cycle status change if not already sent AND if cycle status falls under public statuses!
            if($order_cycle_status !== 0) {
                // SKIP request a quote status!
                // NOTE: Keep in mind that $order_cycle_status is the latest order cycle status!!!
                $current_status_label = OrderCycleStatusEnum::labels()[$order_cycle_status] ?? '';
                $new_status_label = OrderCycleStatusEnum::labels()[$order_cycle_status-1] ?? '';

                $orderCycleStatusChangedNotification = new OrderCycleStatusChangedNotification(
                    order: $order,
                    old_status: ($order_cycle_status-1), 
                    new_status: $order_cycle_status, 
                    current_timestamp: $current_timestamp,
                    throw_error: true
                );
                $notification_data = $orderCycleStatusChangedNotification->toDatabase($order->user);

                // Two activity logs will be produced from the following code if cycle_status is among public and not already sent, otherwise only 1st will be added:
                // 1. order_cycle_status_changed activity log - indicates that cycle-status of the order changed
                // 2. notification_sent activity log - indicates that notification about order cycle-status has been successfully sent

                // 1. Add cycle-status change to activity log
                activity()
                    ->causedBy($order)
                    ->performedOn($order->user)
                    ->event('order_cycle_status_changed') // goes to 'event' column
                    ->withProperties($notification_data['data'] ?? [])
                    ->log($notification_data['title'] ?? ''); // goes to 'description' column

                // 2. Fire OrderCycleStatusChangedNotification
                if(array_key_exists($order_cycle_status, OrderCycleStatusEnum::getPublicStatuses()) && $order->getWEF('order_cycle_status_changed_to_'.$order_cycle_status.'_email_sent_timestamp', 'unix_timestamp') === null) {
                    try {
                        // Send signed contract for order email
                        MailerService::notify($order->user, $orderCycleStatusChangedNotification);

                        // Set $order core_meta `order_cycle_status_changed_to_X__email_sent_timestamp` to current time
                        $order->setWEF('order_cycle_status_changed_to_'.$order_cycle_status.'_email_sent_timestamp', time(), 'unix_timestamp');
                    } catch(\Exception $e) {
                        Log::error($e->getMessage());
                    }
                }
            }
        }
    }
}