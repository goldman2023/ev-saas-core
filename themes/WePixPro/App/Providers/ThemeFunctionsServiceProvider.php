<?php

namespace WeThemes\WePixPro\App\Providers;

// Because this file service provider is loaded after tenant is initated and has no namespace, it cannot use Aliases from `app.php`, like: use Log or use File; Instead full namespaces must be used!
use App\Providers\WeThemeFunctionsServiceProvider;
use App\Support\Hooks;
use Illuminate\Support\Facades\View;
use Livewire;
use TenantSettings;
use Log;

class ThemeFunctionsServiceProvider extends WeThemeFunctionsServiceProvider
{
    protected function getTenantAppSettings(): array
    {
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

    protected function getMenuLocations(): array
    {
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

    protected function registerLivewireComponents()
    {
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
            add_filter('app-settings-rules', function ($rulesSets) {
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
            add_filter('app-settings-general-rules', function ($rules_array) {
                return array_merge($rules_array, [
                    'settings.pix_pro_software_download_url' => 'nullable',
                    'settings.pix_pro_downloads' => 'nullable',
                    'settings.pix_pro_dataset_samples' => 'nullable',
                ]);
            }, 10, 1);

            // Add Columns to Licenses table (livewire)
            add_filter('dashboard.table.licenses.columns', function ($columns) {
                $data = array_merge($columns, [
                    \Rappasoft\LaravelLivewireTables\Views\Column::make('Image Limit', 'license_image_limit')
                        ->excludeFromSelectable(),
                    \Rappasoft\LaravelLivewireTables\Views\Column::make('Hardware ID', 'hardware_id')
                        ->excludeFromSelectable(),

                ]);

                if(auth()->user()->isAdmin()) {
                    $data = array_merge($data, [
                        \Rappasoft\LaravelLivewireTables\Views\Column::make('Type', 'license_subscription_type')
                        ->excludeFromSelectable(),
                    ]);
                }

                return $data;
            }, 10, 1);

            // Download License Response
            add_filter('license.download', function ($license) {
                return pix_pro_download_license_logic($license);
            }, 20, 1);

            // Set editable License data properties
            add_filter('license.get.data.editable.keys', function () {
                return [
                    'license_image_limit' => [
                        'type' => 'int',
                    ],
                    'cloud_service' => [
                        'type' => 'boolean',
                    ],
                    'offline_service' => [
                        'type' => 'boolean',
                    ],
                    'hardware_id' => [
                        'type' => 'string',
                    ],
                    'expiration_date' => [
                        'default' => 'now',
                        'type' => 'datetime',
                        'format' => 'Y-m-d H:i:s'
                    ]
                ];
            }, 20, 1);

            // Add custom core meta to Plans
            add_filter('plan.meta.data-types', function ($plan_meta) {
                return array_merge($plan_meta, [
                    'includes_cloud' => 'boolean',
                    'includes_offline' => 'boolean',
                    'number_of_images' => 'number',
                ]);
            }, 10, 1);

            // Add custom core meta to UserSubscription
            add_filter('user-subscription.meta.data-types', function ($user_subscription_meta) {
                return array_merge($user_subscription_meta, [
                    'includes_cloud' => 'boolean',
                    'includes_offline' => 'boolean',
                    'number_of_images' => 'number',
                ]);
            }, 10, 1);

            add_filter('user-subscription.meta.data-types', function ($user_subscription_meta) {
                return array_merge($user_subscription_meta, [
                    'includes_cloud' => 'boolean',
                    'includes_offline' => 'boolean',
                    'number_of_images' => 'number',
                ]);
            }, 10, 1);

            add_filter('dashboard.plan-form.meta', function ($meta) {
                return array_merge($meta, [
                    'model_core_meta.number_of_images' => 'nullable',
                    'model_core_meta.includes_cloud' => 'nullable',
                    'model_core_meta.includes_offline' => 'nullable',
                ]);
            });

            add_filter('dashboard.sidebar.menu', function ($menu) {
                $included_items = [
                    'dashboard',
                    'stripe.portal_session',
                    'plans.index',
                    'attributes.index',
                    'categories.index',
                    'orders.index',
                    'invoices.index',
                    'blog.posts.index',
                    'pages.index',
                    'crm.all_customers',
                    'my.account.settings',
                    'my.plans.management',
                    'my.orders.all',
                    'settings.staff_settings',
                    'settings.app_settings',
                    'settings.super_admin'
                ];


                /* TODO: Use this approach for overiding child themes, menu */
                foreach ($menu as $menuKey => $items) {
                    foreach ($items['items'] as $key => $item) {
                        if (isset($item['route_name'])) {
                            if (in_array($item['route_name'], $included_items)) {
                            } else {
                                unset($menu[$menuKey]['items'][$key]);
                            }
                        }
                    }
                }
                return $menu;
            }, 10, 1);

            add_filter('nova.blog.actions', function($actions) {
                return array_merge($actions, [
                    (new \WeThemes\WePixPro\App\Nova\Actions\ImportWordPressUseCases(auth()->user()))->standalone()
                ]);
            }, 10, 1);
        }

        if (function_exists('add_action')) {
            // Actions

            // Register PixPro User
            add_action('user.registered', function ($user) {
                pix_pro_register_user($user);
            }, 20, 1);

            // Create PixPro License(s) when invoice is paid!
            add_action('invoice.paid.subscription_create', function ($user_subscription, $previous_subscription, $stripe_invoice) {
                pix_pro_create_license($user_subscription, $previous_subscription, $stripe_invoice);
            }, 20, 3);

            // Create PixPro License(s) when subscription is created through Stripe
            add_action('stripe.webhook.subscriptions.created_from_stripe', function($user_subscription, $stripe_invoice) {
                // IMPORTANT: Licenses will be generated inside invoice.paid webhook, no need to do it through this hook
                // pix_pro_create_license($user_subscription, null, $stripe_invoice);
            }, 20, 2);

            // Update PixPro License
            add_action('stripe.webhook.subscriptions.updated', function ($user_subscription, $previous_subscription, $stripe_invoice, $stripe_previous_attributes) {
                pix_pro_update_license($user_subscription, $previous_subscription, $stripe_invoice, $stripe_previous_attributes);
            }, 20, 4);

            // Extend PixPro License
            add_action('invoice.paid.subscription_cycle', function ($user_subscription, $stripe_invoice) {
                pix_pro_extend_licenses($user_subscription, $stripe_invoice);
            }, 20, 2);

            // PixPro License disconnect by removing hardware_id
            add_action('license.disconnect', function ($license, $user, $form) {
                pix_pro_disconnect_license($license, $user, $form);
            }, 20, 3);

            // PixPro License removal
            add_action('license.remove', function ($license, $user, $form) {
                pix_pro_remove_license($license, $user, $form);
            }, 20, 3);


            // Update User password
            add_action('user.password.updated', function ($user, $newPassword, $oldPassword) {
                pix_pro_update_user_password($user, $newPassword, $oldPassword);
            }, 20, 3);


            // View actions
            add_action('view.dashboard.form.left.end', function ($plan) {
                if (\View::exists('frontend.partials.plan-form-custom-meta-box')) {
                    echo view('frontend.partials.plan-form-custom-meta-box', compact('plan'));
                }
            });
            add_action('view.plan-form.wire_set', function () {
                js_wire_set('model_core_meta.includes_cloud', 'model_core_meta.includes_cloud');
                js_wire_set('model_core_meta.includes_offline', 'model_core_meta.includes_offline');
            });
            
            // When new subscription is created, take the plans core_meta and add it to the subscription!
            add_action('observer.user_subscription.created', function ($user_subscription) {

            });

            add_action('view.order-received.items.end', function ($order) {
                if (\View::exists('frontend.partials.order-received-download-cta')) {
                    echo view('frontend.partials.order-received-download-cta', compact('order'));
                }
            });

            // Add Pix-Pro API Integration Form
            add_action('view.integrations.end', function () {
                if (\View::exists('frontend.partials.pix-pro-api-integration-form')) {
                    echo view('frontend.partials.pix-pro-api-integration-form');
                }
            });

            // Add Pix-Pro General Settings
            add_action('view.app-settings-form.general.end', function () {
                if (\View::exists('frontend.partials.pix-pro-general-settings')) {
                    echo view('frontend.partials.pix-pro-general-settings');
                }
            });

            // Add Pix-Pro General Settings - $wire.set inside alpine/lw form
            add_action('view.app-settings-form.general.wire_set', function () {
                js_wire_set('settings.pix_pro_downloads', 'settings.pix_pro_downloads');
                js_wire_set('settings.pix_pro_dataset_samples', 'settings.pix_pro_dataset_samples');
            });


            add_action('view.dashboard.my-downloads.end', function () {
                if (\View::exists('frontend.partials.pix-pro-software-downloads-table')) {
                    echo view('frontend.partials.pix-pro-software-downloads-table', [
                        'downloads' => collect(TenantSettings::get('pix_pro_downloads'))
                    ]);
                }
            });

            add_action('view.dashboard.plans-management.plans-table.end', function ($data) {
                if (\View::exists('frontend.partials.pix-pro-licenses-table')) {
                    echo view('frontend.partials.pix-pro-licenses-table', compact('data'));
                }
            }, 20, 1);

            // Add Columns to Licenses table (View)
            add_action('view.dashboard.row-license.columns', function ($license) {
                if (\View::exists('frontend.partials.row-license-custom-columns')) {
                    echo view('frontend.partials.row-license-custom-columns', compact('license'));
                }
            }, 20, 1);

            add_action('view.dashboard.plans.row-license.actions.dropdown.start', function ($license) {
                if (\View::exists('frontend.partials.row-license-actions')) {
                    echo view('frontend.partials.row-license-actions', compact('license'));
                }
            }, 20, 1);

            // Fetch all licenses for desired user and get the latest data about license from Pixpro DB. Update hardware_id if hardware_id is different!
            add_action('dashboard.table.licenses.mount.end', function ($user) {
                
                if ($user->hasLicenses()) {
                    foreach ($user->licenses as $license) {
                        
                        if (!empty($license) && method_exists($license, 'get_license')) {
                            // Dispatch license hardware ID update (if any)
                            $data = $license->get_license(); // gets the license from Pixpro DB

                            // If hardware_id is missing on our end or is different than hwID on Pixpro end, update it on our end
                            if (!empty($data) && $license->getData('hardware_id') !== ($data['hardware_id'] ?? null)) {
                                $license->setData('hardware_id', $data['hardware_id'] ?? null);
                                $license->saveQuietly();
                            }

                            // dispatch(function () use ($license) {

                            // });
                        }
                    }
                }
            }, 20, 1);

            // There are changes to license on WeSaaS end, so we need to update license on Pixpro END
            add_action('license.saved', function (&$new_license, $old_license) {
                if(empty($old_license)) {
                    // Insert
                    pix_pro_create_single_manual_license($new_license);
                } else {
                    // Update
                    pix_pro_update_single_license($new_license, $old_license);
                }
            }, 20, 2);

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
