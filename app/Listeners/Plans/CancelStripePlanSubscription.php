<?php

namespace App\Listeners\Plans;

use App\Events\Plans\PlanSubscriptionCancel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Enums\UserSubscriptionStatusEnum;
use App\Enums\PaymentStatusEnum;
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
     * @param  PlanSubscriptionCancel  $event
     * @return void
     */
    public function handle(PlanSubscriptionCancel $event)
    {
        // Do it if stripe is enabled
        if(Payments::stripe()->enabled) {
            // Cancel subscription in stripe

            if(!get_tenant_setting('multiplan_purchase')) {
                if(!empty($stripe_subscription_id = $event->plan_subscription->data['stripe_subscription_id'])
                    && $event->plan_subscription->status === UserSubscriptionStatusEnum::active()->value
                    && $event->plan_subscription->payment_status === PaymentStatusEnum::paid()->value) {

                    // DO NOT CANCEL SUBSCRIPTION IMMEDIATELY BUT UPDATE IT!!!!
                    // Set the `cancel_at_period_end` to true - Reason is that you can revive it if it's not canceled before!

                    $stripe_subscription = StripeService::stripe()->subscriptions->update(
                        $stripe_subscription_id,
                        [
                            'cancel_at_period_end' => true, // Cancel subscription when end_date is reached!!!
                            'metadata' => [
                                'user_subscription_id' => $event->plan_subscription->id,
                                'stop_hook' => 1 // IMPORTANT: this action will trigger `customer.subscription.updated` hook, but we don't need any action to happen, so we need this meta data to prevent any action on our end when hook is fired
                            ]
                        ]   
                    );
                    
                    if($stripe_subscription->cancel_at_period_end) {
                        // This means that subscription is set to be canceld when end_date is reached (stripe will send a subscription.deleted request and we'll delete subscription only then!)
                        
                        // If current timestamp passed the end_date, status is `inactive`, otherwise status is `active_until_end` - we'll let user use the plan untill end_date is reched (cuz user paid for it already!)
                        $event->plan_subscription->status = $event->plan_subscription->end_date > time() ? UserSubscriptionStatusEnum::active_until_end()->value : UserSubscriptionStatusEnum::inactive()->value;
                        $event->plan_subscription->save();
                    } else {
                        throw new \Exception('Stripe subscription status could not be set to be canceld on period end. Please try again after refresh.');
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
     * @param  PlanSubscriptionCancel $event
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(PlanSubscriptionCancel $event, $exception)
    {
        //
    }
}
