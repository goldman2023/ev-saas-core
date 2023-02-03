<?php

namespace App\Providers;

use App\Models\Plan;
use App\Models\User;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\OrderItem;
use App\Models\ProductStock;
use App\Models\SerialNumber;
use App\Models\TenantSetting;
use App\Models\AttributeValue;
use App\Observers\UserObserver;
use App\Models\ProductVariation;
use App\Models\UserSubscription;
use App\Observers\PlansObserver;
use App\Observers\OrdersObserver;
use App\Observers\InvoicesObserver;
use App\Observers\ProductsObserver;
use App\Models\CategoryRelationship;
use App\Observers\AttributeObserver;
use App\Observers\OrderItemObserver;
use App\Events\Eloquent\ItemsQueried;
use App\Observers\CategoriesObserver;
use Illuminate\Auth\Events\Registered;
use App\Observers\ProductStocksObserver;
use App\Observers\SerialNumbersObserver;
use App\Observers\TenantSettingsObserver;
use App\Observers\AttributeValuesObserver;
use App\Events\Plans\PlanSubscriptionCancel;
use App\Events\Plans\PlanSubscriptionRevive;
use App\Observers\ProductVariationsObserver;
use App\Observers\UserSubscriptionsObserver;
use App\Observers\CategoryRelationshipsObserver;
use App\Traits\ServiceProviders\RegisterObservers;


use App\Listeners\Eloquent\CustomAttributesEagerLoad;
use App\Listeners\Plans\CancelStripePlanSubscription;

use App\Listeners\Plans\ReviveStripePlanSubscription;
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
            CustomAttributesEagerLoad::class
        ],

        // Plans Events
        PlanSubscriptionCancel::class => [CancelStripePlanSubscription::class],
        PlanSubscriptionRevive::class => [ReviveStripePlanSubscription::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        /**
         * The observers mappings for the application.
         *
         * @var array
         */
        $observers = [
            TenantSetting::class => [TenantSettingsObserver::class],
            Product::class => [ProductsObserver::class],
            ProductVariation::class => [ProductVariationsObserver::class],
            ProductStock::class => [ProductStocksObserver::class],
            SerialNumber::class => [SerialNumbersObserver::class],
            Plan::class => [PlansObserver::class],
            UserSubscription::class => [UserSubscriptionsObserver::class],
            Category::class => [CategoriesObserver::class],
            Attribute::class => [AttributeObserver::class],
            AttributeValue::class => [AttributeValuesObserver::class],
            Order::class => [OrdersObserver::class],
            OrderItem::class => [OrderItemObserver::class],
            Invoice::class => [InvoicesObserver::class],
            User::class => [UserObserver::class],
        ];


        foreach ($observers ?? [] as $model => $handlers) {
            foreach ((array) $handlers as $handler) {
                $model::observe($handler);
            }
        }

        // Register All Observers
        $this->registerObservers();
    }
}
