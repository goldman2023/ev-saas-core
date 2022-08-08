<?php

namespace App\Observers;

use App\Models\UserSubscription;
use Illuminate\Support\Facades\Mail;
use Log;
use MailerService;
use StripeService;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notifiable;
use App\Notifications\UserSubscription\ExtendedSubscription;
use App\Notifications\UserSubscription\SubscriptionStatusChanged;
use App\Notifications\UserSubscription\TrialStarted;
use App\Notifications\UserSubscription\NonTrialSubscriptionStarted;


use App\Notifications\Admin\GeneralTransactionalNotification;

class UserSubscriptionsObserver
{
    /**
     * Handle the UserSubscription "created" event.
     *
     * @param  \App\Models\UserSubscription  $user_subscription
     * @return void
     */
    public function created(UserSubscription $user_subscription)
    {
        if ($user_subscription->status === 'trial' && $user_subscription->end_date->timestamp > time()) {
            // Trial has started, send notification
            try {
                $user_subscription->user->notify(new TrialStarted($user_subscription));
                $user_subscription->setData('trial_started_email_sent', true);
                $user_subscription->saveQuietly();
            } catch(\Exception $e) {
                Log::error($e);
            }
        }

        try {
            do_action('observer.user_subscription.created', $user_subscription);
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            die(print_r($e));
        }
    }

    /**
     * Handle the UserSubscription "updated" event.
     *
     * @param  \App\Models\UserSubscription  $user_subscription
     * @return void
     */
    public function updated(UserSubscription $user_subscription)
    {
        // TODO: Where in the code should we send UpdatedSubscription notification?

    }

    /**
     * Handle the UserSubscription "updating" event.
     *
     * @param  \App\Models\UserSubscription  $user_subscription
     * @return void
     */
    public function updating(UserSubscription $user_subscription)
    {
        // TODO: Where in the code should we send UpdatedSubscription notification?
        $user = $user_subscription->user;
        
        /**
         * There are few possible scenarios happening when subscription is updating:
         * 1. Status changes (trial -> active, active -> inactive, active -> active_until_end)
         * 2. new end_date > old end_date - subscription is extended (cycled)
         * 3. ???
         */
        $uncasted_old_end_date = $user_subscription->getRawOriginal('end_date');
        $casted_old_end_date = $user_subscription->getOriginal('end_date');
        $new_end_date = $user_subscription->end_date;

        if ($user_subscription->isDirty('end_date') && empty($uncasted_old_end_date) && $user_subscription->status !== 'trial') {
            // This means that non-trial user_subscription is just created!
            try {
                $user->notify(new NonTrialSubscriptionStarted($user_subscription));
            } catch(\Exception $e) {
                Log::error($e);
            }
        } else if($user_subscription->status === 'trial' && $user_subscription->end_date->timestamp > time() && !$user_subscription->getData('trial_started_email_sent')) {
            // Trial has started, send notification
            try {
                $user_subscription->user->notify(new TrialStarted($user_subscription));
                $user_subscription->setData('trial_started_email_sent', true);
                $user_subscription->saveQuietly();
            } catch(\Exception $e) {
                Log::error($e);
            }
        } else if ($user_subscription->isDirty('end_date') && !empty($uncasted_old_end_date) && $new_end_date > $casted_old_end_date) {
            // This means that new end_date is about to be updated - should we send notification that subscription has been successfully extended?
            try {
                $user->notify(new ExtendedSubscription($user_subscription));
            } catch(\Exception $e) {
                Log::error($e);
            }
        } else if($user_subscription->isDirty('status') && $user_subscription->getRawOriginal('status') !== $user_subscription->status) {
            // Send notification on subscription status update!
            try {
                $user->notify(new SubscriptionStatusChanged($user_subscription)); 
            } catch(\Exception $e) {
                Log::error($e);
            }          
        }
    }

    /**
     * Handle the UserSubscription "deleted" event.
     *
     * @param  \App\Models\UserSubscription  $user_subscription
     * @return void
     */
    public function deleted(UserSubscription $user_subscription)
    {
        //
    }

    /**
     * Handle the UserSubscription "restored" event.
     *
     * @param  \App\Models\UserSubscription  $user_subscription
     * @return void
     */
    public function restored(UserSubscription $user_subscription)
    {
        //
    }

    /**
     * Handle the UserSubscription "force deleted" event.
     *
     * @param  \App\Models\UserSubscription  $user_subscription
     * @return void
     */
    public function forceDeleted(UserSubscription $user_subscription)
    {
        // TODO: Where in the code should we send CanceledSubscription notification?

    }
}
