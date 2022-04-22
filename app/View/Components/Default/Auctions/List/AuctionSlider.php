<?php

namespace App\View\Components\Default\Auctions\List;

use App\Models\Product;
use Illuminate\View\Component;

class AuctionSlider extends Component
{
    public $products;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($products = null)
    {
        //
        /* TODO: When we create auction products, make sure only auction products are displayed here */
        $this->products = Product::take(7)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.auctions.list.auction-slider');
    }
}
