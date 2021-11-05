<?php

namespace App\Http\Services;

use App\Models\Currency;
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
                'label' => translate('Business'),
                'items' => [
                    [
                        'label' => translate('Products'),
                        'icon' => 'heroicon-o-shopping-cart',
                        'route' => route('ev-products.index'),
                        'is_active' => areActiveRoutes(['ev-products.index']),
                        'roles' => ['admin','seller'],
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
                ]
            ],
            [
                'label' => translate('Manage'),
                'items' => [
                    [
                        'label' => translate('Orders'),
                        'icon' => 'heroicon-o-document-text',
                        'route' => route('orders.index'),
                        'is_active' => areActiveRoutes(['orders.index']),
                        'roles' => ['admin','seller'],
                    ],
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

    public function getMappedAttributes($content_type, $subject = null, $return_object = true) {
        // Get mapped attributes to display them in form select element for specific content type
        $attrs = null;

        if(!empty($subject)) {
            // For existing content type:
            // 1. Get attributes for that content type
            // 2. DO NOT fetch attribute relationships and attribute_values
            $attrs = Attribute::without('attribute_values')->with('attribute_relationships', function($query) use($content_type, $subject) {
                $query->where([
                    ['subject_type', '=', $content_type],
                    ['subject_id', '=', $subject->id]
                ])->select('id', 'subject_type', 'subject_id', 'attribute_id', 'attribute_value_id', 'for_variations');
            })->select('id','name','type','custom_properties')->where('content_type', $content_type)->get()->toArray();

            // 3. GET attribute values ids based on all attribute relationships
            $attrs_values_idx = [];
            foreach($attrs as $key => $att) {
                $attrs[$key]['attribute_values'] = [];

                if(!empty($att['attribute_relationships'])) {
                    foreach($att['attribute_relationships'] as $attr_rel) {
                        // Add attribute value id to array (we'll need those to query selected/typed att values from DB)
                        $attrs_values_idx[] = $attr_rel['attribute_value_id'];

                        // Determine if used for variations
                        $attrs[$key]['for_variations'] = $attr_rel['for_variations'] ?? false;
                    }
                }
            }

            // 4. Fetch ONLY attribute values for dropdown, checkbox, radio attribute types
            $relevant_attrs_idx = collect($attrs)->filter(function ($value, $key) {
                return $value['is_predefined'];
            })->pluck('id')->all();
            $predefined_attrs_values = collect(AttributeValue::whereIn('attribute_id', $relevant_attrs_idx)->select('id', 'attribute_id', 'values')->get()->toArray())->groupBy('attribute_id')->transform(function($item, $key) {
                return $item->keyBy('id')->toArray();
            })->all();

            // 5. FETCH attribute values based on att. values ids provided from previously queried relationships
            $attrs_values = collect(AttributeValue::whereIn('id', $attrs_values_idx)->select('id', 'attribute_id', 'values')->get()->toArray())->transform(function($item, $key) {
                $item['selected'] = true;
                return $item;
            })->groupBy('attribute_id')->transform(function($item, $key) {
                return $item->keyBy('id')->toArray();
            })->all();


            // 6. Replace & merge recursively predefined values with selected attribute values
            // Note: Since attributes are grouped by keys and attribute values indexes are actually values IDs for both arrays,
            // we'll have an array of all attributes and their predefined and selected/typed values for specific content type
            // Such array is real representation of possible values and selected/typed values
            $real_values = array_replace_recursive($predefined_attrs_values, $attrs_values);

            // 6. Merge selected att values to their corresponding attributes
            foreach($attrs as $key => $item) {
                if(isset($real_values[$item['id']])) {
                    $attrs[$key]['attribute_values'] = array_values(collect($real_values[$item['id']])->toArray());
                }
            }
        } else {
            // For new content type:
            // 1. Get attributes for that content type
            // 2. DO NOT fetch attribute relationships and attribute_values
            $attrs = Attribute::without('attribute_relationships', 'attribute_values')->select('id','name','type','custom_properties')->where('content_type', $content_type)->get()->toArray();
            $relevant_attrs_idx = collect($attrs)->filter(function ($value, $key) {
                return $value['is_predefined'];
            })->pluck('id')->all();

            // 3. Fetch ONLY attribute values for dropdown, checkbox, radio attribute types
            $predefined_attrs_values = collect(AttributeValue::whereIn('attribute_id', $relevant_attrs_idx)->select('id', 'attribute_id', 'values')->get()->toArray())->groupBy('attribute_id')->all();

            // 4. Merge predefined values to their corresponding attributes
            foreach($attrs as $key => $item) {
                if(isset($predefined_attrs_values[$item['id']])) {
                    $attrs[$key]['attribute_values'] = collect($predefined_attrs_values[$item['id']])->toArray();
                }
            }
        }

        // Map the attributes to be used in livewire forms
        $mapped = [];

        if(!empty($attrs)) {
            foreach ($attrs as $att) {
                $att_object = $return_object ? (object) $att : $att;

                if($return_object) {
                    $att_object->selected = true; // All attributes are selected by default
                    $att_object->for_variations = !empty($subject->id ) ? ($att_object->for_variations ?? false) : false; // false if create, stays the same as previously defined on edit
                    $mapped[$att_object->id] = $att_object;
                } else {
                    $mapped[$att->id] = (object) array_merge($att_object, [
                        'selected' => true, // All attributes are selected by default
                        'for_variations' => !empty($subject->id) ? ($att_object['for_variations'] ?? false) : false,  // false if create, stays the same as previously defined on edit
                    ]);
                }
            }
        }

        return $mapped;
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
