<?php

namespace WeThemes\WeBaltic\App\Providers;

use MediaService;
use App\Models\Order;
use App\Models\Upload;
use App\Support\Hooks;
use Livewire\Livewire;
use App\Models\CoreMeta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use App\Http\Services\TenantSettings;
use Illuminate\Support\Facades\Storage;
use App\Providers\WeThemeFunctionsServiceProvider;
use WeThemes\WeBaltic\App\Enums\OrderCycleStatusEnum;

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
        Livewire::component('dashboard.tables.recent-invoices-widget-table', \WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tables\RecentInvoicesWidgetTable::class);
        Livewire::component('dashboard.tables.action-panels.orders-action-panel', \WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tables\ActionPanels\OrdersActionPanel::class);
        Livewire::component('dashboard.tables.action-panels.tasks-action-panel', \WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tables\ActionPanels\TasksActionPanel::class);

        // Orders
        Livewire::component('dashboard.orders.order-queues', \WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Orders\OrderQueues::class);
        Livewire::component('dashboard.tasks.latest-printing-tasks-batch', \WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tasks\LatestPrintingTasksBatch::class);
        Livewire::component('dashboard.tasks.latest-delivery-task', \WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tasks\LatestDeliveryTask::class);
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
                    'my.invoices.all',
                    'settings.staff_settings',
                    'settings.app_settings',
                    'settings.super_admin',
                    'we-edit.index',
                    'wishlist.index'
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

            // TODO: Pack all WEF data types definition to single-use Trait or something like that
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
                    'is_manufacturing_order' => 'boolean',
                ]);
            }, 10, 1);

            // OrderForm: Add wef rules
            add_filter('dashboard.order-form.rules.wef', function ($meta) {
                return array_merge($meta, [
                    'wef.cycle_status' => 'required',
                    'wef.is_manufacturing_order' => 'required',
                ]);
            });

            // AttributeValue: WEF data types
            add_filter('attribute_values.wef.data-types', function ($data_types) {
                return array_merge($data_types, [
                    'max_grazulo_svoris' => 'string',
                    'bendroji_mase' => 'string',
                    'variantas' => 'string',
                    'kebulo_kodas' => 'string',
                    'vin_kodo_raide' => 'string',
                    'modifikacija' => 'string',
                ]);
            }, 10, 1);

            // Dynamic Livewire Actions - TODO: // Move this to dedicated file and include it via calling a function from WeThemeFunctionsServiceProvider - it needs to be standardized
            add_filter('livewire.forms.dynamic-actions.list', function () {
                return define_livewire_dynamic_actions();
            });
        }

        if (function_exists('add_action')) {
            add_action('request-quote.insert', function (&$order) {
                $order->setWEF('cycle_status', 0); // 0 is 'request'
                $order->setWEF('cycle_step_date_request', time());

                baltic_generate_order_document(
                    order: $order,
                    template: 'documents-templates.proposal',
                    upload_tag: 'proposal',
                    display_name: translate('Proposal for Order #').$order->id,
                    data: ['user' => $order->user]
                );
            }, 10, 1);

            add_action('order.insert', function (&$order) {
                // Logic for Order insert is different for Regular order and Manufacturing order
                if($order->getWEF('is_manufacturing_order', true, null)) {
                    $order->setWEF('cycle_status', 2); // 0 is 'approved'
                    $order->setWEF('cycle_step_date_approved', time());

                    // TODO: Generate docs for manufacturing order: certificate, manufacturing order etc.


                } else {
                    $order->setWEF('cycle_status', 0); // 0 is 'request'
                    $order->setWEF('cycle_step_date_request', time());

                    baltic_generate_order_document(
                        order: $order,
                        template: 'documents-templates.proposal',
                        upload_tag: 'proposal',
                        display_name: translate('Proposal for Order #').$order->id,
                        data: ['user' => $order->user]
                    );
                }

            }, 10, 1);

            // In standard checkout flow, cycle_status is approved and we should generate certificate, proposal and contract
            add_action('checkout.process', function (&$order, &$invoice) {
                $order->setWEF('cycle_status', 2); // 2 is 'approved'
                $order->setWEF('cycle_step_date_request', time());
                $order->setWEF('cycle_step_date_contract', time());
                $order->setWEF('cycle_step_date_approved', time());

                // Generate certificate
                baltic_generate_order_document(
                    order: $order,
                    template:'documents-templates.certificate',
                    upload_tag: 'certificate',
                    display_name: translate('Certificate for Order #').$order->id
                );

                // Generate proposal
                baltic_generate_order_document(
                    order: $order,
                    template: 'documents-templates.proposal',
                    upload_tag: 'proposal',
                    display_name: translate('Proposal for Order #').$order->id,
                    data: ['user' => $order->user]
                );

                // Generate Contract
                baltic_generate_order_document(
                    order: $order,
                    template: 'documents-templates.contract',
                    upload_tag: 'contract',
                    display_name: translate('Contract for Order #').$order->id,
                );
            }, 10, 2);

            add_action('view.order-form.wire_set', function () {
                js_wire_set('wef.cycle_status', 'wef.cycle_status');
                js_wire_set('wef.is_manufacturing_order', 'wef.is_manufacturing_order');
            });

            // View actions
            add_action('view.dashboard.we-media-editor.other-information', function ($upload, $subject) {
                if (\View::exists('frontend.partials.we-media-editor-other-information')) {
                    echo view('frontend.partials.we-media-editor-other-information', compact('upload', 'subject'));
                }
            }, 10, 2);

            add_action('view.dashboard.we-media-editor.custom-actions', function ($form) {
                if (\View::exists('frontend.partials.we-media-editor-custom-actions')) {
                    echo view('frontend.partials.we-media-editor-custom-actions', compact('form'));
                }
            }, 10, 2);

            add_action('view.dashboard.form.attribute-value-modal.wefs', function ($attribute) {
                if (\View::exists('frontend.partials.attribute-value-modal-wefs')) {
                    echo view('frontend.partials.attribute-value-modal-wefs', compact('attribute'));
                }
            }, 10, 2);


            // Add Order Cycle Status metabox at the TOP RIGHT side of the order-form
            add_action('view.dashboard.form.order.right.start', function ($order) {
                if (\View::exists('frontend.partials.orders.order-form-custom-meta-box')) {
                    $current_cycle_status_label = OrderCycleStatusEnum::labels()[$order->getWEF('cycle_status') ?? 0] ?? OrderCycleStatusEnum::labels()[0];
                    $current_cycle_status_value = is_string(OrderCycleStatusEnum::values()[$order->getWEF('cycle_status')] ?? -1) ? $order->getWEF('cycle_status') : 0;
                    $current_cycle_status_date = $order->getWEF('cycle_step_date_'.(OrderCycleStatusEnum::values()[$order->getWEF('cycle_status')] ?? -1), false, 'int') ?? ($order->created_at?->timestamp ?? null);

                    $default_cycle_status_value = 0;

                    if($current_cycle_status_value === count(OrderCycleStatusEnum::values()) - 1) {
                        // Last step
                        $next_cycle_status_label = null;
                    } else if($current_cycle_status_value + 1 >= 1 && $current_cycle_status_value !== count(OrderCycleStatusEnum::values()) - 1) {
                        // Between 0 and count() - 1
                        $next_cycle_status_label = OrderCycleStatusEnum::labels()[($order->getWEF('cycle_status') ?? 0) + 1];
                    }

                    echo view('frontend.partials.orders.order-form-custom-meta-box',
                        compact('order', 'current_cycle_status_label', 'current_cycle_status_value', 'default_cycle_status_value', 'next_cycle_status_label', 'current_cycle_status_date'));
                }
            });

            add_action('view.dashboard.form.order.actions-box.end', function(&$form) {
                if (\View::exists('frontend.partials.orders.order-form-actions')) {
                    echo view('frontend.partials.orders.order-form-actions', compact('form'));
                }
            }, 10, 2);

            add_action('view.dashboard.form.order.generate-invoice-btn', function($order, $html) {
                if(!empty($order->id) && $order->invoices->isEmpty() &&
                    ($order->getWEF('cycle_status') === array_flip(OrderCycleStatusEnum::values())['approved'] ?? false) &&
                    !$order->getWEF('is_manufacturing_order', false, false)) {
                    echo $html;
                } else {
                    echo ' ';
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

    protected function setNotificationsFilters() {
        add_filter('notifications.user-welcome.subject', fn($subject) => translate('Welcome to Tero.lt - Your One-Stop Shop for Quality Truck Trailers!'));
    }

    public function nice_attribute_names() {
        $data = [
            'width' => 9,
            'height' => 10
        ];
    }
}
