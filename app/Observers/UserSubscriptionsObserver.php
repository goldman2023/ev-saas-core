<?php

namespace App\Observers;

use App\Models\UserSubscription;
use Illuminate\Support\Facades\Mail;
use Log;
use MailerService;
use StripeService;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notifiable;
use App\Notifications\UserWelcomeNotification;
use App\Notifications\UserFinalizeRegistration;
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

        try {
            do_action('observer.user_subscription.created', $user_subscription);
        } catch(\Exception $e) {
            die(print_r($e));
            Log::error($e->getMessage());
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
        //
    }
}
