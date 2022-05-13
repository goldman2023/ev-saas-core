<?php

namespace App\View\Components\Feed\Elements\Shop;

use Illuminate\View\Component;

class ShopInformation extends Component
{
    public $shop;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($shop, $class = '')
    {
        $this->shop = $shop;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.feed.elements.shop.shop-information');
    }
}
