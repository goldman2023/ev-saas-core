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
        parent::__construct($throw_error);

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
            'title' => translate('Contract sent to user'),
            'data' => ['user' => $notifiable->attributesToArray(), 'order' => $this->order->attributesToArray()]
        ];
    }

    public function toMail($notifiable)
    {
        try {
            return (new WeMailMessage)
                ->subject(apply_filters('notifications.order-contract-signed.subject', translate('Order contract signed').' | '.get_tenant_setting('site_name')))
                ->attachData($this->contract->rawData(), basename($this->contract->file_name), [
                    'mime' => 'application/pdf',
                ])
                ->view(
                    'emails.orders.order-contract-signed',
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
