<?php

use App\Models\Order;
use App\Facades\MailerService;
use Illuminate\Support\Facades\Log;
use App\Notifications\Orders\RequestQuoteOrderCreatedNotification;
use WeThemes\WeBaltic\App\Notifications\Orders\OrderContractNotification;
use WeThemes\WeBaltic\App\Notifications\Orders\OrderSignedContractNotification;

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

            if($order->getWEF('cycle_status') === 1) {
                // Cycle status: `contract` (waiting to be signed by customer)

                if($order->getWEF('order_contract_email_sent_timestamp', 'unix_timestamp') === null) {
                    try {
                        // Send signed contract for order email
                        MailerService::notify($order->user, new OrderContractNotification($order, throw_error: true));
    
                        // Set $order core_meta `order_contract_email_sent_timestamp` to current time
                        $order->setWEF('order_contract_email_sent_timestamp', time(), 'unix_timestamp');
                    } catch(\Exception $e) {
                        Log::error($e->getMessage());
                    }
                }
            } else if($order->getWEF('cycle_status') === 2) {
                // Cycle status: `approved` (contract signed by the customer)
                // Send the signed contract notification to the user!

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

        }
    }
}