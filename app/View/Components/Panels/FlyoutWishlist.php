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

        $this->count = auth()->user()?->wishlists()->where('subject_type', 'App\\Models\\Product')->whereHas('subject')?->count() ?? 0;
        $this->wishlist = auth()->user()?->wishlists()->where('subject_type', 'App\\Models\\Product')->whereHas('subject')->get() ?? collect();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.panels.flyout-wishlist');
    }
}
