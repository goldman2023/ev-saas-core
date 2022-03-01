<?php

namespace App\View\Components\TailwindUi;

use Illuminate\View\Component;

class WeComponent extends Component
{
    public $available_slot_components = [
        'ev-label' => 'Label',
        'ev-button' => 'Button',
        'ev-image' => 'Image',
        'ev-video' => 'Video',
        'ev-form' => 'Form',
        'tailwind.categories.category-list' => 'Category List',
    ];
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
