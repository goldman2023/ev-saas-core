<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;
use MailerSend\Helpers\Builder\Variable;
use MailerSend\Helpers\Builder\Personalization;
use Carbon;

class WelcomeEmail extends WeEmail
{

    public $user;

    public function __construct($user)
    {
        parent::__construct();

        $this->user = $user;
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
            ->view('emails.user_welcome')
            // ->text('emails.test_text')
            ->mailersend();
        
    }
}
