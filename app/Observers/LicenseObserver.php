<?php

namespace App\Observers;

use App\Models\License;
use App\Models\UserSubscriptionRelationship;
use Log;
use StripeService;

class LicenseObserver
{
    public $afterCommit = true;

    /**
     * Handle the License "created" event.
     *
     * @param  \App\Models\License  $license
     * @return void
     */
    public function created(License $license)
    {
        
    }

    /**
     * Handle the License "updated" event.
     *
     * @param  \App\Models\License  $license
     * @return void
     */
    public function updated(License $license)
    {

    }

    /**
     * Handle the License "deleted" event.
     *
     * @param  \App\Models\License  $license
     * @return void
     */
    public function deleted(License $license)
    {
        // Remove License and UserSubscription relation
        UserSubscriptionRelationship::where([
            ['subject_type', $license::class],
            ['subject_id', $license->id]
        ])->delete();
    }

    /**
     * Handle the License "restored" event.
     *
     * @param  \App\Models\License  $license
     * @return void
     */
    public function restored(License $license)
    {
        //
    }

    /**
     * Handle the License "force deleted" event.
     *
     * @param  \App\Models\License  $license
     * @return void
     */
    public function forceDeleted(License $license)
    {
        //
    }
}
