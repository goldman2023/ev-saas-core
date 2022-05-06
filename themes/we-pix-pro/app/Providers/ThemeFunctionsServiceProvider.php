<?php

use Illuminate\Support\ServiceProvider;
use App\Support\Hooks;

class ThemeFunctionsServiceProvider extends ServiceProvider
{
    protected $theme_root;
    protected $theme_helpers;

    /**
     * Bootstrap the theme function services.
     */
    public function boot()
    {
        if (function_exists('add_action')) {
            // Register PixPro User
            add_action('user.registered', function ($user) {
                pix_pro_register_user($user);
            }, 20, 1);

            // Create PixPro License
            add_action('invoice.paid.subscription_create', function ($user_subscriptions) {
                pix_pro_create_license($user_subscriptions);
            }, 20, 1);
        }
    }

    /**
     * Register all directives.
     *
     * @return void
     */
    public function register()
    {
        if (tenant()->domains()->first()) {
            // Set `theme_root` and `theme_helpers` paths
            $this->theme_root = base_path() . '/themes/' . tenant()->domains()->first()->theme;
            $this->theme_helpers = $this->theme_root . '/app/Helpers/*.php';

            // Loop through all helper functions in the theme, and require each php file laoded with functions!
            foreach (glob($this->theme_helpers) as $filename) {
                require_once($filename);
            }
        }
    }
}
