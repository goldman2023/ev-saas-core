<?php

namespace App\Providers;

use App\Http\Services\PermissionsService;
use App\Models\Product;
use App\Policies\ProductPolicy;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [
     Product::class => ProductPolicy::class,
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();

      // Implicitly grant "Super Admin" role all permissions
      // This works in the app by using gate-related functions like auth()->user->can() and @can()
//      Gate::before(function ($user, $ability) {
//          return $user->hasRole('Super Admin') ? true : null;
//      });

      // Register Permissions Service Singleton
      $this->app->singleton('permissions', function() {
          return new PermissionsService(fn () => Container::getInstance());
      });
  }
}
