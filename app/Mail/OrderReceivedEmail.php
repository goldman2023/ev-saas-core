<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;
use MailerSend\Helpers\Builder\Variable;
use MailerSend\Helpers\Builder\Personalization;
use Carbon;

class OrderReceivedEmail extends WeEmail
{

    public $order;

    public function __construct($order)
    {
        parent::__construct();

        $this->order = $order;
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
            ->view('emails.orders.order-received')
            ->text('emails.orders.order-received')
            ->mailersend();
        
    }
}
