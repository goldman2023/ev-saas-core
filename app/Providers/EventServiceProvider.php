<?php

namespace App\Providers;

use App\Models\CategoryRelationship;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\TenantSetting;
use App\Observers\CategoryRelationshipsObserver;
use App\Observers\ProductsObserver;
use App\Observers\ProductVariationsObserver;
use App\Observers\TenantSettingsObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Traits\ServiceProviders\RegisterObservers;

class EventServiceProvider extends ServiceProvider
{
    use RegisterObservers;

    /**
    * The event listener mappings for the application.
    *
    * @var array
    */
    protected $listen = [
        Registered::class => [
          SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * The observers mappings for the application.
     *
     * @var array
     */
    protected array $observers = [
        TenantSetting::class => [TenantSettingsObserver::class],
        Product::class => [ProductsObserver::class],
        ProductVariation::class => [ProductVariationsObserver::class],
        CategoryRelationship::class => [CategoryRelationshipsObserver::class]
    ];

    /**
    * Register any events for your application.
    *
    * @return void
    */
    public function boot()
    {
        parent::boot();

        // Register All Observers
        $this->registerObservers();
    }
}
