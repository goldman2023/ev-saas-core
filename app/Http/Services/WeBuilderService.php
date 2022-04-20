<?php

namespace App\Http\Services;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryRelationship;
use App\Models\Currency;
use App\Models\Product;
use App\Models\Shop;
use App\Models\ShopDomain;
use Cache;
use EVS;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\ComponentTagCompiler;
use Illuminate\View\ComponentAttributeBag;
use Session;
use Symfony\Component\DomCrawler\Crawler;

class WeBuilderService
{
    public $themes;

    public $sections_flat;

    protected $html_section_template;

    public function __construct($app)
    {
        $this->initAvailableSections();
    }

    protected function initAvailableSections()
    {
        $sections_flat = [];

        $this->themes = [
            'tailwind-ui' => [
                'sections' => [
                    'marketing' => [
                        'hero-sections' => [
                            'title' => 'Hero',
                            'description' => 'A lovely description for hero sections',
                            'sections' => [
                                'tailwind-ui.sections.marketing.hero-sections.hero-section_08' => [
                                    'id' => 'tailwind-ui.sections.marketing.hero-sections.hero-section_08',
                                    'title' => 'Hero Section 08',
                                    'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.07-card-with-background-image-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.hero-sections.hero-section_01' => [
                                    'id' => 'tailwind-ui.sections.marketing.hero-sections.hero-section_01',
                                    'title' => 'Hero Section 01',
                                    'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.01-simple-centered-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.hero-sections.hero-section_02' => [
                                    'id' => 'tailwind-ui.sections.marketing.hero-sections.hero-section_02',
                                    'title' => 'Hero Section 02',
                                    'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.02-split-with-navbar-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.hero-sections.hero-section_03' => [
                                    'id' => 'tailwind-ui.sections.marketing.hero-sections.hero-section_03',
                                    'title' => 'Hero Section 03',
                                    'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.04-with-app-screenshot-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.hero-sections.hero-section_04' => [
                                    'id' => 'tailwind-ui.sections.marketing.hero-sections.hero-section_04',
                                    'title' => 'Hero Section 04',
                                    'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.04-with-app-screenshot-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.hero-sections.hero-section_07' => [
                                    'id' => 'tailwind-ui.sections.marketing.hero-sections.hero-section_07',
                                    'title' => 'Hero Section 07',
                                    'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.07-card-with-background-image-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],

                            ],
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
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.header-sections.header-section_02' => [
                                    'id' => 'tailwind-ui.sections.marketing.header-sections.header-section_02',
                                    'title' => 'Header Section 02',
                                    'thumbnail' => 'https://tailwindui.com/img/components/header-section.04-branded-with-background-image-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.header-sections.header-section_03' => [
                                    'id' => 'tailwind-ui.sections.marketing.header-sections.header-section_03',
                                    'title' => 'Header Section 03',
                                    'thumbnail' => 'https://tailwindui.com/img/components/header-section.05-with-background-image-and-overlapping-cards-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                            ],
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
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.cta-sections.cta-section_02' => [
                                    'id' => 'tailwind-ui.sections.marketing.cta-sections.cta-section_02',
                                    'title' => 'CTA Section 02',
                                    'thumbnail' => 'https://tailwindui.com/img/components/cta-sections.02-simple-center-branded-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.cta-sections.cta-section_03' => [
                                    'id' => 'tailwind-ui.sections.marketing.cta-sections.cta-section_03',
                                    'title' => 'CTA Section 03',
                                    'thumbnail' => 'https://tailwindui.com/img/components/cta-sections.03-simple-centered-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.cta-sections.cta-section_04' => [
                                    'id' => 'tailwind-ui.sections.marketing.cta-sections.cta-section_04',
                                    'title' => 'CTA Section 04',
                                    'thumbnail' => 'https://tailwindui.com/img/components/cta-sections.04-simple-justified-on-light-brand-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.cta-sections.cta-section_05' => [
                                    'id' => 'tailwind-ui.sections.marketing.cta-sections.cta-section_05',
                                    'title' => 'CTA Section 05',
                                    'thumbnail' => 'https://tailwindui.com/img/components/cta-sections.05-simple-stacked-xl.png',
                                    // Wrong image
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.cta-sections.cta-section_06' => [
                                    'id' => 'tailwind-ui.sections.marketing.cta-sections.cta-section_06',
                                    'title' => 'CTA Section 06',
                                    'thumbnail' => 'https://tailwindui.com/img/components/cta-sections.06-simple-stacked-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.cta-sections.cta-section_07' => [
                                    'id' => 'tailwind-ui.sections.marketing.cta-sections.cta-section_07',
                                    'title' => 'CTA Section 07',
                                    'thumbnail' => 'https://tailwindui.com/img/components/cta-sections.07-split-with-image-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.cta-sections.cta-section_08' => [
                                    'id' => 'tailwind-ui.sections.marketing.cta-sections.cta-section_08',
                                    'title' => 'CTA Section 08',
                                    'thumbnail' => 'https://tailwindui.com/img/components/cta-sections.08-brand-panel-with-overlapping-image-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                            ],
                        ],
                        'feature-sections' => [
                            'title' => 'Features',
                            'description' => 'A lovely description for feature sections',
                            'sections' => [
                                'tailwind-ui.sections.marketing.feature-sections.feature-section01' => [
                                    'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section01',
                                    'title' => 'Feature Section 01',
                                    'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.01-alternating-side-by-side-with-images-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.feature-sections.features-grid01' => [
                                    'id' => 'tailwind-ui.sections.marketing.feature-sections.features-grid01',
                                    'title' => 'Features Grid 01',
                                    'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.03-feature-grid-list-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                // 'tailwind-ui.sections.marketing.feature-sections.feature-section_02' => [
                                //     'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_02',
                                //     'title' => 'Feature Section 02',
                                //     'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.04-with-app-screenshot-xl.jpg',
                                //     'order' => -1,
                                //     'data' => [],
                                //     'settings' => []
                                // ],
                                // 'tailwind-ui.sections.marketing.feature-sections.feature-section_03' => [
                                //     'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_03',
                                //     'title' => 'Feature Section 03',
                                //     'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.03-feature-grid-list-xl.png',
                                //     'order' => -1,
                                //     'data' => [],
                                //     'settings' => []
                                // ],
                                // 'tailwind-ui.sections.marketing.feature-sections.feature-section_04' => [
                                //     'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_04',
                                //     'title' => 'Feature Section 04',
                                //     'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.04-feature-list-xl.png',
                                //     'order' => -1,
                                //     'data' => [],
                                //     'settings' => []
                                // ],
                                // 'tailwind-ui.sections.marketing.feature-sections.feature-section_05' => [
                                //     'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_05',
                                //     'title' => 'Feature Section 05',
                                //     'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.05-offset-2x2-grid-xl.png',
                                //     'order' => -1,
                                //     'data' => [],
                                //     'settings' => []
                                // ],
                                // 'tailwind-ui.sections.marketing.feature-sections.feature-section_06' => [
                                //     'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_06',
                                //     'title' => 'Feature Section 06',
                                //     'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.07-simple-three-column-xl.png',
                                //     'order' => -1,
                                //     'data' => [],
                                //     'settings' => []
                                // ],
                                // 'tailwind-ui.sections.marketing.feature-sections.feature-section_07' => [
                                //     'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_07',
                                //     'title' => 'Feature Section 07',
                                //     'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.07-simple-three-column-xl.png',
                                //     'order' => -1,
                                //     'data' => [],
                                //     'settings' => []
                                // ],
                                // 'tailwind-ui.sections.marketing.feature-sections.feature-section_08' => [
                                //     'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_08',
                                //     'title' => 'Feature Section 08',
                                //     'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.07-simple-three-column-xl.png',
                                //     'order' => -1,
                                //     'data' => [],
                                //     'settings' => []
                                // ],
                                // 'tailwind-ui.sections.marketing.feature-sections.feature-section_09' => [
                                //     'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_09',
                                //     'title' => 'Feature Section 09',
                                //     'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.04-with-app-screenshot-xl.jpg',
                                //     'order' => -1,
                                //     'data' => [],
                                //     'settings' => []
                                // ],
                                // 'tailwind-ui.sections.marketing.feature-sections.feature-section_10' => [
                                //     'id' => 'tailwind-ui.sections.marketing.feature-sections.feature-section_10',
                                //     'title' => 'Feature Section 10',
                                //     'thumbnail' => 'https://tailwindui.com/img/components/feature-sections.11-grid-with-offset-icons-xl.png',
                                //     'order' => -1,
                                //     'data' => [],
                                //     'settings' => []
                                // ],
                            ],
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
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_02' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_02',
                                    'title' => 'Pricing Section 02',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.02-single-price-with-details-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_03' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_03',
                                    'title' => 'Pricing Section 03',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.03-single-price-with-feature-list-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_04' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_04',
                                    'title' => 'Pricing Section 04',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.04-split-with-brand-panel-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_05' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_05',
                                    'title' => 'Pricing Section 05',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.05-three-tiers-with-emphasized-tier-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_06' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_06',
                                    'title' => 'Pricing Section 06',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.06-two-tiers-with-extra-tier-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_07' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_07',
                                    'title' => 'Pricing Section 07',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.07-with-comparison-table-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_08' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_08',
                                    'title' => 'Pricing Section 08',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.08-three-tiers-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                                'tailwind-ui.sections.marketing.pricing-sections.pricing-section_09' => [
                                    'id' => 'tailwind-ui.sections.marketing.pricing-sections.pricing-section_09',
                                    'title' => 'Pricing Section 09',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.09-three-tiers-on-brand-and-feature-comparison-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                            ],
                        ],
                        'incentives-sections' => [
                            'title' => 'Incentives / Benefits',
                            'description' => 'A lovely description for incentives sections',
                            'sections' => [
                                'tailwind-ui.sections.ecommerce.incentives-sections.incentives_07' => [
                                    'id' => 'tailwind-ui.sections.ecommerce.incentives-sections.incentives_07',
                                    'title' => 'Incentives Section 07',
                                    'thumbnail' => 'https://tailwindui.com/img/components/pricing.01-four-tiers-with-toggle-xl.png',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                            ],
                        ],
                        'blog-archive' => [
                            'title' => 'Blog Archives',
                            'description' => 'All kinds of different blog archive components',
                            'sections' => [
                                'tailwind-ui.sections.marketing.blog-archives.blog-archive01' => [
                                    'id' => 'tailwind-ui.sections.marketing.blog-archives.blog-archive01',
                                    'title' => 'Blog Archive 01',
                                    'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.07-card-with-background-image-xl.jpg',
                                    'order' => -1,
                                    'data' => [],
                                    'settings' => [],
                                ],
                            ],
                        ],
                    ],
                    'ecommerce' => [],
                    'application-ui' => [],
                ],
            ],
        ];

        foreach ($this->themes as $theme_name => $categories) {
            foreach ($categories['sections'] as $section_group_name => $groups) {
                foreach ($groups as $group_name => $group) {
                    $sections_flat = array_merge($sections_flat, $group['sections']);
                }
            }
        }

        $this->sections_flat = $sections_flat;

        // Construct HTML Section template
        $this->html_section_template = [
            'id' => 'html',
            'title' => 'HTML Section',
            'thumbnail' => 'https://repository-images.githubusercontent.com/134285701/635de980-586d-11ea-9220-1a3211239c30', // TODO: Replace this with something consistent as HTML section Placeholder
            'order' => -1,
            'html' => '',
            'settings' => [],
        ];
    }

    public function getAllThemeSections($theme_name, $flat = false)
    {
        if ($flat) {
            return array_filter($this->sections_flat, function ($v, $k) use ($theme_name) {
                return str_starts_with($v['id'], $theme_name);
            }, ARRAY_FILTER_USE_BOTH);
        }

        return isset($this->themes[$theme_name]) ? $this->themes[$theme_name] : [];
    }

    public function getHtmlSectionTemplate()
    {
        return $this->html_section_template;
    }
}
