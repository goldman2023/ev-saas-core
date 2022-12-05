<?php

namespace WeThemes\WeBaltic\App\Providers;

// Because this file service provider is loaded after tenant is initated and has no namespace, it cannot use Aliases from `app.php`, like: use Log or use File; Instead full namespaces must be used!

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
                    'orders.index',
                    'attributes.index',
                    'categories.index',
                    'products.index',
                    'tasks.index',
                    'file-manager.index',
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
                return array_merge($rules_array, [
                    'settings.pix_pro_software_download_url' => 'nullable',
                    'settings.pix_pro_downloads' => 'nullable',
                    'settings.pix_pro_dataset_samples' => 'nullable',
                ]);
            }, 10, 1);
        }

        if (function_exists('add_action')) {
            add_action('order.change-status', function($order) {
                $this->generateOrderDocument($order, 'documents_templates.contract', 'contract', translate('Contract for Order #').$order->id);
                $this->generateOrderDocument($order, 'documents_templates.proposal', 'proposal', translate('Proposal for Order #').$order->id);
                $this->generateOrderDocument($order, 'documents_templates.certificate', 'certificate', translate('Certificate for Order #').$order->id);
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

    public function generateOrderDocument(&$order, $template, $upload_tag, $display_name = '') {
        // Get order and generate the document
        $data = ['order' => $order];
        $pdf = Pdf::loadView($template, $data);

        // upload generated pdf as file in storage and create Upload and Relationship to $order
        MediaService::uploadAndStore(
            model: $order,
            contents: $pdf->output(),
            path: 'orders/'.$order->id,
            name: $upload_tag.'-'.$order->id,
            extension: 'pdf',
            property_name: 'documents',
            with_hash: false,
            file_display_name: $display_name,
            upload_tag: $upload_tag,
        );

        return true;
    }

    public function generate_vin_code($order) {
        $vin_code = "";
        $item = $order->get_primary_order_item();


    }

    public function nice_attribute_names() {
        $data = [
            'width' => 9,
            'height' => 10
        ];
    }
}
