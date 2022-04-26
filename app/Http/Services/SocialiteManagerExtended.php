<?php

namespace App\Http\Services;

use App\Models\SocialAccount;
use Closure;
use Illuminate\Container\Container;
use Illuminate\Support\Arr;
use Illuminate\Support\Manager;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Laravel\Socialite\One\TwitterProvider;
use Laravel\Socialite\Two\BitbucketProvider;
use Laravel\Socialite\Two\FacebookProvider;
use Laravel\Socialite\Two\GithubProvider;
use Laravel\Socialite\Two\GitlabProvider;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\LinkedInProvider;
use League\OAuth1\Client\Server\Twitter as TwitterServer;

class SocialiteManagerExtended extends \Laravel\Socialite\SocialiteManager
{
    protected string $type = 'login';

    public function __construct(Closure|Container $container)
    {
        $this->container = $container instanceof Closure ? $container() : $container;
        $this->config = $this->container->make('config');

        $social_template = collect($this->config['services'])->filter(fn ($item, $key) => array_key_exists($key, SocialAccount::$available_providers))->toArray();

        foreach ($social_template as $provider => $data) {
            $this->setLoginRedirectUri($provider);
            $this->setConnectRedirectUri($provider);
        }
    }

    public function setConnectionType($type = 'login')
    {
        $this->type = $type;

        return $this;
    }

    public function setLoginRedirectUri($provider)
    {
        $this->config->set('services.'.$provider.'.redirect_login', route('social.login.callback', $provider));
    }

    public function setConnectRedirectUri($provider)
    {
        $this->config->set('services.'.$provider.'.redirect_connect', route('social.connect.callback', ['provider' => $provider]));
    }

    /**
     * Format the server configuration.
     *
     * @param  array  $config
     * @return array
     */
    public function formatConfig(array $config)
    {
        return array_merge([
            'identifier' => $config['client_id'],
            'secret' => $config['client_secret'],
            'callback_uri' => $this->formatRedirectUrl($config),
        ], $config);
    }

    /**
     * Format the callback URL, resolving a relative URI if needed.
     *
     * @param  array  $config
     * @return string
     */
    protected function formatRedirectUrl(array $config)
    {
        $redirect = value($this->type === 'login' ? $config['redirect_login'] : $config['redirect_connect']);

        return Str::startsWith($redirect, '/')
            ? $this->container->make('url')->to($redirect)
            : $redirect;
    }
}
