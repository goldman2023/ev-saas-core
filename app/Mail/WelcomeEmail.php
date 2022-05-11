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
        return $this
            ->view('vendor.notifications.email')
            ->text('mail.text.message')
            ->subject(translate('Welcome to '.get_tenant_setting('site_name')))
            ->greeting(translate('Hello, ').$this->user->name)
            ->line(translate('Welcome to our site. This is an example text :)'))
            ->action('Go to dashboard', route('dashboard'))
            ->line(translate('Thank you for using our application!'))
            ->mailersend();
        
    }
}
