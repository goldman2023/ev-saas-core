<?php

namespace App\View\Components\Feed\Elements;

use Illuminate\View\Component;

class CardHeaderUserInfo extends Component
{
    public $item;
    public $user;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        //
        $this->item = $item;
        $this->user = $item->causer;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.feed.elements.card-header-user-info');
    }
}
