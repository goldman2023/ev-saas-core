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


class UserWelcomeNotification extends WeNotification
{

    public function __construct()
    {

    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toDatabase($notifiable) {
        return [
            'type' => translate('User Welcome Notification'),
            'data' => ['action' => 'user_welcome', 'user_id' => $notifiable->id]
        ];
    }

    public function toMail($notifiable)
    {
        try {
            return (new WeMailMessage)
                ->subject(apply_filters('notifications.user-welcome.subject', translate('Welcome to ' . get_tenant_setting('site_name'))))
                ->view(
                    'emails.users.welcome',
                    ['user' => $notifiable]
                );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
