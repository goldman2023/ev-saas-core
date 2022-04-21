<?php

namespace App\Notifications\Messages;

use Illuminate\Notifications\Messages\MailMessage;

class WeMailMessage extends MailMessage
{
    public function __construct() {
        // IMPORTANT: Notifications use MailMessage, but we must define which MAILER is used alongside `from` and `replyTo` which are tenant related!

        $this->mailer('mailersend');
        $this->from(get_tenant_setting('mail_from_address', 'no-reply@dev-wesaas.com'), get_tenant_setting('mail_from_name', get_tenant_setting('site_name')));
        $this->replyTo(get_tenant_setting('mail_reply_to_address', 'support@dev-wesaas.com'), get_tenant_setting('mail_reply_to_name', get_tenant_setting('site_name'))); 
    }
}