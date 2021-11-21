<?php

namespace App\Http\Services;

use App\Models\Currency;
use App\Models\Product;
use Cache;
use Qirolab\Theme\Theme;
use EVS;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\View\ComponentAttributeBag;
use Session;

class EVService
{
    protected $tenantStylePath;

    public function __construct($app) {
        $tenant_css_path = public_path('themes/'.Theme::parent().'/css/'.tenant()->id.'.css');
        $default_css_path = public_path('themes/'.Theme::parent().'/css/app.css');
        $styling_url = '';

        if(file_exists($tenant_css_path)) {
            $url = asset('themes/'.Theme::parent().'/css/'.tenant()->id.'.css?ver='.filemtime($tenant_css_path));
        } else {
            $url = asset('themes/'.Theme::parent().'/css/app.css?ver='.filemtime($default_css_path));
        }

        $this->tenantStylePath = $url;
    }

    public function getThemeStyling() {
        return $this->tenantStylePath;
    }

    public function getVendorMenu(): array
    {
        return [
            [
                'label' => translate('General'),
                'items' => [
                    [
                        'label' => translate('Dashboard'),
                        'icon' => 'heroicon-o-presentation-chart-bar',
                        'route' => route('dashboard'),
                        'is_active' => areActiveRoutes(['dashboard']),
                        'roles' => [], // empty array means ALL roles - admin/seller/customer
                    ],
                    // [
                    //     'label' => translate('Schedule'),
                    //     'icon' => 'heroicon-o-calendar',
                    //     'route' => '',
                    //     'is_active' => areActiveRoutes(['']),
                    //     'roles' => [],
                    // ],


                ]
            ],
            [
                'label' => translate('Business'),
                'items' => [
                    [
                        'label' => translate('Products'),
                        'icon' => 'heroicon-o-shopping-cart',
                        'route' => route('ev-products.index'),
                        'is_active' => areActiveRoutes(['ev-products.index']),
                        'roles' => ['admin','seller'],
                    ],
                    [
                        'label' => translate('Orders'),
                        'icon' => 'heroicon-o-document-text',
                        'route' => route('orders.index'),
                        'is_active' => areActiveRoutes(['orders.index']),
                        'roles' => ['admin','seller'],
                    ],
                    [
                        'label' => translate('Leads'),
                        'icon' => 'heroicon-o-calendar',
                        'route' => route('leads.index'),
                        'is_active' => areActiveRoutes(['leads']),
                        'roles' => ['admin'],
                    ],
                    // [
                    //     'label' => translate('Events'),
                    //     'icon' => 'heroicon-o-ticket',
                    //     'route' => '',
                    //     'is_active' => areActiveRoutes(['']),
                    //     'roles' => ['admin','seller'],
                    // ],
                    // [
                    //     'label' => translate('Jobs'),
                    //     'icon' => 'heroicon-o-briefcase',
                    //     'route' => '',
                    //     'is_active' => areActiveRoutes(['']),
                    //     'roles' => ['admin','seller'],
                    // ],

                ]
            ],
            [
                'label' => translate('Marketing'),
                'items' => [
                    [
                        'label' => translate('Blog'),
                        'icon' => 'heroicon-o-newspaper',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin','seller'],
                    ],
                    [
                        'label' => translate('Website'),
                        'icon' => 'heroicon-o-qrcode',
                        'route' => route('ev.settings.domains'),
                        'is_active' => areActiveRoutes(['ev.settings.domains']),
                        'roles' => ['admin','seller'],
                    ]
                    // [
                    //     'label' => translate('Subscriptions'),
                    //     'icon' => 'heroicon-o-currency-dollar',
                    //     'route' => '',
                    //     'is_active' => areActiveRoutes(['']),
                    //     'roles' => ['admin','seller'],
                    // ],
                ]
            ],

            [
                'label' => translate('CRM'),
                'items' => [
                    [
                        'label' => translate('Messages'),
                        'icon' => 'heroicon-o-chat',
                        'route' => route('conversations.index'),
                        'is_active' => areActiveRoutes(['conversations.index', 'conversations.show']),
                        'roles' => ['admin','seller', 'customer'],
                    ],
                    [
                        'label' => translate('Customers'),
                        'icon' => 'heroicon-o-user-group',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin','seller'],
                    ],
                    [
                        'label' => translate('Reviews'),
                        'icon' => 'heroicon-o-star',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin','seller'],
                    ],
                    [
                        'label' => translate('Support'),
                        'icon' => 'heroicon-o-support',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin','seller'],
                    ],
                ]
            ],
            [
                'label' => translate('Customer zone'),
                'items' => [
                    [
                        'label' => translate('My Purchases'),
                        'icon' => 'heroicon-o-calendar',
                        'route' => route('purchase_history.index'),
                        'is_active' => areActiveRoutes(['purchase_history']),
                        'roles' => ['customer'],
                    ]
                ]
            ],
            [
                'label' => translate('Settings'),
                'items' => [
                    [
                        'label' => translate('Design settings'),
                        'icon' => 'heroicon-o-cog',
                        'route' => route('ev.settings.design'),
                        'is_active' => areActiveRoutes(['ev.settings.design']),

                    ],
                    [
                        'label' => translate('Account settings'),
                        'icon' => 'heroicon-o-cog',
                        'route' => route('profile'),
                        'is_active' => areActiveRoutes(['profile']),

                    ],
                    // [
                    //     'label' => translate('Company settings'),
                    //     'icon' => 'heroicon-o-office-building',
                    //     'route' => route('attributes'),
                    //     'is_active' => areActiveRoutes(['attributes']),
                    //     'roles' => ['admin','seller'],
                    // ],
                    // [
                    //     'label' => translate('Shop settings'),
                    //     'icon' => 'heroicon-o-office-building',
                    //     'route' => route('shops.index'),
                    //     'is_active' => areActiveRoutes(['shops']),
                    //     'roles' => ['admin','seller'],
                    // ],
                    // [
                    //     'label' => translate('Shipping settings'),
                    //     'icon' => 'heroicon-o-truck',
                    //     'route' => '',
                    //     'is_active' => areActiveRoutes(['']),
                    //     'roles' => ['admin','seller'],
                    // ],
                    // [
                    //     'label' => translate('Tax settings'),
                    //     'icon' => 'heroicon-o-receipt-tax',
                    //     'route' => '',
                    //     'is_active' => areActiveRoutes(['']),
                    //     'roles' => ['admin','seller'],
                    // ],
                ]
            ],
            [
                'label' => translate('Other'),
                'items' => [
                    // [
                    //     'label' => translate('Plans & billing'),
                    //     'icon' => 'heroicon-o-credit-card',
                    //     'route' => '',
                    //     'is_active' => areActiveRoutes(['']),
                    //     'roles' => ['admin','seller'],
                    // ],
                    // [
                    //     'label' => translate('Uploaded media'),
                    //     'icon' => 'heroicon-o-upload',
                    //     'route' => '',
                    //     'is_active' => areActiveRoutes(['']),
                    //     'roles' => ['admin','seller'],
                    // ],
                ]
            ],
            [
                'label' => 'hr',
                'items' => [
                    [
                        'label' => translate('Log out'),
                        'icon' => 'heroicon-o-logout',
                        'route' => route('user.logout'),
                        'is_active' => false,
                    ],
                ]
            ]
        ];
    }

    public function getMappedCategories() {
        /*$categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();*/

        $categories = Categories::getAll();

        $mapped = [];

        $recursion = function($child_category) use (&$recursion, &$mapped) {
            $value = str_repeat('--', $child_category['level']);

            $mapped[$child_category['id']] = $value." ".$child_category['name'];

            if(isset($child_category['children'])) {
                foreach ($child_category['children'] as $childCategory) {
                    $recursion($childCategory);
                }
            }
        };

        if($categories->isNotEmpty()) {
            foreach($categories as $category) {
                $mapped[$category['id']] = $category['name'];

                if($category['children']) {
                    foreach($category['children'] as $childCategory) {
                        $recursion($childCategory);
                    }
                }
            }
        }

        return $mapped;
    }

    public function getMappedBrands() {
        $brands = Brand::all();
        $mapped = [];

        if($brands->isNotEmpty()) {
            foreach (\App\Models\Brand::all() as $brand) {
                $mapped[$brand->id] = $brand->getTranslation('name');
            }
        }

        return $mapped;
    }

    public function getMappedUnits() {
        return [
            'pc' => 'Pc',
            'kg' => 'kg',
            'l' => 'litre',
            'oz' => 'oz'
        ];
    }

    public function getMappedVideoProviders() {
        return [
            'youtube' => 'Youtube',
            'vimeo' => 'Vimeo',
            'dailymotion' => 'Dailymotion',
        ];
    }

    public function getMappedStockVisibilityOptions() {
        return [
            'quantity' => translate('Show stock quantity'),
            'text' => translate('Show stock with text only'),
            'hide' => translate('Hide stock'),
        ];
    }

    public function getMappedShippingTypePerProduct() {
        return [
            'free' => translate('Free shipping'),
            'flat_rate' => translate('Flat rate'),
            'product_wise' => translate('Product wise shipping'),
        ];
    }



    public function generateAllVariations($attributes) {
        $result = [[]];
        $all_att_values = $attributes->pluck('attribute_values');

        foreach ($all_att_values as $property => $property_values) {
            $property_values = array_values(array_filter($property_values, function($v, $k) {
                return $v['selected'] === true;
            }, ARRAY_FILTER_USE_BOTH));

            $tmp = [];
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, [$property => $property_value]);
                }
            }
            $result = $tmp;
        }

        return $result;
    }
}
