<?php

namespace App\Providers;

use App\Http\Services\SocialiteManagerExtended;
use Laravel\Socialite\Contracts\Factory;
use Illuminate\Container\Container;

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
