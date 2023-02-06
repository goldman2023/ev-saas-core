<?php

namespace App\Observers;

use Log;
use Session;
use Payments;
use MailerService;
use StripeService;
use Uuid;
use App\Models\User;
use App\Mail\WelcomeEmail;
use App\Mail\EmailVerification;
use App\Mail\UserReceivedEmail;
use App\Enums\WeMailingListsEnum;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserWelcomeNotification;
use App\Notifications\UserFinalizeRegistration;
use App\Notifications\UserEmailVerificationNotification;
use App\Notifications\Admin\GeneralTransactionalNotification;

class UsersObserver
{
    public $afterCommit = true;

    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        try {
            // Adding User to MailerLite 'All Users' group
            $subscriber = MailerService::mailerlite()->addSubscriberToGroup(WeMailingListsEnum::all_users()->label, $user);

            // Set the core_meta 'mailerlite_subscriber_id' flag to 1!
            if(!empty($subscriber)) {
                $user->core_meta()->updateOrCreate(
                    ['key' => 'mailerlite_subscriber_id'],
                    ['value' => $subscriber->id]
                );
            }
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }

        if(!$user->is_temp && get_tenant_setting('force_email_verification')) {
            try {
                $user->sendEmailVerificationNotification();
            } catch(\Exception $e) {
                Log::error($e->getMessage());
            }
        } else if($user->is_temp) {
            // If user is ghost user, send a notification to finalize User registration and add a sessionID of guest user to this ghost user!
            $user->session_id = Session::getId();
            $user->save();

            try {
                MailerService::notify($user, new UserFinalizeRegistration());
            } catch(\Exception $e) {
                Log::error($e->getMessage());
            }
        }

        /* TODO: Send user welcome notification only if user is not Ghost/Guest */
        if(!$user->is_temp) {
            try {
                MailerService::notify($user, new UserWelcomeNotification());
            } catch(\Exception $e) {
                Log::error($e->getMessage());
            }
        }

        // Create Stripe Customer if stripe is enabled
        if(Payments::isStripeEnabled()) {
            StripeService::createStripeCustomer($user);
        }

        // Notify Admin about user registration
        @send_admin_notification(translate('New user Registered on').' '.get_tenant_setting('site_name'), translate('New user with following email registered:').' '.$user->email);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        if(Payments::isStripeEnabled()) {
            StripeService::updateStripeCustomerInfo(user: $user);
            StripeService::updateStripeCustomerTax(user: $user, update_tax_exempt_for_individual: true);
        }
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
