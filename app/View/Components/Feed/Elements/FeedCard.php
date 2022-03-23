<?php

namespace App\View\Components\Feed\Elements;

use Illuminate\View\Component;

class FeedCard extends Component
{
    public $item;
    public $product;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        //
        $this->item = $item;

        if($item->subject_type == 'App\Models\Product') {
            $this->product = $item->subject;
        } elseif($item->subject_type == 'App\Models\Wishlist') {
            $this->product = $item->subject->subject;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.feed.elements.feed-card');
    }
}
