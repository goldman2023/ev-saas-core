<?php

namespace App\Http\Services;

use App\Facades\MyShop;
use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\User;
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

    public function __construct($app)
    {
        $tenant_css_path = public_path('themes/' . Theme::parent() . '/css/' . tenant('id') . '.css');
        $default_css_path = public_path('themes/' . Theme::parent() . '/css/app.css');
        $styling_url = '';

        if (file_exists($tenant_css_path)) {
            $url = asset('themes/' . Theme::parent() . '/css/' . tenant('id') . '.css?ver=' . filemtime($tenant_css_path));
        } else {
            try {
                $url = asset('themes/' . Theme::parent() . '/css/app.css?ver=' . filemtime($default_css_path));
            } catch (\Exception $e) {
            }
        }

        try {
            // TODO: Think of a way to implement better vendor design pattern!
            $this->tenantStylePath = asset('themes/' . Theme::parent() . '/css/app.css?ver=' . filemtime($default_css_path)); //$url;
            $this->tenantStylePath = asset('themes/' . Theme::parent() . '/css/app.css?ver=' . filemtime($default_css_path));
        } catch (\Exception $e) {
        }
    }

    public function getThemeStyling()
    {
        return $this->tenantStylePath;
    }

    public function getDashboardMenuByRole($role = 'customer')
    {
        return collect($this->getDashboardMenuTemplate())->map(fn ($item) => collect($item['items'])->filter(function ($child) use ($role, $item) {
            if (isset($child['user_types'])) {
                return in_array($role, $child['user_types']);
            } else {
                return true;
            }
        })->count() > 0 ? $item : null)->filter()->toArray();
    }

    public function getDashboardMenu()
    {
        return collect($this->getDashboardMenuTemplate())->map(function ($group) {
            $group['items'] = collect($group['items'])->filter(function ($child) use ($group) {
                return \Permissions::canAccess($child['user_types'], $child['permissions'], false);
            })->toArray();
            return  $group;
        })->filter(fn ($group) => !empty($group['items']))->toArray();
    }

    protected function getDashboardMenuTemplate(): array
    {
        // In order to show/hide certain items based on user type and permissions, you need to define user_types and permissions for each item
        return [
            [
                'label' => translate('General'),
                'items' => [
                    [
                        'label' => translate('Dashboard'),
                        'icon' => 'heroicon-o-presentation-chart-bar',
                        'route' => route('dashboard'),
                        'is_active' => areActiveRoutes(['dashboard']),
                        'user_types' => User::$user_types,
                        'permissions' => [] // always show, independent of permissions
                    ],
                    [
                        'label' => translate('Chat'),
                        'icon' => 'heroicon-o-chat',
                        'route' => route('chat.index'),
                        'is_active' => areActiveRoutes(['chat']),
                        'user_types' => User::$user_types,
                        'permissions' => []
                    ],
                ]
            ],
            [
                'label' => translate('Business'),
                'items' => [
                    [
                        'label' => translate('Products'),
                        'icon' => 'heroicon-o-shopping-cart',
                        'route' => route('products.index'),
                        'is_active' => areActiveRoutes(['products.index']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => ['all_products', 'browse_products'],
                        'children' => [
                            [
                                'label' => translate('All Products'),
                                'icon' => 'heroicon-o-archive',
                                'route' => route('products.index'),
                                'is_active' => areActiveRoutes(['products.index']),
                                'user_types' => User::$non_customer_user_types,
                                'permissions' => ['browse_products']
                            ],
                            [
                                'label' => translate('Attributes'),
                                'icon' => 'heroicon-o-view-list',
                                'route' => route('attributes.index', base64_encode(Product::class)),
                                'is_active' => areActiveRoutes(['attributes.index']),
                                'user_types' => User::$non_customer_user_types,
                                'permissions' => ['view_product_attributes']
                            ],
                        ]
                    ],
                    [
                        'label' => translate('Plans'),
                        'icon' => 'heroicon-o-document',
                        'route' => route('plans.index'),
                        'is_active' => areActiveRoutes(['plans.index']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => ['all_plans', 'browse_plans']
                    ],
                    [
                        'label' => translate('Categories'),
                        'icon' => 'heroicon-o-folder-open',
                        'route' => route('categories.index'),
                        'is_active' => areActiveRoutes(['categories.index']),
                        'user_types' => User::$tenant_user_types,
                        'permissions' => []
                    ],
                    /* [
                        'label' => translate('Courses'),
                        'icon' => 'heroicon-o-academic-cap',
                        'route' => route('courses.index'),
                        'is_active' => areActiveRoutes(['courses.index']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => [] // TODO: Add browse_all_courses and browse_my_courses - when courses are added as new content type
                    ], */
                    [
                        'label' => translate('Orders'),
                        'icon' => 'heroicon-o-document-text',
                        'route' => route('orders.index'),
                        'is_active' => areActiveRoutes(['orders.index']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => ['browse_orders'],
                        'badge' => [
                            'class' => 'badge-danger',
                            'content' => function () {
                                return 0;
                                return MyShop::getShop()->orders()->where('viewed', 0)->count();
                            }
                        ]
                    ],
                    /* [
                        'label' => translate('Leads'),
                        'icon' => 'heroicon-o-calendar',
                        'route' => route('leads.index'),
                        'is_active' => areActiveRoutes(['leads']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => ['all_leads', 'browse_leads']
                    ], */
                    // [
                    //     'label' => translate('Events'),
                    //     'icon' => 'heroicon-o-ticket',
                    //     'route' => '',
                    //     'is_active' => areActiveRoutes(['']),
                    //     'user_types' => ['admin','seller'],
                    // ],
                    // [
                    //     'label' => translate('Jobs'),
                    //     'icon' => 'heroicon-o-briefcase',
                    //     'route' => '',
                    //     'is_active' => areActiveRoutes(['']),
                    //     'user_types' => ['admin','seller'],
                    // ],

                ]
            ],
            [
                'label' => translate('Marketing'),
                'items' => [
                    [
                        'label' => translate('Blog'),
                        'icon' => 'heroicon-o-newspaper',
                        'route' => route('blog.posts.index'),
                        'is_active' => areActiveRoutes(['blog.posts.index']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => ['all_posts', 'browse_posts']
                    ],
                    //                    [
                    //                        'label' => translate('Website'),
                    //                        'icon' => 'heroicon-o-qrcode',
                    //                        'route' => route('settings.domains'),
                    //                        'is_active' => areActiveRoutes(['settings.domains']),
                    //                        'user_types' => User::$non_customer_user_types,
                    //                        'permissions' => [] // TODO: Don't know what this is about tbh
                    //                    ],
                    /* [
                        'label' => translate('Tutorials'),
                        'icon' => 'heroicon-o-academic-cap',
                        'route' => route('ev-tutorials.index'),
                        'is_active' => areActiveRoutes(['ev-tutorials.index']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => []
                    ] */
                    // [
                    //     'label' => translate('Subscriptions'),
                    //     'icon' => 'heroicon-o-currency-dollar',
                    //     'route' => '',
                    //     'is_active' => areActiveRoutes(['']),
                    //     'user_types' => ['admin','seller'],
                    // ],
                ]
            ],

            [
                'label' => translate('CRM'),
                'items' => [

                    /* TODO: Uncomment this once we have customers page */
                    /* [
                        'label' => translate('Customers'),
                        'icon' => 'heroicon-o-user-group',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => ['all_customers', 'browse_customers']
                    ], */
                    /* [
                        'label' => translate('Reviews'),
                        'icon' => 'heroicon-o-star',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => ['browse_reviews', 'view_review']
                    ], */

                    // TODO: Do we need another route/menu-item for admin/moderator/support Support page? We should have to support panels: one for customers/vendors and one for admin/moderator/support
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
                        'user_types' => User::$user_types,
                        'permissions' => []
                    ],
                    [
                        'label' => translate('My Purchases'),
                        'icon' => 'heroicon-o-document-text',
                        'route' => route('my.purchases.all'),
                        'is_active' => areActiveRoutes(['my.purchases.all']),
                        'user_types' => User::$user_types,
                        'permissions' => []
                    ],
                    [
                        'label' => translate('Downloads'),
                        'icon' => 'heroicon-o-document-text',
                        'route' => route('my.purchases.all'),
                        'is_active' => areActiveRoutes(['my.purchases.all']),
                        'user_types' => User::$user_types,
                        'permissions' => []
                    ],
                    [
                        'label' => translate('Plans Management'),
                        'icon' => 'heroicon-o-document',
                        'route' => route('my.plans.management'),
                        'is_active' => areActiveRoutes(['my.plans.management']),
                        'user_types' => User::$user_types,
                        'permissions' => []
                    ],
                  /*   [
                        'label' => translate('My Wishlist'),
                        'icon' => 'heroicon-o-heart',
                        'route' => route('wishlist'),
                        'is_active' => areActiveRoutes(['wishlist']),
                        'user_types' => User::$user_types,
                        'permissions' => []
                    ], */
                /*     [
                        'label' => translate('My Viewed Items'),
                        'icon' => 'heroicon-o-eye',
                        'route' => route('wishlist.views'),
                        'is_active' => areActiveRoutes(['wishlist.views']),
                        'user_types' => User::$user_types,
                        'permissions' => []
                    ] */
                ]
            ],
            [
                'label' => translate('Settings'),
                'items' => [
                    [
                        'label' => translate('Shop settings'),
                        'icon' => 'heroicon-o-office-building',
                        'route' => route('settings.shop_settings'),
                        'is_active' => areActiveRoutes(['settings.shop_settings']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => ['view_shop_data', 'view_shop_settings']
                    ],
                    [
                        'label' => translate('App settings'),
                        'icon' => 'heroicon-o-cog',
                        'route' => route('settings.app_settings'),
                        'is_active' => areActiveRoutes(['settings.app_settings']),
                        'user_types' => User::$tenant_user_types,
                        'permissions' => ['browse_designs']
                    ],
                    [
                        'label' => translate('Page builder - We Edit'),
                        'icon' => 'heroicon-o-cog',
                        'route' => route('we-edit.index'),
                        'is_active' => areActiveRoutes(['we-edit.index']),
                        'user_types' => User::$tenant_user_types,
                        'permissions' => ['browse_designs']
                    ],
                    [
                        'label' => translate('Payment settings'),
                        'icon' => 'heroicon-o-cash',
                        'route' => route('settings.payment_methods'),
                        'is_active' => areActiveRoutes(['settings.payment_methods']),
                        'user_types' => User::$tenant_user_types,
                        'permissions' => ['browse_uni_payment_methods']
                    ],
                    [
                        'label' => translate('Staff settings'),
                        'icon' => 'heroicon-s-user-group',
                        'route' => route('settings.staff_settings'),
                        'is_active' => areActiveRoutes(['settings.staff_settings']),
                        'user_types' => User::$tenant_user_types,
                        'permissions' => ['browse_staff'] // TODO: Add users managing permissions
                    ],

                    // [
                    //     'label' => translate('Company settings'),
                    //     'icon' => 'heroicon-o-office-building',
                    //     'route' => route('attributes'),
                    //     'is_active' => areActiveRoutes(['attributes']),
                    //     'user_types' => ['admin','seller'],
                    // ],

                    // [
                    //     'label' => translate('Shipping settings'),
                    //     'icon' => 'heroicon-o-truck',
                    //     'route' => '',
                    //     'is_active' => areActiveRoutes(['']),
                    //     'user_types' => ['admin','seller'],
                    // ],
                    // [
                    //     'label' => translate('Tax settings'),
                    //     'icon' => 'heroicon-o-receipt-tax',
                    //     'route' => '',
                    //     'is_active' => areActiveRoutes(['']),
                    //     'user_types' => ['admin','seller'],
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
                    //     'user_types' => ['admin','seller'],
                    // ],
                    // [
                    //     'label' => translate('Uploaded media'),
                    //     'icon' => 'heroicon-o-upload',
                    //     'route' => '',
                    //     'is_active' => areActiveRoutes(['']),
                    //     'user_types' => ['admin','seller'],
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
                        'user_types' => User::$user_types,
                        'permissions' => []
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
                $mapped[$brand->id] = $brand->name;
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
            'custom' => 'Custom html',
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
