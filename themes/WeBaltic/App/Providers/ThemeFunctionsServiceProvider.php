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
use Livewire;
use TenantSettings;
use Log;

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
                return array_merge($rules_array, [
                    'settings.pix_pro_software_download_url' => 'nullable',
                    'settings.pix_pro_downloads' => 'nullable',
                    'settings.pix_pro_dataset_samples' => 'nullable',
                ]);
            }, 10, 1);
        }

        add_action('order.change-status', function($order) {
            try {
                mkdir( storage_path() . '/app/public/');
            } catch (\Exception $e) {
            }

            try {
                mkdir( storage_path() . '/app/public/documents/');
            } catch (\Exception $e) {

            }

            try {
                mkdir( storage_path() . '/app/public/documents/' . $order->id);
            } catch (\Exception $e) {

            }

            if($order->status == 1) {
                $this->generate_contract($order);
            } else if($order->status == 2) {

            }
            /* Generate those always
            TODO: Make conditional logic based on status change
            */
            $this->generate_contract($order);
            $this->generate_certificate($order);
            $this->generate_transportation_card($order);
        });
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



    public function generate_contract($order) {
        // Get order attributes and generate the document
        $data = ['order' => $order];
        $pdf = Pdf::loadView('documents_templates.contract', $data );

        $pdf->save(storage_path() . '/app/public/documents/'. $order->id . '/contract-'. $order->id .'.pdf');
        /* TODO: Implement attaching a document */
        // $order->attachDocument($something);

        return redirect()->back();
    }

    public function generate_transportation_card($order) {
        // Get order attributes and generate the document
        $data = ['order' => $order];
        $pdf = Pdf::loadView('documents_templates.transportation_card', $data );
    //    $myFile =  Storage::disk('public')->put('/documents/'. $order->id, $pdf);
        // dd($myFile);
        $pdf->save(storage_path() . '/app/public/documents/'. $order->id . '/transportation-card-'. $order->id .'.pdf');
        /* TODO: Implement attaching a document */
        // $order->attachDocument($something);

        return redirect()->back();
    }

    public function generate_certificate($order) {
        // Get order attributes and generate the document
        $data = ['order' => $order];
        $pdf = Pdf::loadView('documents_templates.certificate', $data );

        $pdf->save(storage_path() . '/app/public/documents/' . $order->id . '/certificate-'. $order->id .'.pdf');
        /* TODO: Implement attaching a document */
        // $order->attachDocument($something);

        return redirect()->back();
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
