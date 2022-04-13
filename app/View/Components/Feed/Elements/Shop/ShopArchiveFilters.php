<?php

namespace App\View\Components\Feed\Elements\Shop;

use Illuminate\View\Component;

class ShopArchiveFilters extends Component
{
    public $hide_filters = false;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($hide = false)
    {
        //
        $this->hide_filters = $hide;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.feed.elements.shop.shop-archive-filters');
    }
}
