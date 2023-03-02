<?php

namespace App\Notifications;

use Log;
use Auth;
use Uuid;
use Carbon\Carbon;
use App\Mail\EmailManager;
use Illuminate\Bus\Queueable;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notification;
use App\Notifications\Messages\WeMailMessage;


class UserEmailVerificationNotification extends WeNotification
{
    use Queueable;

    public function __construct()
    {

    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toDatabase($notifiable) {
        return [
            'type' => translate('Email verification sent to user (#'.$notifiable->id.')'),
            'data' => ['action' => 'user_email_verification_email', 'user_id' => $notifiable->id]
        ];
    }

    public function toMail($notifiable)
    {
        // IMPORTANT: Illuminate\Foundation\Auth\EmailVerificationRequest uses sha1 instead of encrypt to create verification_code for email verification!!!!
        $notifiable->verification_code = sha1($notifiable->email);
        $notifiable->save();
        
        try {
            return (new WeMailMessage)
                ->subject(apply_filters('notifications.user-email-verification.subject', translate('Verify Email on').' '. get_tenant_setting('site_name')))
                ->view(
                    'emails.users.email-verification',
                    ['user' => $notifiable]
                );
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

}
