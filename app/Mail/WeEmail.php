<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use MailerSend\LaravelDriver\MailerSendTrait;
use Illuminate\Support\Arr;
use MailerSend\Helpers\Builder\Variable;
use MailerSend\Helpers\Builder\Personalization;
use Carbon;

class WeEmail extends Mailable
{
    use Queueable, SerializesModels, MailerSendTrait;

    public function __construct()
    {
        // IMPORTANT: Every tenant email should:
        // 1. Extend this class
        // 2. Have a construct call with parent::__construct() BEFORE setting any data!

        $this->from(get_tenant_setting('mail_from_address', 'no-reply@dev-wesaas.com'), get_tenant_setting('mail_from_name', get_tenant_setting('site_name')));
        $this->replyTo(get_tenant_setting('mail_reply_to_address', 'support@dev-wesaas.com'), get_tenant_setting('mail_reply_to_name', get_tenant_setting('site_name')));
    }
}
