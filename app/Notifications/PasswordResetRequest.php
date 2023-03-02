<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Messages\WeMailMessage;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordResetRequest extends WeNotification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public function __construct()
    {

    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toDatabase($notifiable) {
        return [
            'type' => translate('User requested a password change (ID: #'.$notifiable->id.')'),
            'data' => ['action' => 'user_password_reset_request', 'user_id' => $notifiable->id]
        ];
    }

    public function toMail($notifiable)
    {
        return (new WeMailMessage)
            ->view('emails.users.reset-password-request', ['user' => $notifiable])
            ->subject(apply_filters('notifications.password-reset-request.subject', translate('Reset Your Password').' | '.get_tenant_setting('site_name')));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
