<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Messages\WeMailMessage;
use Illuminate\Support\Facades\URL;
use App\Mail\EmailManager;
use Auth;

class EmailVerificationNotification extends Notification
{
    use Queueable;

    public function __construct()
    {

    }

    public function via($notifiable)
    {
        return [''];
    }

    public function toMail($notifiable)
    {
        // IMPORTANT: Illuminate\Foundation\Auth\EmailVerificationRequest uses sha1 instead of encrypt to create verification_code for email verification!!!!
        $notifiable->verification_code = sha1($notifiable->email); // 
        $notifiable->save();

        $array['view'] = 'emails.users.email-verification';
        $array['subject'] = translate('Email Verification').' | '.get_tenant_setting('site_name');
        $array['preheader'] = translate('Please verify your email address');
        $array['content'] = translate('Please click the button below to verify your email address.');
        $array['link'] = route('user.email.verification.verify', ['id' => $notifiable->id, 'hash' => $notifiable->verification_code]);

        return (new WeMailMessage)
            ->view('emails.users.email-verification', ['data' => $array])
            ->subject($array['subject']);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
