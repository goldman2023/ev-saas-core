<?php

namespace App\Notifications\Orders;

use Log;
use Auth;
use Carbon\Carbon;
use App\Mail\EmailManager;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Notifications\WeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Messages\WeMailMessage;

class RequestQuoteOrderCreatedNotification extends WeNotification
{
    public $order;

    public function __construct($order, $throw_error = false)
    {
        parent::__construct($throw_error);

        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toDatabase($notifiable) {
        return [
            'title' => translate('New order quote has been requested'),
            'data' => ['user' => $notifiable->attributesToArray(), 'order' => $this->order->attributesToArray()]
        ];
    }

    public function toMail($notifiable)
    {
        try {
            return (new WeMailMessage)
                ->subject(apply_filters('notifications.request-quote-order-created.subject', translate('New quote requested from ').' '.get_tenant_setting('site_name')))
                ->view(
                    'emails.orders.request-quote-order-created',
                    ['user' => $notifiable, 'order' => $this->order]
                );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            if($this->throw_error) {
                throw $e;
            }
        }
    }
}
