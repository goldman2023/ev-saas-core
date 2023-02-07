<?php

use App\Models\Order;
use App\Facades\MailerService;
use Illuminate\Support\Facades\Log;
use App\Notifications\Orders\RequestQuoteOrderCreatedNotification;
use WeThemes\WeBaltic\App\Notifications\Orders\OrderContractNotification;

if (!function_exists('orderCreatedObserved')) {
    function orderCreatedObserved(Order $order) {
        if(!$order->is_temp && !empty($order->user)) {

            // Check the cycle_status step of the order and send different emails based on that
            if($order->getWEF('cycle_status') === 0) {
                
                // Cycle status is 'Request'
                try {
                    MailerService::notify($order->user, new RequestQuoteOrderCreatedNotification($order, throw_error: true));

                    // Set $order core_meta `request_a_quote_email_sent_timestamp` to current time
                    $order->setWEF('request_quote_email_sent_timestamp', time(), 'unix_timestamp');
                } catch(\Exception $e) {
                    Log::error($e->getMessage());
                }

            } else if($order->getWEF('cycle_status') === 2) {
                // Cycle status is 'Approved'

                // If request_quote is not sent
                if($order->getWEF('order_signed_contract_email_sent_timestamp', 'unix_timestamp') === null) {
                    try {
                        // Send signed contract for order email
                        MailerService::notify($order->user, new OrderContractNotification($order, throw_error: true));
    
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