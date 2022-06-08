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
                ->markdown('vendor.notifications.email')
                // ->text('mail.text.message')
                ->subject(translate('Password has been changed'))
                ->greeting(translate('Greetings').' '.$notifiable->name)
                ->line(translate('Your password on '.get_tenant_setting('site_name').' has been changed.'))
                ->line(translate('If you didn\'t make this change, please contact our support or go through the "Forgot my password" process ASAP.'))
                ->action('Login', route('user.login'));
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

}
