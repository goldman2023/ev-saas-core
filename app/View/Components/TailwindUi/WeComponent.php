<?php

namespace App\View\Components\TailwindUi;

use Illuminate\View\Component;
use App\Enums\UserVisibilityEnum;
use App\Enums\ResponsiveVisibilityEnum;

class WeComponent extends Component
{   
    public function getDefaultSettings() {
        return [
            'background' => [
                'type' => 'color', // color, image, video
                'color' => '#fff',
                'urls' => [
                    'mobile' => '',
                    'tablet' => '',
                    'desktop' => ''
                ],
                'position' => 'center'
            ],
            'spacing' => [
                'mobile' => [
                    'top' => '0',
                    'bottom' => '0'
                ],
                'tablet' => [
                    'top' => '0',
                    'bottom' => '0'
                ],
                'desktop' => [
                    'top' => '0',
                    'bottom' => '0'
                ],
            ],
            'extra_classes' => '',
            'user_visibility' => 'all', // all, guest, auth, subscriber, non_subscriber
            'responsive_visibility' => 'all' // Mobile (), Tablet portrait(sm), Tablet Landscape(md), Laptop(lg), Full Desktop(xl)
        ];
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.we-component');
    }

    
}
