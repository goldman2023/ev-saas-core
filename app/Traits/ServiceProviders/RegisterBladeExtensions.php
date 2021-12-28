<?php

namespace App\Traits\ServiceProviders;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

/*
 * In specified ServiceProvider add desired following properties before use!
 *
 * protected $directives = [
 *         'package-alert' => 'App\Blade\Directives\AlertComponent@alert',
 *         'status-now' => 'App\Blade\Directives\Status@now',
 *     ]
 *
 *     protected $if = [
 *         'cloud' => 'App\Blade\Conditions\Cloud',
 *         'local' => 'App\Blade\Conditions\Local@condition',
 *     ]
 *
 *     protected $include = [
 *         'input' => 'includes.input'
 *         'authavatar' => 'includes.auth_avatar'
 *     ]
 *
 *     public function boot()
 *     {
 *         $this->registerBladeExtensions();
 *
 *         // ...
 *     }
 */
trait RegisterBladeExtensions
{
    /**
     * Register directives, includes and if statements in Blade.
     *
     * @return void
     */
    protected function registerBladeExtensions(): void
    {
        $compiler = Blade::getFacadeRoot();

        foreach ($this->directives ?? [] as $name => $handler) {
            $compiler->directive($name, Str::parseCallback($handler));
        }

        foreach ($this->if ?? [] as $name => $handler) {
            $compiler->if($name, Str::parseCallback($handler));
        }

        foreach ($this->include ?? [] as $name => $view) {
            $compiler->include($name, $view);
        }
    }
}
