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

class ContactNotification extends Notification
{
    public $first_name;
    public $last_name;
    public $email;
    public $subject;
    public $message;
    public $phone;

    public function __construct($first_name, $last_name, $email, $phone, $subject, $message)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->phone = $phone;
        $this->subject = $subject;
        $this->message = $message;
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
                ->subject(translate('Contact').': '.$this->subject)
                ->line(translate('First name').': '.$this->first_name)
                ->line(translate('Last name').': '.$this->last_name)
                ->line(translate('Email').': '.$this->email)
                ->line(translate('Phone').': '.$this->phone)
                ->line($this->message);
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

}
