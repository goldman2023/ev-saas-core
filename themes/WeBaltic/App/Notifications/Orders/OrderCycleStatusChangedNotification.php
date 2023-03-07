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
    public $current_timestamp;

    public function __construct($order, $old_status, $new_status, $current_timestamp = null, $throw_error = false)
    {
        parent::__construct(throw_error: $throw_error, activity_log_causer: $order);

        $this->order = $order;
        $this->old_status = $old_status;
        $this->new_status = $new_status;

        $this->old_status_label = OrderCycleStatusEnum::labels()[$old_status] ?? '';
        $this->new_status_label = OrderCycleStatusEnum::labels()[$new_status] ?? '';

        $this->current_timestamp = empty($current_timestamp) ? time() : $current_timestamp;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toDatabase($notifiable) {
        return [
            'title' => translate('Order) ') . '('.$this->order->id.') '. translate('Cycle status updated from') .' '. $this->old_status_label. translate(' to ') .$this->new_status_label,
            'data' => ['action' => 'order_cycle_status_changed', 'old_status' => $this->old_status, 'new_status' => $this->new_status, 'changed_on' => $this->current_timestamp, 'user' => $notifiable->attributesToArray(), 'order' => $this->order->attributesToArray()]
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
                        'order' => $this->order,
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
