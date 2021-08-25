<?php

namespace App\Http\Livewire\Tenant\Product;

use App\Models\Product;
use Livewire\Component;

class ReviewList extends Component
{
    public $reviews;
    public $test = "test";

    protected $listeners = ['review-stored' => '$refresh'];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($reviews)
    {
        $this->reviews = $reviews;

        // $this->getProductReview();
    }
    public function render()
    {
        return view('livewire.tenant.product.review-list');
    }

    public function getProductReview() {
        $this->render();
    }
}
