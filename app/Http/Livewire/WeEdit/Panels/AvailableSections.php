<?php

namespace App\Http\Livewire\WeEdit\Panels;

use Livewire\Component;
use App\Enums\WeEditLayoutEnum;

class AvailableSections extends Component
{
    public $available_sections;
    public $available_sections_flat;

    public function mount()
    {
        $this->initAvailableSections();
    }

    public function dehydrate() {
        $this->dispatchBrowserEvent('initAvailableSectionsPanel');
    }

    protected function initAvailableSections() {
        $available_sections_flat = [];

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
                        'data' => [],
                    ],
                    'tailwind.hero.simple-text-center-hero' => [
                        'id' => 'tailwind.hero.simple-text-center-hero',
                        'title' => 'Simple Text Center Hero',
                        'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.04-with-app-screenshot-xl.jpg',
                        'order' => -1,
                        'data' => [],
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
                        'order' => -1,
                        'data' => [],
                    ],
                    'tailwind.product-lists.simple-3' => [
                        'id' => 'tailwind.product-lists.simple',
                        'title' => 'Product List 2',
                        'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.05-with-sign-in-form-xl.png',
                        'order' => -1,
                        'data' => [],
                    ],
                    'tailwind.product-lists.simple-2' => [
                        'id' => 'tailwind.product-lists.simple',
                        'title' => 'Product List 3',
                        'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.05-with-sign-in-form-xl.png',
                        'order' => -1,
                        'data' => [],
                    ]
                ]
            ]
        ];

        foreach($this->available_sections as $group) {
            $available_sections_flat = array_merge($available_sections_flat, $group['sections']);
        }

        $this->available_sections_flat = $available_sections_flat;
    }

    public function addSectionToPreview($section_id) {
        if(isset($this->available_sections_flat[$section_id])) {
            $this->emit('addSectionToPreviewEvent', [
                'id' => $section_id,
                'section' => $this->available_sections_flat[$section_id]
            ]);
        }
    }
    
    public function render()
    {
        return view('livewire.we-edit.panels.available-sections');
    }
}