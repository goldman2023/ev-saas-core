<?php

namespace App\View\Components\Panels;

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
        if(session('style_framework') === 'tailwind') {
            return view('components.tailwind-ui.panels.flyout-wishlist');
        }

        return view('components.bootstrap.panels.flyout-wishlist');
    }
}
