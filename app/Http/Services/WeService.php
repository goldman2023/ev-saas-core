<?php

namespace App\Http\Services;

use WE;
use Cache;
use Session;
use App\Models\Lead;
use App\Models\Page;
use App\Models\Plan;
use App\Models\User;
use App\Models\Brand;
use App\Facades\MyShop;
use App\Models\Product;
use App\Models\Section;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Currency;
use Qirolab\Theme\Theme;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductVariation;
use Illuminate\Support\Collection;
use App\Enums\AppSettingsGroupEnum;
use Illuminate\View\ComponentAttributeBag;

class WeService
{
    protected $tenantStylePath;

    public function __construct($app)
    {
        $tenant_css_path = public_path('themes/'.Theme::parent().'/css/'.tenant('id').'.css');
        $default_css_path = public_path('themes/'.Theme::parent().'/css/app.css');
        $styling_url = '';

        if (file_exists($tenant_css_path)) {
            $url = asset('themes/'.Theme::parent().'/css/'.tenant('id').'.css?ver='.filemtime($tenant_css_path));
        } else {
            try {
                $url = asset('themes/'.Theme::parent().'/css/app.css?ver='.filemtime($default_css_path));
            } catch (\Exception $e) {
            }
        }

        try {
            // TODO: Think of a way to implement better vendor design pattern!
            $this->tenantStylePath = asset('themes/'.Theme::parent().'/css/app.css?ver='.filemtime($default_css_path)); //$url;
            $this->tenantStylePath = asset('themes/'.Theme::parent().'/css/app.css?ver='.filemtime($default_css_path));
        } catch (\Exception $e) {
        }
    }

    public function getThemeStyling()
    {
        return $this->tenantStylePath;
    }

    // This one is just a supplement (currently not used...)
    public function getDashboardMenuByRole($role = 'customer')
    {
        return collect($this->getDashboardMenuTemplate())->map(fn ($item) => collect($item['items'])->filter(function ($child) use ($role, $item) {
            if (isset($child['user_types'])) {
                return in_array($role, $child['user_types']);
            } else {
                return true;
            }
        })->count() > 0 ? $item : null)->filter()->values()->toArray();
    }

    // This one is used!
    public function getDashboardMenu()
    {
        return collect($this->getDashboardMenuTemplate())->map(function ($group) {
            $group['items'] = collect($group['items'])->filter(function ($child) use ($group) {
                // Check if enabled exists and is false - hide menu item
                if(isset($child['enabled']) && !$child['enabled']) return false;

                // Check if user has enough permissions to access the page
                return \Permissions::canAccess($child['user_types'], $child['permissions'], false);
            })->toArray();

            return  $group;
        })->filter(fn ($group) => ! empty($group['items']))->values()->toArray();
    }

    protected function getDashboardMenuTemplate(): array
    {
        // In order to show/hide certain items based on user type and permissions, you need to define user_types and permissions for each item
        return apply_filters('dashboard.sidebar.menu', [
            [
                'label' => translate('General'),
                'items' => [
                    [
                        'label' => translate('Dashboard'),
                        'icon' => 'heroicon-o-presentation-chart-bar',
                        'route' => route('dashboard'),
                        'route_name' => 'dashboard',
                        'is_active' => areActiveRoutes(['dashboard']),
                        'user_types' => User::$user_types,
                        'permissions' => [], // always show, independent of permissions
                    ],
                    [
                        'label' => translate('Tasks'),
                        'icon' => 'heroicon-o-clipboard-document-list',
                        'route' => route('tasks.index'),
                        'route_name' => 'tasks.index',
                        'is_active' => areActiveRoutes(['tasks.index']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => ['browse_orders'],
                        'badge' => [
                            'class' => 'badge-danger',
                            'content' => function () {
                                return 0;
                            },
                        ],
                    ],
                    [
                        'label' => translate('Chat'),
                        'icon' => 'heroicon-o-chat-bubble-left-right',
                        'route' => route('chat.index'),
                        'route_name' => 'chat.index',
                        'is_active' => areActiveRoutes(['chat']),
                        'user_types' => User::$user_types,
                        'permissions' => [],
                        'enabled' => get_tenant_setting('chat_feature', true),
                    ],
                ],
            ],
            [
                'label' => translate('Business'),
                'items' => [
                    [
                        'label' => translate('Orders'),
                        'icon' => 'heroicon-o-document-text',
                        'route' => route('orders.index'),
                        'route_name' => 'orders.index',
                        'is_active' => areActiveRoutes(['orders.index']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => ['browse_orders'],
                        'badge' => [
                            'class' => 'badge-danger',
                            'content' => function () {
                                return 0;

                                return MyShop::getShop()->orders()->where('viewed', 0)->count();
                            },
                        ],
                    ],
                    [
                        'label' => translate('Products'),
                        'icon' => 'heroicon-o-shopping-cart',
                        'route' => route('products.index'),
                        'route_name' => 'products.index',
                        'is_active' => areActiveRoutes(['products.index', 'attributes.index', 'product.details']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => ['all_products', 'browse_products'],
                        'children' => [
                            [
                                'label' => translate('All Products'),
                                'icon' => 'heroicon-o-archive-box',
                                'route' => route('products.index'),
                                'route_name' => 'products.index',
                                'is_active' => areActiveRoutes(['products.index',  'product.details']),
                                'user_types' => User::$non_customer_user_types,
                                'permissions' => ['browse_products'],
                            ],
                            [
                                'label' => translate('Product Addons'),
                                'icon' => 'heroicon-o-archive-box',
                                'route' => route('product-addons.index'),
                                'route_name' => 'product-addons.index',
                                'is_active' => areActiveRoutes(['product-addons.index',  'product-addon.details']),
                                'user_types' => User::$non_customer_user_types,
                                'permissions' => ['browse_products'],
                            ],
                            [
                                'label' => translate('Attributes'),
                                'icon' => 'heroicon-o-list-bullet',
                                'route' => route('attributes.index', base64_encode(Product::class)),
                                'route_name' => 'attributes.index',
                                'is_active' => areActiveRoutes(['attributes.index']),
                                'user_types' => User::$non_customer_user_types,
                                'permissions' => ['view_product_attributes'],
                            ],
                        ],
                    ],
                    [
                        'label' => translate('Plans'),
                        'icon' => 'heroicon-o-table-cells',
                        'route' => route('plans.index'),
                        'route_name' => 'plans.index',
                        'is_active' => areActiveRoutes(['plans.index']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => ['all_plans', 'browse_plans'],
                        'children' => [
                            [
                                'label' => translate('All Plans'),
                                'icon' => 'heroicon-o-archive-box',
                                'route' => route('plans.index'),
                                'route_name' => 'plans.index',
                                'is_active' => areActiveRoutes(['plans.index']),
                                'user_types' => User::$non_customer_user_types,
                                'permissions' => ['browse_plans'],
                            ],
                            [
                                'label' => translate('Attributes'),
                                'icon' => 'heroicon-o-list-bullet',
                                'route' => route('attributes.index', base64_encode(Plan::class)),
                                'route_name' => 'attributes.index',
                                'is_active' => areActiveRoutes(['attributes.index']),
                                'user_types' => User::$non_customer_user_types,
                                'permissions' => ['view_plan_attributes'],
                            ],
                        ],
                    ],
                    [
                        'label' => translate('Categories'),
                        'icon' => 'heroicon-o-folder-open',
                        'route' => route('categories.index'),
                        'route_name' => 'categories.index',
                        'is_active' => areActiveRoutes(['categories.index']),
                        'user_types' => User::$tenant_user_types,
                        'permissions' => [],
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
                        'label' => translate('Invoices'),
                        'icon' => 'heroicon-o-document-text',
                        'route' => route('invoices.index'),
                        'route_name' => 'invoices.index',
                        'is_active' => areActiveRoutes(['invoices.index']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => ['browse_orders'],
                        'badge' => [
                            'class' => 'badge-danger',
                            'content' => function () {
                                return 0;
                                // return 0;

                                // return MyShop::getShop()->invoices()->where('viewed', 0)->count();
                            },
                        ],
                    ],
                    [
                        'label' => translate('Leads'),
                        'icon' => 'heroicon-o-calendar',
                        'route' => route('leads.index'),
                        'route_name' => 'leads.index',
                        'is_active' => areActiveRoutes(['leads']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => ['all_leads', 'browse_leads'],
                         'badge' => [
                            'class' => 'badge-danger',
                            'content' => function () {
                                return Lead::count();
                            },
                        ],
                    ],


                ],
            ],
            [
                'label' => translate('CRM'),
                'items' => [
                    [
                        'label' => translate('Customers'),
                        'icon' => 'heroicon-o-user-group',
                        'route' => route('crm.all_customers'),
                        'route_name' => 'crm.all_customers',
                        'is_active' => areActiveRoutes(['crm.all_customers']),
                        'user_types' => User::$tenant_user_types,
                        'permissions' => ['browse_customers'],
                        'badge' => [
                            'class' => 'badge-info',
                            'content' => function () {

                                return User::byDays(2)->count() . ' Today';
                            },
                        ],
                    ],
                    [
                        'label' => translate('License management'),
                        'icon' => 'heroicon-o-circle-stack',
                        'route' => route('crm.licenses'),
                        'route_name' => 'crm.licenses',
                        'is_active' => areActiveRoutes(['crm.licenses']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => [],
                        /* TODO: Add expiring licenses count */
                        // 'badge' => [
                        //     'class' => 'badge-info',
                        //     'content' => function () {

                        //         return User::byDays(10)->count() . ' Today';
                        //     },
                        // ],
                    ],

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
                ],
            ],

            [
                'label' => translate('Content'),
                'items' => [
                    [
                        'label' => translate('Blog'),
                        'icon' => 'heroicon-o-newspaper',
                        'route' => route('blog.posts.index'),
                        'route_name' => 'blog.posts.index',
                        'is_active' => areActiveRoutes(['blog.posts.index']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => ['all_posts', 'browse_posts'],
                        'badge' => [
                            'class' => 'badge-info',
                            'content' => function () {

                                return BlogPost::count();
                            },
                        ],
                    ],
                    [
                        'label' => translate('Pages'),
                        'icon' => 'heroicon-o-document-text',
                        'route' => route('pages.index'),
                        'route_name' => 'pages.index',

                        'is_active' => areActiveRoutes(['pages.index', 'page.create']),
                        'user_types' => User::$tenant_user_types,
                        'permissions' => [], // TODO: Add App Pages Permissions
                        'enabled' => true,
                        'badge' => [
                            'class' => 'badge-info',
                            'content' => function () {
                                return Page::count();
                            },
                        ],
                    ],
                    [
                        'label' => translate('File Manager'),
                        'icon' => 'heroicon-o-paper-clip',
                        'route' => route('file-manager.index'),
                        'route_name' => 'file-manager.index',

                        'is_active' => areActiveRoutes(['file-manager.index', 'page.create']),
                        'user_types' => User::$tenant_user_types,
                        'permissions' => [], // TODO: Add App Pages Permissions
                        'enabled' => true,
                    ],
                    [
                        'label' => translate('Sections'),
                        'icon' => 'heroicon-o-rectangle-stack',
                        'route' => route('sections.index'),
                        'route_name' => 'sections.index',

                        'is_active' => areActiveRoutes(['sections.index', 'sections.create']),
                        'user_types' => User::$tenant_user_types,
                        'permissions' => [], // TODO: Add App Pages Permissions
                        'enabled' => true,
                        'badge' => [
                            'class' => 'badge-info',
                            'content' => function () {
                                return Section::count();
                            },
                        ],
                    ],
                    [
                        'label' => translate('Quizzes'),
                        'icon' => 'heroicon-o-user',
                        'route' => route('dashboard.we-quiz.index'),
                        'route_name' => 'dashboard.we-quiz.index',
                        'is_active' => areActiveRoutes(['dashboard.we-quiz.index']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => [],
                        'enabled' => true,
                    ],
                ],
            ],
            // Customer Zone
            [
                'label' => translate('Customer zone'),
                'items' => apply_filters('dashboard.sidebar.customer-zone.items', [

                    [
                        'label' => translate('My Purchases'),
                        'icon' => 'heroicon-o-shopping-cart',
                        'route' => route('my.purchases.index'),
                        'route_name' => 'my.purchases.index',
                        'is_active' => areActiveRoutes(['my.purchases.index']),
                        'user_types' => User::$user_types,
                        'permissions' => [],
                    ],
                    [
                        'label' => translate('My Subscriptions'),
                        'icon' => 'heroicon-o-arrow-path',
                        'route' => route('my.plans.management'),
                        'route_name' => 'my.plans.management',
                        'is_active' => areActiveRoutes(['my.plans.management']),
                        'user_types' => User::$user_types,
                        'permissions' => [],
                    ],
                    [
                        'label' => translate('Orders'),
                        'icon' => 'heroicon-o-shopping-cart',
                        'route' => route('my.orders.all'),
                        'route_name' => 'my.orders.all',
                        'is_active' => areActiveRoutes(['my.orders.all']),
                        'user_types' => User::$user_types,
                        'permissions' => [],
                        'badge' => [
                            'class' => 'badge-danger',
                            'content' => function () {
                                // return 0;
                                return auth()->user()->orders()->where('viewed', 0)->count();
                            },
                        ],
                    ],
                    [
                        'label' => translate('Invoices'),
                        'icon' => 'heroicon-o-document-text',
                        'route' => route('my.invoices.all'),
                        'route_name' => 'my.invoices.all',
                        'is_active' => areActiveRoutes(['my.invoices.all']),
                        'user_types' => User::$user_types,
                        'permissions' => [],
                        'badge' => [
                            'class' => 'badge-danger',
                            'content' => function () {
                                // return 0;
                                return auth()->user()->invoices()->where('payment_status', 'unpaid')->count();
                            },
                        ],
                    ],
                    [
                        'label' => translate('My Account'),
                        'icon' => 'heroicon-o-user',
                        'route' => route('my.account.settings'),
                        'route_name' => 'my.account.settings',
                        'is_active' => areActiveRoutes(['my.account.settings']),
                        'user_types' => User::$user_types,
                        'permissions' => [],
                    ],
                    [
                        'label' => translate('Billing Portal'),
                        'icon' => 'heroicon-o-credit-card',
                        'route' => route('stripe.portal_session'),
                        'route_name' => 'stripe.portal_session',
                        'is_active' => areActiveRoutes(['stripe.portal_session']),
                        'user_types' => User::$user_types,
                        'permissions' => [], // always show, independent of permissions
                        // 'badge' => [
                        //     'class' => 'badge-info',
                        //     'content' => function () {

                        //         return 'New';
                        //     },
                        // ],
                    ],


                    /*   [
                        'label' => translate('My Wishlist'),
                        'icon' => 'heroicon-o-heart',
                        'route' => route('wishlist'),
                        'is_active' => areActiveRoutes(['wishlist']),
                        'user_types' => User::$user_types,
                        'permissions' => [],
                        'enabled' => get_tenant_setting('wishlist_enabled', true),
                    ], */
                    /*     [
                        'label' => translate('My Viewed Items'),
                        'icon' => 'heroicon-o-eye',
                        'route' => route('wishlist.views'),
                        'is_active' => areActiveRoutes(['wishlist.views']),
                        'user_types' => User::$user_types,
                        'permissions' => [],
                        'enabled' => get_tenant_setting('viewed_products_enabled', true),
                    ] */
                ]),
            ],
            [
                'label' => translate('Settings'),
                'items' => [
                    [
                        'label' => translate('Staff settings'),
                        'icon' => 'heroicon-s-user-group',
                        'route' => route('settings.staff_settings'),
                        'route_name' => 'settings.staff_settings',
                        'is_active' => areActiveRoutes(['settings.staff_settings']),
                        'user_types' => User::$tenant_user_types,
                        'permissions' => ['browse_staff'], // TODO: Add users managing permissions,
                        'enabled' => get_tenant_setting('staff_enabled', true),
                    ],
                    [
                        'label' => translate('Shop settings'),
                        'icon' => 'heroicon-o-building-office',
                        'route' => route('settings.shop_settings'),
                        'route_name' => 'settings.shop_settings',
                        'is_active' => areActiveRoutes(['settings.shop_settings']),
                        'user_types' => User::$non_customer_user_types,
                        'permissions' => ['view_shop_data', 'view_shop_settings'],
                    ],
                    [
                        'label' => translate('App settings'),
                        'icon' => 'heroicon-o-cog',
                        'route' => route('settings.app_settings'),
                        'route_name' => 'settings.app_settings',
                        'is_active' => areActiveRoutes(['settings.app_settings']),
                        'user_types' => User::$tenant_user_types,
                        'permissions' => [],
                        'children' => [
                            [
                                'label' => translate('All Settings'),
                                'icon' => 'heroicon-o-cog',
                                'route' => route('settings.app_settings'),
                                'route_name' => 'settings.app_settings',
                                'is_active' => areActiveRoutes(['settings.app_settings',  'product.details']),
                                'user_types' => User::$tenant_user_types,
                                'permissions' => [],
                            ],
                            [
                                'label' => translate('Notifications'),
                                'icon' => 'heroicon-o-list-bullet',
                                'route' => route('settings.app.group', AppSettingsGroupEnum::notifications()->value),
                                'route_name' => 'settings.app.group',
                                'is_active' => areActiveRoutes(['settings.app.group']),
                                'user_types' => User::$tenant_user_types,
                                'permissions' => [],
                            ],
                        ],
                    ],
                    [
                        'label' => translate('Page builder - We Edit'),
                        'icon' => 'heroicon-o-cog',
                        'route' => route('we-edit.index'),
                        'route_name' => 'we-edit.index',
                        'is_active' => areActiveRoutes(['we-edit.index']),
                        'user_types' => User::$tenant_user_types,
                        'permissions' => ['browse_designs'],
                        'enabled' => get_tenant_setting('weedit_feature', true),
                    ],
                    // [
                    //     'label' => translate('Payment settings'),
                    //     'icon' => 'heroicon-o-cash',
                    //     'route' => route('settings.payment_methods'),
                    //     'is_active' => areActiveRoutes(['settings.payment_methods']),
                    //     'user_types' => User::$tenant_user_types,
                    //     'permissions' => ['browse_uni_payment_methods']
                    // ],


                    // [
                    //     'label' => translate('Analytics'),
                    //     'icon' => 'heroicon-s-chart-pie',
                    //     'route' => route('analytics.index'),
                    //     'is_active' => areActiveRoutes(['analytics.index']),
                    //     'user_types' => User::$tenant_user_types,
                    //     'permissions' => ['view_analytics'], // TODO: Add users managing permissions,
                    //     'enabled' => get_tenant_setting('we_analytics_enabled', true),
                    // ],

                    // [
                    //     'label' => translate('Integrations'),
                    //     'icon' => 'heroicon-s-adjustments',
                    //     'route' => route('analytics.index'),
                    //     'is_active' => areActiveRoutes(['analytics.index']),
                    //     'user_types' => User::$tenant_user_types,
                    //     'permissions' => ['view_analytics'], // TODO: Add users managing permissions,
                    //     'enabled' => get_tenant_setting('integrations_enabled', true),
                    // ],

                    [
                        'label' => translate('Super Admin'),
                        'icon' => 'heroicon-s-cloud',
                        'route' => '/we/admin',
                        'route_name' => 'settings.super_admin',
                        'is_active' => areActiveRoutes(['analytics.index']),
                        'user_types' => User::$tenant_user_types,
                        'permissions' => ['view_analytics'], // TODO: Add users managing permissions,
                        'enabled' => get_tenant_setting('integrations_enabled', true),
                    ],

                    // [
                    //     'label' => translate('Company settings'),
                    //     'icon' => 'heroicon-o-building-office',
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
                ],
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
                ],
            ],
            [
                'label' => 'hr',
                'items' => [
                    [
                        'label' => translate('Log out'),
                        'icon' => 'heroicon-o-arrow-right-on-rectangle',
                        'route' => route('user.logout'),
                        'is_active' => false,
                        'user_types' => User::$user_types,
                        'permissions' => [],
                    ],
                ],
            ],
        ]
    );
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

            $mapped[$child_category['id']] = $value.' '.$child_category['name'];

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
            foreach (Brand::all() as $brand) {
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
            'oz' => 'oz',
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
