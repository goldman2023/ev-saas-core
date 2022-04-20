<?php

namespace App\Providers;

use Illuminate\Mail\MailManager;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use MailerSend\MailerSend;
use MailerSend\LaravelDriver\LaravelDriverServiceProvider;
use MailerSend\LaravelDriver\MailerSendTransport;

class MailerSendServiceProvider extends LaravelDriverServiceProvider
{
    public function boot()
    {
        $this->app->make(MailManager::class)->extend('mailersend', function () {
            $config = $this->app['config']->get('mailersend-driver', []);

            $mailersend = new MailerSend([
                'api_key' => get_tenant_setting('mailersend_api_token'), // Arr::get($config, 'api_key'),
                'host' => Arr::get($config, 'host'),
                'protocol' => Arr::get($config, 'protocol'),
                'api_path' => Arr::get($config, 'api_path'),
            ]);

            return new MailerSendTransport($mailersend);
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/mailersend-driver.php', 'mailersend-driver');
    }
}