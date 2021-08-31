<?php

namespace App\Http\Services;

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
}
