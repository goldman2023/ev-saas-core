<?php

namespace App\Notifications\Invoice;

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

class CanceledSubscription extends Notification
{
    public $subscription;

    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        try {
            return (new WeMailMessage)
                ->markdown('vendor.notifications.subdcription.subscription-canceled', ['subscription' => $this->subscription, 'user' => $notifiable])
                ->subject(translate('Canceled subscription on '.get_tenant_setting('site_name')));
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function toArray($notifiable)
    {
        return [
            'subscription' => $this->subscription->attributesToArray(),
            // some other properties if necessary...
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'subscription' => $this->subscription->attributesToArray(),
            // some other properties if necessary...
        ];
    }

}
