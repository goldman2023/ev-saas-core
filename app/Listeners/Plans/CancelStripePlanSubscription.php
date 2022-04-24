<?php

namespace App\Listeners\Plans;

use App\Events\Plans\PlanSubscriptionCanceled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Enums\UserSubscriptionStatusEnum;
use Payments;
use StripeService;

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
        if(Payments::stripe()->enabled) {
            // Cancel subscription in stripe

            if(!get_tenant_setting('multiplan_purchase')) {
                if(!empty($stripe_subscription_id = $event->plan_subscription->data['stripe_subscription_id'])) {
                    $stripe_subscription = StripeService::stripe()->subscriptions->cancel(
                        $stripe_subscription_id,
                        [
                            'invoice_now' => false, // Do not create any new invoices for prorate usage difference
                            'prorate' => false, // Do not prorate because users will be ale to use plan until billing period end (they've already paid for it...)
                        ]
                    );
                    
                    if($stripe_subscription->status === 'canceled') {
                        // This means that subscription is properly canceled on Stripe's end, so we should inactivate it on our end too!
                        
                        // Id current timestamp is passed end_date, status is inactive, otherwise status is active_until_end - we'll let user use the plan untill end_date is reched (cuz user paid for it already!)
                        $event->plan_subscription->status = $event->plan_subscription->end_date > time() ? UserSubscriptionStatusEnum::active_until_end()->value : UserSubscriptionStatusEnum::inactive()->value;
                        $event->plan_subscription->save();
                    } else {
                        throw new \Exception('Stripe subscription status could not be changed to "canceld". Please try again after refresh.');
                    }
                }
            } else {
                // Logic is different when multiplan purchase is enabled! We need to check if subscription has only one plan or more AND
                // if it's one, then cancel it same way as above,
                // but if stripe subscription has multiple plans(stripe's products), then it should update the subscription, not cancel it!
            }
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
