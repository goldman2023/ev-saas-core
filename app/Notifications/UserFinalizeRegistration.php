<?php

namespace App\Notifications;

use Log;
use Auth;
use Carbon\Carbon;
use App\Mail\EmailManager;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Messages\WeMailMessage;


class UserFinalizeRegistration extends WeNotification
{
    public function __construct()
    {

    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => translate('New ghost user created (ID: '.$notifiable->id.'). Notification for registration finalization is sent.'),
            'data' => ['action' => 'finalize_ghost_user_registration', 'user' => $notifiable->attributesToArray()]
        ];
    }

    public function toMail($notifiable)
    {
        $notifiable->verification_code = sha1($notifiable->id.'_'.$notifiable->email);
        $notifiable->save();

        try {
            return (new WeMailMessage)
                ->subject(apply_filters('notifications.user-finalize-registration.subject', translate('Finalize your registration on').' '.get_tenant_setting('site_name')))
                ->view(
                    'emails.users.finalize-registration',
                    ['user' => $notifiable]
                );
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

}
