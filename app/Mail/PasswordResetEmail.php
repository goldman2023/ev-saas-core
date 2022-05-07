<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetEmail extends WeEmail
{
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;
    public $data;

    public function __construct($user, $data = []) 
    {
        parent::__construct();
        
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('emails.users.reset-password-email', ['user' => $this->user])
            ->text('emails.users.reset-password-email')
            ->subject(translate('Reset Your Password').' | '.get_tenant_setting('site_name'))
            ->mailersend();
    }
}
