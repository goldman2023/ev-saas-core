<?php

namespace App\View\Components\Tenant\Hero;

use Illuminate\View\Component;

class SimpleCentered extends Component
{
    public $button;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($button = 'Get Started')
    {
        $this->button = $button;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tenant.hero.simple-centered');
    }
}
