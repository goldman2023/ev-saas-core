<?php

namespace App\View\Components\Default\DynamicBlocks;

use Illuminate\View\Component;

class RecentlyViewed extends Component
{
    public $type = 'Shop';

    public $action_type = 'recently_viewed'; // In the future we could have, liked, saved, etc

    public $shops;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        if (auth()->user()) {
            $this->shops = auth()->user()->recently_viewed_shops();
        } else {
            /* TODO: If user is guest save product's in session storage */
            $this->shops = collect([]);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->type = 'Shop') {
            return view('components.default.dynamic-blocks.recently-viewed.shops');
        }

        return view('components.default.dynamic-blocks.recently-viewed.index');
    }
}
