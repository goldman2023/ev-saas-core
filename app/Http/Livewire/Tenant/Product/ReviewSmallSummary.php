<?php

namespace App\Http\Livewire\Tenant\Product;

use App\Models\Product;
use Livewire\Component;

class ReviewSmallSummary extends Component
{
    public $reviews;

    public $product_id;

    public $count = 0;

    public $total_rating = 0;

    public $average_rating = 0;

    protected $listeners = ['review-stored' => 'calculateReview'];

    public function mount($product_id)
    {
        $this->product_id = $product_id;
        $this->calculateReview();
    }

    public function render()
    {
        return view('livewire.tenant.product.review-small-summary');
    }

    public function calculateReview()
    {
        $this->reviews = Product::find($this->product_id)->reviews;

        $this->total_rating = 0;
        $this->average_rating = 0;
        $this->count = 0;
        foreach ($this->reviews as $review) {
            $this->total_rating += $review->review->rating;
            $this->count++;
        }
        if ($this->count > 0) {
            $this->average_rating = number_format(($this->total_rating / $this->count), 2, '.', ',');
        } else {
            $this->average_rating = 0;
        }
    }
}
