<?php

namespace App\View\Components\tenant\product\reviews;

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
        //
        $this->reviews = $reviews;
        $one_count = 0;
        $two_count = 0;
        $three_count = 0;
        $four_count = 0;
        $five_count = 0;
        foreach ($reviews as $review) {
            $this->total_rating += $review->review->rating;
            $this->count++;
            switch ($review->review->rating) {
                case 1:
                    $one_count++;
                    break;
                case 2:
                    $two_count++;
                    break;
                case 3:
                    $three_count++;
                    break;
                case 4:
                    $four_count++;
                    break;
                case 5:
                    $five_count++;
                    break;
            }
        }

        if ($this->count > 0) {
            $this->each_stars[5] = round(($five_count / $this->count) * 100);
            $this->each_stars[4] = round(($four_count / $this->count) * 100);
            $this->each_stars[3] = round(($three_count / $this->count) * 100);
            $this->each_stars[2] = round(($two_count / $this->count) * 100);
            $this->each_stars[1] = round(($one_count / $this->count) * 100);
            $this->average_rating = round($this->total_rating / $this->count);
        }else {
            for($i = 1; $i< 6 ; $i ++){
                $this->each_stars[$i] = 0;
            }
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
