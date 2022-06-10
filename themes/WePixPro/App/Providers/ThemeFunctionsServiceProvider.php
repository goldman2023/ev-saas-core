<?php

namespace WeThemes\WePixPro\App\Providers;

// Because this file service provider is loaded after tenant is initated and has no namespace, it cannot use Aliases from `app.php`, like: use Log or use File; Instead full namespaces must be used!
use App\Providers\WeThemeFunctionsServiceProvider;
use App\Support\Hooks;
use Illuminate\Support\Facades\View;
use Livewire;
use TenantSettings;

class ThemeFunctionsServiceProvider extends WeThemeFunctionsServiceProvider
{
    protected function getTenantAppSettings(): array {
        return [
            'pix_pro_software_download_url' => 'string',
            'pix_pro_downloads' => 'array',
            'pix_pro_dataset_samples' => 'array',
            'pix_pro_api_enabled' => 'boolean',
            'pix_pro_api_endpoint' => 'string',
            'pix_pro_api_username' => 'string',
            'pix_pro_api_password' => 'string',
        ];
    }

    protected function getMenuLocations(): array {
        return [
            'header' => [
                'name' => 'Header',
                'unique' => true,
                'max_depth' => 3,
                'menu_item_types' => []
            ],
            'footer_1' => [
                'name' => 'Footer 1',
                'unique' => true,
                'max_depth' => 1,
                'menu_item_types' => []
            ],
            'footer_2' => [
                'name' => 'Footer 2',
                'unique' => true,
                'max_depth' => 1,
                'menu_item_types' => []
            ],
            'footer_3' => [
                'name' => 'Footer 3',
                'unique' => true,
                'max_depth' => 1,
                'menu_item_types' => []
            ],
        ];
    }

    protected function registerLivewireComponents() {
        Livewire::component('forms.generate-license-form', \WeThemes\WePixPro\App\Http\Livewire\Forms\GenerateLicenseForm::class);
    }

    /**
     * Bootstrap the theme function services.
     */
    public function boot()
    {   
        parent::boot();

        if (function_exists('add_filter')) {
            // Filter
            add_filter('app-settings-rules', function($rulesSets) {
                // Add pix-pro integration
                $rulesSets->put('integrations.pix_pro_api', [
                    'settings.pix_pro_api_enabled' => ['boolean'],
                    'settings.pix_pro_api_endpoint' => ['exclude_if:settings.pix_pro_api_enabled,false', 'required'],
                    'settings.pix_pro_api_username' => ['exclude_if:settings.pix_pro_api_enabled,false', 'required'],
                    'settings.pix_pro_api_password' => ['exclude_if:settings.pix_pro_api_enabled,false', 'required'],
                ]);
                return $rulesSets;
            }, 10, 1);

            // Add pix-pro general rules
            add_filter('app-settings-general-rules', function($rules_array) {
                return array_merge($rules_array, [
                    'settings.pix_pro_software_download_url' => 'nullable',
                    'settings.pix_pro_downloads' => 'nullable',
                    'settings.pix_pro_dataset_samples' => 'nullable',
                ]);
            }, 10, 1);

            // Add Columns to Licenses table (livewire)
            add_filter('dashboard.table.licenses.columns', function($columns) { 
                return array_merge($columns, [
                    \Rappasoft\LaravelLivewireTables\Views\Column::make('Hardware ID', 'hardware_id')
                        ->excludeFromSelectable(),
                ]);
            }, 10, 1);

            // Download License Response
            add_filter('license.download', function ($license) {
                return pix_pro_download_license_logic($license);
            }, 20, 1);
        }
        
        if (function_exists('add_action')) {
            // Actions

            // Register PixPro User
            add_action('user.registered', function ($user) {
                pix_pro_register_user($user);
            }, 20, 1);

            // Create PixPro License
            add_action('invoice.paid.subscription_create', function ($user_subscriptions) {
                pix_pro_create_license($user_subscriptions);
            }, 20, 1);

            // PixPro License disconnect by removing hardware_id
            add_action('license.disconnect', function ($license, $user, $form) {
                pix_pro_disconnect_license($license, $user, $form);
            }, 20, 3);

            // Extend PixPro License
            add_action('invoice.paid.subscription_cycle', function($user_subscriptions) {
                pix_pro_extend_license($user_subscriptions);
            }, 20, 1);

            // Update User password
            add_action('user.password.updated', function($user, $newPassword, $oldPassword) {
                pix_pro_update_user_password($user, $newPassword, $oldPassword);
            }, 20, 3);
            

            // View actions
            add_action('view.order-received.items.end', function($order) {
                if (View::exists('frontend.partials.order-received-download-cta')) {
                    echo view('frontend.partials.order-received-download-cta', compact('order'));
                }
            });

            // Add Pix-Pro API Integration Form
            add_action('view.integrations.end', function() {
                if (View::exists('frontend.partials.pix-pro-api-integration-form')) {
                    echo view('frontend.partials.pix-pro-api-integration-form');
                }
            });

            // Add Pix-Pro General Settings
            add_action('view.app-settings-form.general.end', function() {
                if (View::exists('frontend.partials.pix-pro-general-settings')) {
                    echo view('frontend.partials.pix-pro-general-settings');
                }
            });

            // Add Pix-Pro General Settings - $wire.set inside alpine/lw form
            add_action('view.app-settings-form.general.wire_set', function() {
                js_wire_set('settings.pix_pro_downloads', 'settings.pix_pro_downloads');
                js_wire_set('settings.pix_pro_dataset_samples', 'settings.pix_pro_dataset_samples');
            });

            add_action('view.dashboard.my-downloads.end', function() {
                if (View::exists('frontend.partials.pix-pro-software-downloads-table')) {
                    echo view('frontend.partials.pix-pro-software-downloads-table', [
                        'downloads' => collect(TenantSettings::get('pix_pro_downloads'))
                    ]);
                }
            });

            add_action('view.dashboard.plans-management.plans-table.end', function() {
                if (View::exists('frontend.partials.pix-pro-licenses-table')) {
                    echo view('frontend.partials.pix-pro-licenses-table');
                }
            });

            // Add Columns to Licenses table (View)
            add_action('view.dashboard.row-license.columns', function($license) {
                if (View::exists('frontend.partials.row-license-custom-columns')) {
                    echo view('frontend.partials.row-license-custom-columns', compact('license'));
                }
            });

            add_action('view.dashboard.plans.row-license.actions.dropdown.start', function($license) {
                if (View::exists('frontend.partials.row-license-actions')) {
                    echo view('frontend.partials.row-license-actions', compact('license'));
                }
            }, 20, 1);

            

            // Hook to Blog Posts import in ImportWordPressBlogPosts and import PixPro UseCases CPT
            // add_action('import.wordpress.blog-posts.end', function($data) {
            //     dd($data);
            // }, 10, 1);
        }
    }

    /**
     * Register all directives.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
    }
}
