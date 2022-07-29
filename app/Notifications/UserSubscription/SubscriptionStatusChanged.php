<?php

namespace App\Notifications\UserSubscription;

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

class SubscriptionStatusChanged extends Notification
{
    public $subscription;
    public $old_status;
    public $new_status;
    public $subject;

    public function __construct($subscription)
    {
        $this->subscription = $subscription;
        $this->old_status = $this->subscription->getOriginal('status');
        $this->new_status = $this->subscription->status;

        if($old_status === 'trial' && $new_status === 'active') {
            // Subscription status changed from TRIAL to ACTIVE
            $this->subject = translate('You subscription on '.get_tenant_setting('site_name').' is now fully active!');
        } else if($old_status === 'active' && $new_status === 'inactive') {
            // Subscription status changed from ACTIVE to INACTIVE (immediate cancelation)
            $this->subject = translate('You subscription on '.get_tenant_setting('site_name').' has been canceled!');

        } else if($old_status === 'active' && $new_status === 'active_until_end') {
            // Subscription status changed from ACTIVE to ACTIVE_UNTIL_END (subscription is about to be canceled on, but on end_date)
            $this->subject = translate('You subscription on '.get_tenant_setting('site_name').' will be canceled on '.$this->subscription->end_date->format('d M, Y'));
        }
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        try {
            return (new WeMailMessage)
                ->markdown('vendor.notifications.subscription.subscription-status-changed', [
                    'subscription' => $this->subscription, 
                    'user' => $notifiable,
                    'old_status' => $old_status,
                    'new_status' => $new_status,
                ])
                ->subject($this->subject);
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
