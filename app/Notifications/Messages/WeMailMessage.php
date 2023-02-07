<?php

namespace App\Notifications\Messages;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use MailerSend\LaravelDriver\MailerSendTrait;

class WeMailMessage extends MailMessage
{
    use Queueable, SerializesModels, MailerSendTrait;

    public function __construct() {
        // IMPORTANT: Default mailer used for notifications is defined in App\Listeners\Tenancy\BootstrapMailConfig listener, where config envs are overwritten per tenant by DB settings

        $this->from(get_tenant_setting('mail_from_address'), get_tenant_setting('mail_from_name', get_tenant_setting('site_name')));
        $this->replyTo(get_tenant_setting('mail_reply_to_address'), get_tenant_setting('mail_reply_to_name', get_tenant_setting('site_name'))); 
    }
}