<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;

class WeEdit extends Component
{
    public $available_sections = [
        'tailwind.hero.ecommerce-hero' => [
            'id' => 'tailwind.hero.ecommerce-hero',
            'title' => 'Ecommerce Hero',
            'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.04-with-app-screenshot-xl.jpg',
            'order' => -1,
        ],
        'tailwind.product-lists.simple' => [
            'id' => 'tailwind.product-lists.simple',
            'title' => 'Ecommerce Hero',
            'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.05-with-sign-in-form-xl.png',
            'order' => -1
        ],
        'tailwind.product-lists.simple-3' => [
            'id' => 'tailwind.product-lists.simple',
            'title' => 'Ecommerce Hero',
            'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.05-with-sign-in-form-xl.png',
            'order' => -1
        ],
        'tailwind.product-lists.simple-2' => [
            'id' => 'tailwind.product-lists.simple',
            'title' => 'Ecommerce Hero',
            'thumbnail' => 'https://tailwindui.com/img/components/hero-sections.05-with-sign-in-form-xl.png',
            'order' => -1
        ]
    ];

    public $page;
    public $sections;

    public function render()
    {

        $this->page = Page::where('slug', 'home')->first();
        // dd($this->page->content);
        $this->sections =  $this->page->content;

        return view('livewire.we-edit.we-edit');
    }
}
