<?php

namespace App\Providers;

use App\Nova\Central\Domain;
use App\Nova\Central\Tenant as TenantResource;
use App\Nova\Tenant\User;
use App\Models\Tenant;
use App\Nova\Central\Section;
use App\Nova\Dashboards\Main;
use App\Nova\Tenant\Order;
use App\Nova\Tenant\Blog;
use App\Nova\Tenant\Shop;
use App\Nova\Tenant\Wishlist;
use App\Nova\Tenant\Activity;
use App\Nova\Tenant\Category;
use App\Nova\Tenant\Invoice;
use App\Nova\Tenant\License;
use App\Nova\Tenant\OrderDetail;
use App\Nova\Tenant\Page;
use App\Nova\Tenant\PaymentMethodUniversal;
use App\Nova\Tenant\Plan;
use App\Nova\Tenant\Product;
use App\Nova\Tenant\ProductVariation;
use App\Nova\Tenant\ProductVariations;
use App\Nova\Tenant\ShopSetting;
use App\Nova\Tenant\Translation;
use App\Nova\Tenant\UserSubscription;
use App\Nova\Tenant\WeQuiz;
use App\Nova\WeQuizResults;
use App\Nova\WeWorkflow;
use App\Nova\WooImport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Outl1ne\MenuBuilder\MenuBuilder;
use Outl1ne\MenuBuilder\Models\Menu as ModelsMenu;
use Outl1ne\MenuBuilder\Models\MenuItem as ModelsMenuItem;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::style('admin', asset('nova/css/custom-nova-styles.css'));

        Nova::serving(function () {
            Tenant::creating(function (Tenant $tenant) {
                $tenant->ready = false;
            });

            Tenant::created(function (Tenant $tenant) {
                $tenant->createAsStripeCustomer();
            });
        });

        Nova::userMenu(function (Request $request, Menu $menu) {
            return $menu
                ->append(MenuItem::externalLink('API Docs', 'https://docs.we-saas.com'))
                ->prepend(MenuItem::link('My Profile', '/resources/users/'.$request->user()->getKey()));
            });

        Nova::mainMenu(function (Request $request) {

            return [
                MenuSection::dashboard(Main::class)->icon('chart-bar'),

                MenuSection::make('General', [
                    MenuItem::resource(Page::class),
                    MenuItem::make('Menu Management')
                    ->path('/menus'),
                    // @EIM TODO: Why doesn't it add MenuResource to the left menu even though it seems referenced correctly?
                    MenuItem::resource(MenuBuilder::getMenuResource()),
                ])->icon('user')->collapsable(),

                MenuSection::make('Business', [
                    MenuItem::resource(Plan::class),
                    MenuItem::resource(Product::class),
                    MenuItem::resource(License::class),

                    MenuItem::externalLink('Stripe Payments', 'https://dashboard.stripe.com/payments?status%5B%5D=successful'),

                ])->icon('credit-card')->collapsable(),

                MenuSection::make('Content', [
                    MenuItem::resource(Activity::class),
                    MenuItem::resource(Category::class),
                    MenuItem::resource(Page::class),
                    MenuItem::resource(Blog::class),
                    MenuItem::resource(WeQuiz::class),
                    MenuItem::resource(WeQuizResults::class),

                ])->icon('document')->collapsable(),


                MenuSection::make('Commerce', [
                    MenuItem::resource(Order::class),
                    MenuItem::resource(Invoice::class),
                    MenuItem::resource(UserSubscription::class),

                ])->icon('document-text')->collapsable(),

                MenuSection::make('Users & Customers', [
                    MenuItem::resource(User::class),
                    MenuItem::resource(Shop::class),
                    MenuItem::externalLink('Mailerlite & Newsletters', 'https://dashboard.mailerlite.com/subscribers?status=active'),

                ])->icon('document-text')->collapsable(),

                MenuSection::make('Advanced', [

                    MenuItem::resource(WooImport::class),
                    MenuItem::resource(WeWorkflow::class),
                    MenuItem::externalLink('SMTP and transactional emails', 'https://dashboard.stripe.com/payments?status%5B%5D=successful'),
                    MenuItem::resource(Translation::class),

                    MenuItem::make('Logs')->path('/logs'),


                ])->icon('adjustments')->collapsable(),

            ];


        });


    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes(['tenant', 'universal'])
                ->withAuthenticationRoutes(['tenant', 'universal'])
                ->withPasswordResetRoutes(['tenant', 'universal'])
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {

            if ($user instanceof \App\Models\User) {
                // return $user->isOwner();
            }

            /** @var \App\Models\Admin $user */

            return true;
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new Help,
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        if (tenancy()->initialized) {
            return [
                MenuBuilder::make(),
                \Laravel\Nova\LogViewer\LogViewer::make(),
                // new \Bolechen\NovaActivitylog\NovaActivitylog(),
            ];
        } else {
            return [
                // new \Tighten\NovaStripe\NovaStripe,
            ];
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function resources()
    {

        if (tenancy()->initialized) {
            Nova::resources([
                Blog::class,
                User::class,
                Activity::class,
                Wishlist::class,
                ShopSetting::class,
                PaymentMethodUniversal::class,
                Category::class,
                Plan::class,
                Translation::class,
                ProductVariation::class,
                Product::class,
                Shop::class,
                Order::class,
                WeWorkflow::class,
                WooImport::class,
                Page::class,
                WeQuiz::class,
                WeQuizResults::class,
                Invoice::class,
                UserSubscription::class,
                License::class,
                MenuBuilder::getMenuResource()
            ]);
        } else {
            Nova::resources([
                // Admin::class,
                TenantResource::class,
                Domain::class,
                Section::class,
                // SubscriptionCancelation::class,
            ]);
        }
    }
}
