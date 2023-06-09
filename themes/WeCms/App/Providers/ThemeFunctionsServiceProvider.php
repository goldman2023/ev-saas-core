<?php

namespace WeThemes\WeCms\App\Providers;

use App\Providers\WeThemeFunctionsServiceProvider;
use App\Support\Hooks;
use Illuminate\Support\Facades\View;
use Livewire\Livewire;
use App\Http\Services\TenantSettings;
use Illuminate\Support\Facades\Log;

class ThemeFunctionsServiceProvider extends WeThemeFunctionsServiceProvider
{

    protected function setNotificationsFilters() {
        // add_filter('notifications.user-welcome.subject', fn($subject) => translate('Hello from Nium'));
    }


    protected function getTenantAppSettings(): array
    {
        return [
            /* Example of adding TenantAppSettings */
            // 'key' => 'string',
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











            add_filter('dashboard.sidebar.menu', function ($menu) {
                $included_items = [
                    'dashboard',
                    'categories.index',
                    'blog.posts.index',
                    'file-manager.index',
                    'pages.index',
                    'crm.all_customers',
                    'sections.index',
                    'my.account.settings',
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
                try {
                    pix_pro_register_user($user);
                } catch(\Exception $e) {
                    Log::error('Error while creating a user on pix-pro end: '.$e->getMessage());
                }
            }, 20, 1);

            // Create PixPro License(s) when invoice is paid!
            add_action('invoice.paid.subscription_create', function ($user_subscription, $previous_subscription, $stripe_invoice) {
                pix_pro_create_license($user_subscription, $previous_subscription, $stripe_invoice);
            }, 20, 3);

            // Create PixPro License(s) when subscription is created through Stripe
            // add_action('stripe.webhook.subscriptions.created_from_stripe', function($user_subscription, $stripe_invoice) {
            //     // IMPORTANT: Licenses will be generated inside invoice.paid webhook (`invoice.paid.subscription_create` hook), no need to do it through this hook
            //     // pix_pro_create_license($user_subscription, null, $stripe_invoice);
            // }, 20, 2);

            // Update PixPro License
            add_action('stripe.webhook.subscriptions.updated', function ($user_subscription, $previous_subscription, $stripe_invoice, $stripe_previous_attributes) {
                pix_pro_update_license($user_subscription, $previous_subscription, $stripe_invoice, $stripe_previous_attributes);
            }, 20, 4);

            // Extend PixPro License
            add_action('invoice.paid.subscription_cycle', function ($user_subscription, $stripe_invoice) {
                pix_pro_extend_licenses($user_subscription, $stripe_invoice);
            }, 20, 2);

            // Subscription cycle payment_failed
            add_action('invoice.payment_failed.subscription_cycle', function ($user_subscription, $stripe_invoice) {
                // When subscription payment fails due to any reason, deactivate license(s)
                if($user_subscription->licenses->isNotEmpty()) {
                    foreach($user_subscription->licenses as $license) {
                        pix_pro_disconnect_license($license, $user_subscription->user, null);
                    }
                }
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
                js_wire_set('wef.includes_cloud', 'wef.includes_cloud');
                js_wire_set('wef.includes_offline', 'wef.includes_offline');
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
                            try {
                                // Dispatch license hardware ID update (if any)
                                $data = $license->get_license(); // gets the license from Pixpro DB

                                // If hardware_id is missing on our end or is different than hwID on Pixpro end, update it on our end
                                if (!empty($data) && $license->getData('hardware_id') !== ($data['hardware_id'] ?? null)) {
                                    $license->setData('hardware_id', $data['hardware_id'] ?? null);
                                    $license->saveQuietly();
                                }
                            } catch(\Exception $e) {
                                Log::error($e->getMessage());
                            }
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
