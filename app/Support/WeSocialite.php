<?php

namespace App\Support;

use Illuminate\Http\Request;
use Laravel\Socialite\SocialiteManager;
use Laravel\Socialite\Two\FacebookProvider;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\LinkedInProvider;
use Socialite;

class WeSocialite
{
    /**
     * This static function is used to return Socialite provider driver with custom auth keys for each provider
     * Usage:
     * 1. Redirection to provider: \App\Support\WeSocialite::configDriver($request, $provider)->redirect();
     * 2. Callback from provider: \App\Support\WeSocialite::configDriver($request, $provider)->stateless()->user() (to get the user)
     */
    public static function configDriver(Request $request, $driver = '')
    {
        $config = [];
        $driver_class = '';
        $scopes = [];

        if ($driver === 'facebook') {
            $driver_class = FacebookProvider::class;
            $config['client_id'] = get_setting('facebook_app_id');
            $config['client_secret'] = get_setting('facebook_app_secret');
            $config['redirect_login'] = route('social.login.callback', ['provider' => 'facebook']);
            // TODO: If we want to get image or other data from facebook, we need to submit tenant App to Facebook review
            // Check here: https://developers.facebook.com/docs/permissions/reference/
            $scopes = ['public_profile', 'email'];
        } elseif ($driver === 'google') {
            $driver_class = GoogleProvider::class;
            $config['client_id'] = get_setting('google_oauth_client_id');
            $config['client_secret'] = get_setting('google_oauth_client_secret');
            $config['redirect_login'] = route('social.login.callback', ['provider' => 'google']);
        } elseif ($driver === 'linkedin') {
            $driver_class = LinkedInProvider::class;
            $config['client_id'] = get_setting('linkedin_client_id');
            $config['client_secret'] = get_setting('linkedin_client_secret');
            $config['redirect_login'] = route('social.login.callback', ['provider' => 'linkedin']);
        }

        return Socialite::buildProvider($driver_class, $config)->scopes($scopes);
    }
}
