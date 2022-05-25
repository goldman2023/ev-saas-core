<?php

namespace App\Notifications\Admin;

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

class GeneralTransactionalNotification extends Notification
{

    public $subject = '';
    public $text = '';

    public function __construct($subject, $text)
    {
        $this->subject = $subject;
        $this->text = $text;
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
                ->subject($this->subject)
                ->line($this->text);
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

}
