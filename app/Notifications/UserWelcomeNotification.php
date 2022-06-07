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


class UserWelcomeNotification extends Notification
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
                ->subject(translate('Welcome to '.get_tenant_setting('site_name')))
                ->greeting(translate('Hello, ').$notifiable->name)
                ->line(translate('Welcome to our site.'))
                ->line(translate('Thank you for using our application!'))
                ->action('Go to dashboard', route('dashboard'));

                // ->mailersend();
            // Mail::to($notifiable->email)
            //     ->send(new EmailVerification(user: $notifiable, data: $array));
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

}
