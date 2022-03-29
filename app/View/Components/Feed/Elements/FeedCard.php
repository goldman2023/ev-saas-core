<?php

namespace App\View\Components\Feed\Elements;

use Illuminate\View\Component;
use Spatie\Activitylog\Models\Activity;

class FeedCard extends Component
{
    public $item;
    public $product;
    private $ignore = true;
    public $likes = 0;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        //
        $this->ignore = false;

        $this->item = $item;
        $this->likes = Activity::where('subject_type', 'Spatie\Activitylog\Models\Activity')
        ->where('description','liked')
        ->where('subject_id', $item->id)
        ->count();

        if(empty($item->causer)){
            $this->ignore = true;
        }
        if ($item->subject_type == 'App\Models\Product') {
            $this->product = $item->subject;
        } elseif ($item->subject_type == 'App\Models\Wishlist') {
            if (empty($item->subject->subject)) {
                $this->ignore = true;
            } else {
                $this->product = $item->subject->subject;
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if (!$this->ignore) {
            return view('components.feed.elements.feed-card');
        }
    }


}
