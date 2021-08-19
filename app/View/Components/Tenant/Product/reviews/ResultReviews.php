<?php

namespace App\View\Components\Tenant\Product\Reviews;

use Illuminate\View\Component;

class ResultReviews extends Component
{
    public $reviews;
    public $total_rating = 0;
    public $average_rating = 0;
    public $count = 0;
    public $each_stars = array();
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($reviews)
    {
        $this->reviews = $reviews;
        for($i = 1; $i< 6 ; $i ++){
            $this->each_stars[$i] = 0;
        }
        foreach ($reviews as $review) {
            $this->total_rating += $review->review->rating;
            $this->count++;
            $this->each_stars[$review->review->rating]++;
        }
        if ($this->count > 0) {
            $this->average_rating = round($this->total_rating / $this->count);
        }else {
            $this->average_rating = 0;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tenant.product.reviews.result-reviews');
    }
}
