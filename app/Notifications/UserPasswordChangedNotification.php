<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Notifications\Notification;
use App\Notifications\Messages\WeMailMessage;
use Illuminate\Support\Facades\URL;
use App\Mail\EmailManager;
use Auth;
use Log;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;


class UserPasswordChangedNotification extends Notification
{

    public function __construct()
    {

    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        try {
            return (new WeMailMessage)
                ->subject(apply_filters('notifications.user-password-changed.subject', translate('Password has been changed').' | '.get_tenant_setting('site_name')))
                ->view(
                    'emails.users.user-password-changed',
                    ['user' => $notifiable]
                );
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

}
