<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends WeEmail
{
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;
    public $data;

    public function __construct($user, $data)
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
            ->view('emails.users.email-verification', ['data' => $this->data])
            ->subject($this->data['subject'])
            ->mailersend();
    }
}
