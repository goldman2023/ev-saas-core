<?php

namespace App\Providers;

use App\Models\Shop;
use DebugBar\DebugBar;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Qirolab\Theme\Theme;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {

    Schema::defaultStringLength(191);
    Paginator::useBootstrap();





  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
      if(config('app.debug')){
          \Debugbar::enable();
      }else{
          \Debugbar::disable();
      }
  }
}
