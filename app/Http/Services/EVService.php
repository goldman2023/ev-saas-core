<?php

namespace App\Http\Services;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\View\ComponentAttributeBag;

class EVService
{
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
                    [
                        'label' => translate('Schedule'),
                        'icon' => 'heroicon-o-calendar',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => [],
                    ]
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
                        'label' => translate('Events'),
                        'icon' => 'heroicon-o-ticket',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin','seller'],
                    ],
                    [
                        'label' => translate('Jobs'),
                        'icon' => 'heroicon-o-briefcase',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin','seller'],
                    ],
                    [
                        'label' => translate('Blog'),
                        'icon' => 'heroicon-o-newspaper',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin','seller'],
                    ]
                ]
            ],
            [
                'label' => translate('Manage'),
                'items' => [
                    [
                        'label' => translate('Orders'),
                        'icon' => 'heroicon-o-document-text',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin','seller'],
                    ],
                    [
                        'label' => translate('Subscriptions'),
                        'icon' => 'heroicon-o-currency-dollar',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin','seller'],
                    ],
                ]
            ],
            [
                'label' => translate('CRM'),
                'items' => [
                    [
                        'label' => translate('Messages'),
                        'icon' => 'heroicon-o-chat',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin','seller'],
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
                'label' => translate('Settings'),
                'items' => [
                    [
                        'label' => translate('Account settings'),
                        'icon' => 'heroicon-o-cog',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),

                    ],
                    [
                        'label' => translate('Company settings'),
                        'icon' => 'heroicon-o-office-building',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin','seller'],
                    ],
                    [
                        'label' => translate('Shipping settings'),
                        'icon' => 'heroicon-o-truck',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin','seller'],
                    ],
                    [
                        'label' => translate('Tax settings'),
                        'icon' => 'heroicon-o-receipt-tax',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin','seller'],
                    ],
                ]
            ],
            [
                'label' => translate('Other'),
                'items' => [
                    [
                        'label' => translate('Plans & billing'),
                        'icon' => 'heroicon-o-credit-card',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin','seller'],
                    ],
                    [
                        'label' => translate('Uploaded media'),
                        'icon' => 'heroicon-o-upload',
                        'route' => '',
                        'is_active' => areActiveRoutes(['']),
                        'roles' => ['admin','seller'],
                    ],
                ]
            ],
            [
                'label' => 'hr',
                'items' => [
                    [
                        'label' => translate('Log out'),
                        'icon' => 'heroicon-o-logout',
                        'route' => route('logout'),
                        'is_active' => false,
                    ],
                ]
            ]
        ];
    }


    public function getMappedCategories() {
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();

        $mapped = [];

        $recursion = function($child_category) use (&$recursion, &$mapped) {
            $value = str_repeat('--', $child_category->level);

            $mapped[$child_category->id] = $value." ".$child_category->getTranslation('name');

            if($child_category->categories) {
                foreach ($child_category->categories as $childCategory) {
                    $recursion($childCategory);
                }
            }
        };

        if($categories->isNotEmpty()) {
            foreach($categories as $category) {
                $mapped[$category->id] = $category->getTranslation('name');

                if($category->childrenCategories) {
                    foreach($category->childrenCategories as $childCategory) {
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

    public function getMappedAttributes($content_type) {
        // Get mapped attributes to display them in form select element for specific content type
        $attrs = Attribute::select('id','name','type')->where('content_type', $content_type)->get();
        $mapped = [];

        if($attrs->isNotEmpty()) {
            foreach ($attrs as $att) {
                $mapped[$att->id] = (object) array_merge($att->toArray(), [
                    'selected' => true, // TODO: Change value if editing the product
                    'for_variations' => false, // TODO: Change value if editing the product
                ]);
            }
        }

        return $mapped;
    }
}
