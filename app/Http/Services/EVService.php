<?php

namespace App\Http\Services;

use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductVariation;
use Cache;
use Illuminate\Support\Collection;
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
        $tenant_css_path = public_path('themes/'.Theme::parent().'/css/'.tenant('id').'.css');
        $default_css_path = public_path('themes/'.Theme::parent().'/css/app.css');
        $styling_url = '';

        if(file_exists($tenant_css_path)) {
            $url = asset('themes/'.Theme::parent().'/css/'.tenant('id').'.css?ver='.filemtime($tenant_css_path));

        } else {
            $url = asset('themes/' . Theme::parent() . '/css/app.css?ver=' . filemtime($default_css_path));
        }

        // TODO: Think of a way to implement better vendor design pattern!
        $this->tenantStylePath = asset('themes/' . Theme::parent() . '/css/app.css?ver=' . filemtime($default_css_path)); //$url;
        $this->tenantStylePath = $url;
    }

    public function getThemeStyling()
    {
        return $this->tenantStylePath;
    }

    public function getVendorMenuByRole($role = 'customer')
    {
        $vendorMenu = $this->getVendorMenu();

        $vendorMenu = collect($vendorMenu)->map(fn($item) => collect($item['items'])->filter(function ($child) use ($role, $item) {
            if(isset($child['roles'])) {
                return in_array($role, $child['roles']);

            } else {
                return true;
            }
        })->count() > 0 ? $item : null)->filter()->toArray();

        return $vendorMenu;

        /*  foreach($vendorMenu as $item) {
            foreach($item['items'] as $key => $subItem) {
                if(in_array($role, $subItem['roles'])) {

                } else {
                    unset($subItem[$key]);  // $arr = ['b', 'c']
                }
            }
        } */
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
                        'roles' => ['admin', 'seller', 'customer'], // empty array means ALL roles - admin/seller/customer
                    ],
                    [
                        'label' => translate('Chat'),
                        'icon' => 'heroicon-o-chat',
                        'route' => route('chat.index'),
                        'is_active' => areActiveRoutes(['chat']),
                        'roles' => [], // empty array means ALL roles - admin/seller/customer
                    ],
                    [
                        'label' => translate('Schedule'),
                        'icon' => 'heroicon-o-calendar',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => [],
                    ],
                    [
                        'label' => translate('Activity'),
                        'icon' => 'heroicon-o-status-online',
                        'route' => route('activity.index'),
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin'],
                    ],


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
                        'roles' => ['admin', 'seller'],
                    ],
                    [
                        'label' => translate('Courses'),
                        'icon' => 'heroicon-o-academic-cap',
                        'route' => route('courses.index'),
                        'is_active' => areActiveRoutes(['courses.index']),
                        'roles' => ['admin', 'seller'],
                    ],
                    [
                        'label' => translate('Orders'),
                        'icon' => 'heroicon-o-document-text',
                        'route' => route('orders.index'),
                        'is_active' => areActiveRoutes(['orders.index']),
                        'roles' => ['admin', 'seller'],
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
                        'roles' => ['admin', 'seller'],
                    ],
                    [
                        'label' => translate('Website'),
                        'icon' => 'heroicon-o-qrcode',
                        'route' => route('ev.settings.domains'),
                        'is_active' => areActiveRoutes(['ev.settings.domains']),
                        'roles' => ['admin', 'seller'],
                    ],
                    [
                        'label' => translate('Tutorials'),
                        'icon' => 'heroicon-o-academic-cap',
                        'route' => route('ev-tutorials.index'),
                        'is_active' => areActiveRoutes(['ev.settings.domains']),
                        'roles' => ['admin', 'seller'],
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
                        'roles' => ['admin', 'seller', 'customer'],
                    ],
                    [
                        'label' => translate('Customers'),
                        'icon' => 'heroicon-o-user-group',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin', 'seller'],
                    ],
                    [
                        'label' => translate('Reviews'),
                        'icon' => 'heroicon-o-star',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin', 'seller'],
                    ],
                    [
                        'label' => translate('Support'),
                        'icon' => 'heroicon-o-support',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin', 'seller',  'guest'],
                    ],
                ]
            ],
            [
                'label' => translate('Customer zone'),
                'items' => [
                    [
                        'label' => translate('Account'),
                        'icon' => 'heroicon-o-user',
                        'route' => route('my.account.settings'),
                        'is_active' => areActiveRoutes(['my.account.settings']),
                        'roles' => ['all'],
                    ],
                    [
                        'label' => translate('My Purchases'),
                        'icon' => 'heroicon-o-document-text',
                        'route' => route('my.purchases.all'),
                        'is_active' => areActiveRoutes(['my.purchases.all']),
                        //'roles' => ['admin','seller', 'customer'],
                    ],
                    [
                        'label' => translate('My Wishlist'),
                        'icon' => 'heroicon-o-heart',
                        'route' => route('wishlist'),
                        'is_active' => areActiveRoutes(['wishlist']),
                        'roles' => ['customer',  'guest'],
                    ],
                    [
                        'label' => translate('My Viewed Items'),
                        'icon' => 'heroicon-o-eye',
                        'route' => route('wishlist.views'),
                        'is_active' => areActiveRoutes(['wishlist.views']),
                        'roles' => ['customer', 'admin', 'seller', 'guest'],
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
                        'roles' => ['admin', 'seller'],
                    ],
                    [
                        'label' => translate('Account settings'),
                        'icon' => 'heroicon-o-cog',
                        'route' => route('profile'),
                        'is_active' => areActiveRoutes(['profile']),
                        'roles' => ['admin', 'seller'],
                    ],
                    [
                        'label' => translate('Payment settings'),
                        'icon' => 'heroicon-o-cash',
                        'route' => route('ev.settings.payment_methods'),
                        'is_active' => areActiveRoutes(['ev.settings.payment_methods']),
                        'roles' => ['admin', 'seller'],
                    ],
                     [
                         'label' => translate('Payment settings'),
                         'icon' => 'heroicon-o-cash',
                         'route' => route('ev.settings.payment_methods'),
                         'is_active' => areActiveRoutes(['ev.settings.payment_methods']),
                         'roles' => ['admin','seller'],
                     ],
                    [
                        'label' => translate('Users settings'),
                        'icon' => 'heroicon-s-user-group',
                        'route' => route('ev.settings.users_settings'),
                        'is_active' => areActiveRoutes(['ev.settings.users_settings']),
                        'roles' => ['admin','seller'],
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
                        'roles' => ['admin', 'seller'],

                    ],
                ]
            ]
        ];
    }

    public function getMappedCategories()
    {
        /*$categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();*/

        $categories = Categories::getAll();

        $mapped = [];

        $recursion = function ($child_category) use (&$recursion, &$mapped) {
            $value = str_repeat('--', $child_category['level']);

            $mapped[$child_category['id']] = $value . " " . $child_category['name'];

            if (isset($child_category['children'])) {
                foreach ($child_category['children'] as $childCategory) {
                    $recursion($childCategory);
                }
            }
        };

        if ($categories->isNotEmpty()) {
            foreach ($categories as $category) {
                $mapped[$category['id']] = $category['name'];

                if ($category['children']) {
                    foreach ($category['children'] as $childCategory) {
                        $recursion($childCategory);
                    }
                }
            }
        }

        return $mapped;
    }

    public function getMappedBrands()
    {
        $brands = Brand::all();
        $mapped = [];

        if ($brands->isNotEmpty()) {
            foreach (\App\Models\Brand::all() as $brand) {
                $mapped[$brand->id] = $brand->getTranslation('name');
            }
        }

        return $mapped;
    }

    public function getMappedUnits()
    {
        return [
            'pc' => 'Pc',
            'kg' => 'kg',
            'l' => 'litre',
            'oz' => 'oz'
        ];
    }

    public function getMappedVideoProviders()
    {
        return [
            'youtube' => 'Youtube',
            'vimeo' => 'Vimeo',
            'dailymotion' => 'Dailymotion',
        ];
    }

    public function getMappedStockVisibilityOptions()
    {
        return [
            'quantity' => translate('Show stock quantity'),
            'text' => translate('Show stock with text only'),
            'hide' => translate('Hide stock'),
        ];
    }

    public function getMappedShippingTypePerProduct()
    {
        return [
            'free' => translate('Free shipping'),
            'flat_rate' => translate('Flat rate'),
            'product_wise' => translate('Product wise shipping'),
        ];
    }
}
