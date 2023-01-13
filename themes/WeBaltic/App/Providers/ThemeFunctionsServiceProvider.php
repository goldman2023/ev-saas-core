<?php

namespace WeThemes\WeBaltic\App\Providers;

use App\Models\CoreMeta;
use App\Models\Order;
use App\Models\Upload;
use App\Providers\WeThemeFunctionsServiceProvider;
use App\Support\Hooks;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Livewire\Livewire;
use App\Http\Services\TenantSettings;
use Illuminate\Support\Facades\Log;
use MediaService;

class ThemeFunctionsServiceProvider extends WeThemeFunctionsServiceProvider
{
    protected function getTenantAppSettings(): array
    {
        return [
            'wmi_code' => 'string',
            'wmi_code_2' => 'string',
            'factory_location' => 'string',
        ];
    }

    public function tenantCustomOptions() {
        $options = [
            'make' => 'TERO',
            'type' => 'TERO1',
            'variant' => 'S',
            'commercial_name' => 'Spec',
            'vehicle_category' => 'O1',
            'bodywork' => 'DC99',
            'bodywork' => 'DC99',
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

    protected function registerLivewireComponents() {
        // Tables and Panels
        Livewire::component('dashboard.tables.tabs.tabs-header', \WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tables\Tabs\TabsHeader::class);
        Livewire::component('dashboard.tables.orders-table', \WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tables\OrdersTable::class);
        Livewire::component('dashboard.tables.tasks-table', \WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tables\TasksTable::class);
        Livewire::component('dashboard.tables.action-panels.orders-action-panel', \WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tables\ActionPanels\OrdersActionPanel::class);
        Livewire::component('dashboard.tables.action-panels.tasks-action-panel', \WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tables\ActionPanels\TasksActionPanel::class);
        
        // Orders
        Livewire::component('dashboard.orders.order-queues', \WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Orders\OrderQueues::class);
        Livewire::component('dashboard.tasks.latest-printing-tasks-batch', \WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tasks\LatestPrintingTasksBatch::class);
    }

    /**
     * Bootstrap the theme function services.
     */
    public function boot()
    {
        parent::boot();

        if (function_exists('add_filter')) {
            // Filter

            add_filter('dashboard.sidebar.menu', function ($menu) {
                $included_items = [
                    'dashboard',
                    'attributes.index',
                    'categories.index',
                    'products.index',
                    'tasks.index',
                    'file-manager.index',
                    'orders.index',
                    'invoices.index',
                    'blog.posts.index',
                    'pages.index',
                    'sections.index',
                    'crm.all_customers',
                    'my.account.settings',
                    'my.orders.all',
                    'settings.staff_settings',
                    'settings.app_settings',
                    'settings.super_admin',
                    'we-edit.index'
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

            // Add baltic general rules
            add_filter('app-settings-general-rules', function ($rules_array) {
                return array_merge($rules_array, []);
            }, 10, 1);

            // TODO: Pack all WEF data types definition to single-use Trait orsomething like that
            // Upload: WEF data types
            add_filter('upload.wef.data-types', function ($data_types) {
                return array_merge($data_types, [
                    'batch_id' => 'string',
                    'batch_items' => 'array',
                ]);
            }, 10, 1);

            // Order: WEF data types
            add_filter('order.wef.data-types', function ($data_types) {
                return array_merge($data_types, [
                    'cycle_status' => 'int',
                ]);
            }, 10, 1);
        }

        if (function_exists('add_action')) {
            add_action('order.change-status', function($order) {
                // $this->generateOrderDocument($order, 'documents-templates.contract', 'contract', translate('Contract for Order #').$order->id);
                // $this->generateOrderDocument($order, 'documents-templates.proposal', 'proposal', translate('Proposal for Order #').$order->id);
                // $this->generateOrderDocument($order, 'documents-templates.certificate', 'certificate', translate('Certificate for Order #').$order->id);
            });

            // View actions
            add_action('view.dashboard.we-media-editor.other-information', function ($upload, $subject) {
                if (\View::exists('frontend.partials.we-media-editor-other-information')) {
                    echo view('frontend.partials.we-media-editor-other-information', compact('upload', 'subject'));
                }
            }, 10, 2);
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
    
    public function generate_vin_code($order) {

    }

    public function nice_attribute_names() {
        $data = [
            'width' => 9,
            'height' => 10
        ];
    }
}
