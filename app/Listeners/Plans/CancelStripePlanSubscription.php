<?php

namespace App\Listeners\Plans;

use App\Events\Plans\PlanSubscriptionCanceled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CancelStripePlanSubscription
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  PlanSubscriptionCanceled  $event
     * @return void
     */
    public function handle(PlanSubscriptionCanceled $event)
    {
        // Do it if stripe is enabled
        if(\Payments::stripe()->enabled) {
            
        }
    }

    /**
     * Handle a job failure.
     *
     * @param  PlanSubscriptionCanceled $event
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(PlanSubscriptionCanceled $event, $exception)
    {
        //
    }
}
