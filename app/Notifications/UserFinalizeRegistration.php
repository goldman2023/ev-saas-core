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


class UserFinalizeRegistration extends Notification
{

    public $verification_code;

    public function __construct($verification_code)
    {
        $this->verification_code = $verification_code;
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
                ->subject(translate('Finalize your registration on '.get_tenant_setting('site_name')))
                ->greeting(translate('Hello, ').$notifiable->name)
                ->line(translate('You have recently purchased from '.get_tenant_setting('site_name')))
                ->line(translate('To access or manage your purchased content, please finalize your registration.'))
                ->action('Finalize registration', route('user.registration.finalize', ['id' => $notifiable->id, 'hash' => $this->verification_code]));
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

}
