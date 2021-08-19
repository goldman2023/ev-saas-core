<?php

namespace App\View\Components\tenant\product\reviews;

use Illuminate\View\Component;

class ReviewCard extends Component
{
    public $review;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($review)
    {
        //
        $this->review = $review;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tenant.product.reviews.review-card');
    }
}
