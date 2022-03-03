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
            'tailwind-ui' => [
                'sections' => [
                    'marketing' => [
                        'hero-sections' => [
                            'title' => 'Hero',
                            'description' => 'A lovely description for hero sections',
                            'sections' => [
                                'tailwind-ui.sections.marketing.hero-sections.hero-section_01' => [
                                    'id' => 'tailwind-ui.sections.marketing.hero-sections.hero-section_01',
                                    'title' => 'Hero Section 01',
                                    'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.01-simple-centered-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.hero-sections.hero-section_02' => [
                                    'id' => 'tailwind-ui.sections.marketing.hero-sections.hero-section_02',
                                    'title' => 'Hero Section 02',
                                    'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.02-split-with-navbar-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.hero-sections.hero-section_03' => [
                                    'id' => 'tailwind-ui.sections.marketing.hero-sections.hero-section_03',
                                    'title' => 'Hero Section 03',
                                    'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.04-with-app-screenshot-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.hero-sections.hero-section_04' => [
                                    'id' => 'tailwind-ui.sections.marketing.hero-sections.hero-section_04',
                                    'title' => 'Hero Section 04',
                                    'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.04-with-app-screenshot-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.hero-sections.hero-section_07' => [
                                    'id' => 'tailwind-ui.sections.marketing.hero-sections.hero-section_07',
                                    'title' => 'Hero Section 07',
                                    'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.07-card-with-background-image-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                ],
                            ]
                        ],
                        'header-sections' => [
                            'title' => 'Header sections',
                            'description' => 'A lovely description for header sections',
                            'sections' => [
                                'tailwind-ui.sections.marketing.header-sections.header-section_01' => [
                                    'id' => 'tailwind-ui.sections.marketing.header-sections.header-section_01',
                                    'title' => 'Header Section 01',
                                    'thumbnail' => 'https://tailwindui.com/img/components/header-section.01-simple-centered-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.header-sections.header-section_02' => [
                                    'id' => 'tailwind-ui.sections.marketing.header-sections.header-section_02',
                                    'title' => 'Header Section 02',
                                    'thumbnail' => 'https://tailwindui.com/img/components/header-section.04-branded-with-background-image-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.header-sections.header-section_03' => [
                                    'id' => 'tailwind-ui.sections.marketing.header-sections.header-section_03',
                                    'title' => 'Header Section 03',
                                    'thumbnail' => 'https://tailwindui.com/img/components/header-section.05-with-background-image-and-overlapping-cards-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                ],
                            ]
                        ],
                        'cta-sections' => [
                            'title' => 'CTA',
                            'description' => 'A lovely description for cta sections',
                            'sections' => [
                                'tailwind-ui.sections.marketing.cta-sections.cta-section_01' => [
                                    'id' => 'tailwind-ui.sections.marketing.cta-sections.cta-section_01',
                                    'title' => 'CTA Section 01',
                                    'thumbnail' => 'https://tailwindui.com/img/components/cta-sections.01-brand-panel-with-app-screenshot-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.cta-sections.cta-section_02' => [
                                    'id' => 'tailwind-ui.sections.marketing.cta-sections.cta-section_02',
                                    'title' => 'CTA Section 02',
                                    'thumbnail' => 'https://tailwindui.com/img/components/cta-sections.02-simple-center-branded-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.cta-sections.cta-section_03' => [
                                    'id' => 'tailwind-ui.sections.marketing.cta-sections.cta-section_03',
                                    'title' => 'CTA Section 03',
                                    'thumbnail' => 'https://tailwindui.com/img/components/cta-sections.03-simple-centered-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.cta-sections.cta-section_04' => [
                                    'id' => 'tailwind-ui.sections.marketing.cta-sections.cta-section_04',
                                    'title' => 'CTA Section 04',
                                    'thumbnail' => 'https://tailwindui.com/img/components/cta-sections.04-simple-justified-on-light-brand-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.cta-sections.cta-section_05' => [
                                    'id' => 'tailwind-ui.sections.marketing.cta-sections.cta-section_05',
                                    'title' => 'CTA Section 05',
                                    'thumbnail' => 'https://tailwindui.com/img/components/cta-sections.05-simple-stacked-xl.png', 
                                    // Wrong image
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.cta-sections.cta-section_06' => [
                                    'id' => 'tailwind-ui.sections.marketing.cta-sections.cta-section_06',
                                    'title' => 'CTA Section 06',
                                    'thumbnail' => 'https://tailwindui.com/img/components/cta-sections.06-simple-stacked-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.cta-sections.cta-section_07' => [
                                    'id' => 'tailwind-ui.sections.marketing.cta-sections.cta-section_07',
                                    'title' => 'CTA Section 07',
                                    'thumbnail' => 'https://tailwindui.com/img/components/cta-sections.07-split-with-image-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.cta-sections.cta-section_08' => [
                                    'id' => 'tailwind-ui.sections.marketing.cta-sections.cta-section_08',
                                    'title' => 'CTA Section 08',
                                    'thumbnail' => 'https://tailwindui.com/img/components/cta-sections.08-brand-panel-with-overlapping-image-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                ],
                            ]
                        ],
                        'feature-sections' => [
                            'title' => 'Features',
                            'description' => 'A lovely description for feature sections',
                            'sections' => [
                                'tailwind-ui.sections.marketing.feature-sections.feature-section_01' => [
                                    'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_01',
                                    'title' => 'Feature Section 01',
                                    'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.01-alternating-side-by-side-with-images-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.feature-sections.feature-section_02' => [
                                    'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_02',
                                    'title' => 'Feature Section 02',
                                    'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.04-with-app-screenshot-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.feature-sections.feature-section_03' => [
                                    'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_03',
                                    'title' => 'Feature Section 03',
                                    'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.03-feature-grid-list-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.feature-sections.feature-section_04' => [
                                    'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_04',
                                    'title' => 'Feature Section 04',
                                    'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.04-feature-list-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.feature-sections.feature-section_05' => [
                                    'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_05',
                                    'title' => 'Feature Section 05',
                                    'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.05-offset-2x2-grid-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.feature-sections.feature-section_06' => [
                                    'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_06',
                                    'title' => 'Feature Section 06',
                                    'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.07-simple-three-column-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.feature-sections.feature-section_07' => [
                                    'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_07',
                                    'title' => 'Feature Section 07',
                                    'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.07-simple-three-column-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.feature-sections.feature-section_08' => [
                                    'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_08',
                                    'title' => 'Feature Section 08',
                                    'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.07-simple-three-column-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.feature-sections.feature-section_09' => [
                                    'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_09',
                                    'title' => 'Feature Section 09',
                                    'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.04-with-app-screenshot-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.feature-sections.feature-section_10' => [
                                    'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_10',
                                    'title' => 'Feature Section 10',
                                    'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.11-grid-with-offset-icons-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                            ]
                        ],
                        'pricing-sections' => [
                            'title' => 'Pricing',
                            'description' => 'A lovely description for hero sections',
                            'sections' => [
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_01' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_01',
                                    'title' => 'Pricing Section 01',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.01-four-tiers-with-toggle-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_02' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_02',
                                    'title' => 'Pricing Section 02',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.02-single-price-with-details-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_03' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_03',
                                    'title' => 'Pricing Section 03',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.03-single-price-with-feature-list-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_04' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_04',
                                    'title' => 'Pricing Section 04',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.04-split-with-brand-panel-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_05' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_05',
                                    'title' => 'Pricing Section 05',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.05-three-tiers-with-emphasized-tier-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_06' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_06',
                                    'title' => 'Pricing Section 06',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.06-two-tiers-with-extra-tier-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_07' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_07',
                                    'title' => 'Pricing Section 07',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.07-with-comparison-table-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_08' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_08',
                                    'title' => 'Pricing Section 08',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.08-three-tiers-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_09' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_09',
                                    'title' => 'Pricing Section 09',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.09-three-tiers-on-brand-and-feature-comparison-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                ],
                            ]
                        ]
                    ],
                    'ecommerce' => [],
                    'application-ui' => []
                ]
            ],
        ];

        foreach($this->available_sections as $theme_name => $categories) {
            foreach($categories['sections'] as $section_group_name => $groups) {
                foreach($groups as $group_name => $group) {
                    $available_sections_flat = array_merge($available_sections_flat, $group['sections']);
                }
            }
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