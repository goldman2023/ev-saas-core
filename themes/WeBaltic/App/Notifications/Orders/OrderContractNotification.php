<?php

namespace WeThemes\WeBaltic\App\Notifications\Orders;

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

class OrderContractNotification extends WeNotification
{
    public $order;
    public $contract;

    public function __construct($order, $throw_error = false)
    {
        parent::__construct(throw_error: $throw_error, activity_log_causer: $order);

        $this->order = $order;
        $this->contract = $this->order->getUploadsWhere('documents', wef_params: [
            ['upload_tag', 'contract']
        ]);
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toDatabase($notifiable) {
        return [
            'title' => translate('Contract created and sent to the user'),
            'data' => ['action' => 'order_contract_created', 'contract' => $this->contract->attributesToArray(), 'user' => $notifiable->attributesToArray(), 'order' => $this->order->attributesToArray()]
        ];
    }

    public function toMail($notifiable)
    {
        try {
            return (new WeMailMessage)
                ->subject(apply_filters('notifications.order-contract.subject', translate('Unsigned order contract').' | '.get_tenant_setting('site_name')))
                ->attachData($this->contract->rawData(), translate('unsigned-contract-for-order-').$this->order->id, [
                    'mime' => 'application/pdf',
                ])
                ->view(
                    'emails.orders.order-contract',
                    [
                        'user' => $notifiable,
                        'order' => $this->order,
                        'contract' => $this->contract
                    ]
                );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            if($this->throw_error) {
                throw $e;
            }
        }
    }
}
