<?php

namespace App\Providers;

use App\Http\Services\SocialiteManagerExtended;
use Illuminate\Container\Container;
use Laravel\Socialite\Contracts\Factory;

class SocialiteServiceProvider extends \Laravel\Socialite\SocialiteServiceProvider
{
    /**
     * Override: Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Factory::class, function () {
            return new SocialiteManagerExtended(fn () => Container:: getInstance());
        });
    }
}
