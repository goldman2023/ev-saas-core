<?php

namespace App\View\Components\Dashboard\Widgets;

use Illuminate\View\Component;

class QuickLinks extends Component
{
    public $links = [];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->links[] = [
            'title' => 'Google Analytics',
            'icon' => 'fab-google',
            'link' => '#'
        ];

        $this->links[] = [
            'title' => 'Stripe dashboard',
            'icon' => 'fab-stripe',
            'link' => ''
        ];

        $this->links[] = [
            'title' => 'Cloudflare',
            'icon' => 'fab-cloudflare',
            'link' => ''
        ];

        $this->links[] = [
            'title' => 'Github',
            'icon' => 'fab-github',
            'link' => ''
        ];

        $this->links[] = [
            'title' => 'Mailerlite',
            'icon' => 'heroicon-o-envelope-open',
            'link' => ''
        ];

        $this->links[] = [
            'title' => 'Search Console',
            'icon' => 'fab-google',
            'link' => ''
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.widgets.quick-links');
    }
}
