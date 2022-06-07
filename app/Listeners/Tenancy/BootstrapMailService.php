<?php

namespace App\Listeners\Tenancy;

use App\Facades\TenantSettings;
use Stancl\Tenancy\Events\TenancyBootstrapped;
use Qirolab\Theme\Theme;
use App;

class BootstrapMailService
{
    public function handle(TenancyBootstrapped $event)
    {
        /**
         * Based on tenant settings from DB, set mail config
         */
        if(get_tenant_setting('smtp_mail_enabled')) {
            config()->set('mail.driver', 'smtp');
            config()->set('mail.default', 'smtp');
            config()->set('mail.host', get_tenant_setting('smtp_mail_host', config('mail.host')));
            config()->set('mail.port', get_tenant_setting('smtp_mail_port', config('mail.port')));
            config()->set('mail.username', get_tenant_setting('smtp_mail_username', config('mail.username')));
            config()->set('mail.password', get_tenant_setting('smtp_mail_password', config('mail.password')));
            config()->set('mail.from.address', get_tenant_setting('mail_from_address', config('mail.from.address')));
            config()->set('mail.from.name', get_tenant_setting('mail_from_name', config('mail.from.name')));
        }

    }
}
