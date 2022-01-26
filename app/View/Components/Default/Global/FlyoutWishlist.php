<?php

namespace App\View\Components\Default\Global;

use Illuminate\View\Component;

class FlyoutWishlist extends Component
{
    public $wishlist;
    public $count;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->count = auth()->user()?->wishlists()?->count() ?? 0;
        $this->wishlist = auth()->user()?->wishlists;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.global.flyout-wishlist');
    }
}
