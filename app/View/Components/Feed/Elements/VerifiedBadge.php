<?php

namespace App\View\Components\Feed\Elements;

use Illuminate\View\Component;

class VerifiedBadge extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $item; // So far supports only Shop and User
    public $class;

    public function __construct($item, $class = '')
    {
        //
        $this->item = $item;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.feed.elements.verified-badge');
    }
}
