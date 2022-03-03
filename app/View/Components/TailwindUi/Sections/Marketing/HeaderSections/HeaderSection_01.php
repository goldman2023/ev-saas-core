<?php

namespace App\View\Components\TailwindUi\Sections\Marketing\HeaderSections;

use App\View\Components\TailwindUi\WeComponent;
use Illuminate\View\Component;

class HeaderSection_01 extends WeComponent
{
    // public $background = 'bg-gray-900'; // Some background component not the string probably
    // public $spacing = [
    //     'top' => '-8',
    //     'right' => '-8',
    //     'bottom' => '-8',
    //     'left' => '-8',
    // ];

    // public $slots = [
    //     'slot_1' => [],
    //     'slot_2' => [
    //         'component' => 'ev-label',
    //         'data' => [
    //             'title' => 'Hello World',
    //         ],
    //     ],
    // ];
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
        return view('components.tailwind-ui.sections.marketing.header-sections.header-section_01');
    }
}
