<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AffiliateBanner extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $banners = null;
    public $bannerID = 0;
    public function __construct($bannerID = 0)
    {
        $this->banners = \App\Models\AffiliateBanner::all();

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.affiliate-banner');
    }
}
