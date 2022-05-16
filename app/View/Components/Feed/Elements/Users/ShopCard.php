<?php

namespace App\View\Components\Feed\Elements\Users;

use Illuminate\View\Component;

class ShopCard extends Component
{
    public $user;
    public $class;
    public $shop = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user = null, $shop = null, $class = '')
    {
        $this->user = $user;
        $this->class = $class;

        if(!empty($shop)) {
            $this->shop = $shop;
        } else {
            $this->shop = ($user?->hasShop() ?? null) ? $this->user->shop->first() : null;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.feed.elements.users.shop-card');
    }
}
