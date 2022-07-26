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

class InvoiceCreated extends Notification
{
    public $invoice;

    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        try {
            return (new WeMailMessage)
                ->markdown('vendor.notifications.invoice.invoice-created', ['invoice' => $this->invoice, 'user' => $notifiable])
                ->subject(translate('New Invoice from '.get_tenant_setting('site_name')));
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function toArray($notifiable)
    {
        return [
            'invoice' => $this->invoice->attributesToArray(),
            // some other properties if necessary...
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'invoice' => $this->invoice->attributesToArray(),
            // some other properties if necessary...
        ];
    }

}
