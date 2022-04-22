<?php

namespace App\Providers;

use App\Events\Eloquent\ItemsQueried;
use App\Listeners\Eloquent\CustomAttributesEagerLoad;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\CategoryRelationship;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductVariation;
use App\Models\SerialNumber;
use App\Models\TenantSetting;
use App\Observers\AttributeObserver;
use App\Observers\AttributeValuesObserver;
use App\Observers\CategoryRelationshipsObserver;
use App\Observers\ProductsObserver;
use App\Observers\ProductStocksObserver;
use App\Observers\ProductVariationsObserver;
use App\Observers\SerialNumbersObserver;
use App\Observers\TenantSettingsObserver;
use App\Traits\ServiceProviders\RegisterObservers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        ItemsQueried::class => [
            CustomAttributesEagerLoad::class,
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
        ProductStock::class => [ProductStocksObserver::class],
        SerialNumber::class => [SerialNumbersObserver::class],
        CategoryRelationship::class => [CategoryRelationshipsObserver::class],
        Attribute::class => [AttributeObserver::class],
        AttributeValue::class => [AttributeValuesObserver::class],
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

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
