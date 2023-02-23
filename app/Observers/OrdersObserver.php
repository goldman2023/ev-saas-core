<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Ownership;
use App\Mail\OrderReceivedEmail;
use Illuminate\Support\Facades\Mail;
use Log;

class OrdersObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        if (function_exists('orderCreatedObserved')) {
            return orderCreatedObserved($order);
        }

        // If order which is created is not temp, then send a transacional email
        if(!$order->is_temp) {
            try {
                // Send order in email to user
                Mail::to($order->user->email)
                    ->send(new OrderReceivedEmail($order));
    
                $meta = $order->meta;
                $meta['email_sent'] = true;
                $order->meta = $meta;
                $order->save();
            } catch(\Exception $e) {
                Log::error($e->getMessage());
            }
        }

        /**
         * Product Ownership logic (status must be complete and payment_status must be paid)
         * 1. $order->type === 'standard'
         * 2. $order->payment_status === 'paid'
         **/
        if($order->payment_status === 'paid' && $order->type === 'standard') {
            foreach($order->order_items as $item) {
                Ownership::updateOrCreate(
                    [
                        'subject_id' => $item->subject->id,
                        'subject_type' => $item->subject::class,
                        'owner_id' => $order->user->id,
                        'owner_type' => $order->user::class
                    ],
                    [
                        'updated_at' => date('Y-m-d H:i:s', time())
                    ]
                );
            }
        }
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        if (function_exists('orderUpdatedObserved')) {
            return orderUpdatedObserved($order);
        }

        // If order is not temp AND email is not yet sent, send it
        // if(!$order->is_temp && !($order->meta['email_sent']??null)) {
        //     try {
        //         // Send order in email to user
        //         Mail::to($order->user->email)
        //             ->send(new OrderReceivedEmail($order));
    
        //         $meta = $order->meta;
        //         $meta['email_sent'] = true;
        //         $order->meta = $meta;
        //         $order->save();
        //     } catch(\Exception $e) {
        //         Log::error($e->getMessage());
        //     }
        // }

        if($order->payment_status === 'paid' && $order->type === 'standard') {
            foreach($order->order_items as $item) {
                Ownership::updateOrCreate(
                    [
                        'subject_id' => $item->subject->id,
                        'subject_type' => $item->subject::class,
                        'owner_id' => $order->user->id,
                        'owner_type' => $order->user::class,
                        'order_id' => $order->id,
                    ],
                    [
                        'updated_at' => date('Y-m-d H:i:s', time())
                    ]
                );
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
