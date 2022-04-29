<?php

namespace App\Observers;

use App\Models\User;
use App\Mail\UserReceivedEmail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Log;
use MailerService;
use App\Enums\WeMailingListsEnum;
use App\Mail\EmailVerification;

class UserObserver
{
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

        try {
            Mail::to($user->email)
                ->send(new WelcomeEmail($user));
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }

        if(get_tenant_setting('force_email_verification')) {
            $data= [];

            $data['view'] = 'emails.users.email-verification'; 
            $data['subject'] = translate('Email Verification').' | '.get_tenant_setting('site_name');
            $data['preheader'] = translate('Please verify your email address');
            $data['content'] = translate('Please click the button below to verify your email address.');
            $data['link'] = route('user.email.verification.verify', ['id' => $user->id, 'hash' => sha1($user->email)]);

            try {
                Mail::to($user->email)
                    ->send(new EmailVerification($user, $data));
            } catch(\Exception $e) {
                Log::error($e->getMessage());
            }
        } 
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
       
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
