<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;
use MailerSend\Helpers\Builder\Variable;
use MailerSend\Helpers\Builder\Personalization;
use Carbon;

class InvoiceCreatedEmail extends WeEmail
{

    public $invoice;

    public function __construct($invoice)
    {
        parent::__construct();

        $this->invoice = $invoice;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
     public function build()
     {
        $to = Arr::get($this->to, '0.address');
        
        return $this
            ->view('emails.invoices.invoice-created')
            ->text('emails.invoices.invoice-created')
            ->mailersend();
        
    }
}
