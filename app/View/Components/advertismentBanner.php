<?php

namespace App\View\Components;

use Illuminate\View\Component;

class advertismentBanner extends Component
{

    public $banners = null;
    public $bannerID = 0;
    public function __construct($bannerID = 0)
    {
        $this->banners = \App\Models\AffiliateBanner::all();

        // dd($this->banners);
    }
    

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.advertisment-banner');
    }
}
