<?php

namespace App\Providers;

use DebugBar\DebugBar;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
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
      if(env('APP_DEBUG')){
          \Debugbar::enable();
      }else{
          \Debugbar::disable();
      }


  }
}
