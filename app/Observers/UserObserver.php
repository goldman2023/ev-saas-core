<?php

namespace App\Observers;

use App\Models\User;
use App\Mail\UserReceivedEmail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Log;
use MailerService;
use App\Enums\WeMailingListsEnum;

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
            $subscriber = MailerService::mailerlite()->addSubscriberToGroup(WeMailingListsEnum::all_users()->label, $this->user);

            // Set the core_meta 'in_mailerlite' flag to 1!
            if(!empty($subscriber)) {
                $this->user->core_meta()->insert([
                    'key' => 'in_mailerlite',
                    'value' => 1
                ]);
            }
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        } 

        try {
            Mail::to($this->user->email)
                ->send(new WelcomeEmail($this->user));
        } catch(\Exception $e) {
            Log::error($e->getMessage());
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
