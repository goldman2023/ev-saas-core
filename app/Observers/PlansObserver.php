<?php

namespace App\Observers;

use App\Models\Plan;
use App\Models\TenantSetting;
use Cache;
use Payments;
use StripeService;

class PlansObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the Plans "saved" event.
     *
     * @param Plan $plan
     * @return void
     */
    public function saved(Plan $plan)
    {
        // When plan is saved - invalidate the cache!
        $plan = Plan::find($plan->id); // For some reason, prices are not correct and show previous prices (if they are changed) if used plan is $plan given as parameter
        $plan->cache()->invalidate(true);

        if(Payments::isStripeEnabled()) {
            // Update Stripe plan
            StripeService::saveStripeProduct($plan);
        }
    }

    /**
     * Handle the Plans "deleting" event.
     *
     * @param Plan $plan
     * @return void
     */
    public function deleting(Plan $plan)
    {
        // TODO: Add removing stocks/uplaods-relations/attribute-relations/and other polymorphic relations!
        //TODO: IT SHOULD BE ON FORCE DELETE!!!
    }
}
