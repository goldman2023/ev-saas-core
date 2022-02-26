<?php

namespace App\Http\Livewire\WeEdit\Panels;

use Livewire\Component;
use App\Enums\WeEditLayoutEnum;

class AvailableSections extends Component
{
    public $available_sections;

    public function mount()
    {
        $this->initAvailableSections();
    }

    protected function initAvailableSections() {
        $this->available_sections = [
            'hero' => [
                'title' => 'Hero',
                'description' => 'A lovely description for hero sections',
                'sections' => [
                    'tailwind.hero.ecommerce-hero' => [
                        'id' => 'tailwind.hero.ecommerce-hero',
                        'title' => 'Ecommerce Hero',
                        'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.04-with-app-screenshot-xl.jpg',
                        'order' => -1,
                    ],
                ]
            ],
            'product_lists' => [
                'title' => 'Product Lists',
                'description' => 'A lovely description for hero sections',
                'sections' => [
                    'tailwind.product-lists.simple' => [
                        'id' => 'tailwind.product-lists.simple',
                        'title' => 'Product List 1',
                        'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.05-with-sign-in-form-xl.png',
                        'order' => -1
                    ],
                    'tailwind.product-lists.simple-3' => [
                        'id' => 'tailwind.product-lists.simple',
                        'title' => 'Product List 2',
                        'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.05-with-sign-in-form-xl.png',
                        'order' => -1
                    ],
                    'tailwind.product-lists.simple-2' => [
                        'id' => 'tailwind.product-lists.simple',
                        'title' => 'Product List 3',
                        'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.05-with-sign-in-form-xl.png',
                        'order' => -1
                    ]
                ]
            ]
        ];
    }
    
    public function render()
    {
        return view('livewire.we-edit.panels.available-sections');
    }
}