<?php

namespace App\Observers;

use App\Models\Order;
use App\Mail\OrderReceivedEmail;

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
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        // If order is not temp AND email is not yet sent, send it
        if(!$order->is_temp && !$order->meta['email_sent']) {
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
