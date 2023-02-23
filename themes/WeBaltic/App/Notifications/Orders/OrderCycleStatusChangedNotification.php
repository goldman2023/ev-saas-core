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
use WeThemes\WeBaltic\App\Enums\OrderCycleStatusEnum;

class OrderCycleStatusChangedNotification extends WeNotification
{
    public $order;
    public $old_status;
    public $old_status_label;
    public $new_status;
    public $new_status_label;

    public function __construct($order, $old_status, $new_status, $throw_error = false)
    {
        parent::__construct($throw_error);

        $this->order = $order;
        $this->old_status = $old_status;
        $this->new_status = $new_status;

        $this->old_status_label = OrderCycleStatusEnum::labels()[$old_status] ?? '';
        $this->new_status_label = OrderCycleStatusEnum::labels()[$new_status] ?? '';
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toDatabase($notifiable) {
        return [
            'title' => translate('Order ('.$this->order->id.') cycle status update from '.$this->old_status_label.' to '.$this->new_status_label),
            'data' => ['user' => $notifiable->attributesToArray(), 'order' => $this->order->attributesToArray(), 'old_status' => $this->old_status, 'new_status' => $this->new_status]
        ];
    }

    public function toMail($notifiable)
    {
        try {
            return (new WeMailMessage)
                ->subject(apply_filters('notifications.order-cycle-status-changed.subject', translate('New order status:').' '.$this->new_status_label.' | '.get_tenant_setting('site_name')))
                ->view(
                    'emails.orders.order-cycle-status-changed',
                    [
                        'user' => $notifiable,
                        'old_status' => $this->old_status,
                        'old_status_label' => $this->old_status_label,
                        'new_status' => $this->new_status,
                        'new_status_label' => $this->new_status_label,
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
