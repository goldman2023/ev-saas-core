<?php

namespace App\Http\Livewire\Tenant\Product;

use Livewire\Component;

class ReviewCard extends Component
{
    public $review;

    protected $listeners = ['postAdded' => '$refresh'];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($review)
    {
        $this->review = $review;
    }

    public function render()
    {
        return view('livewire.tenant.product.review-card');
    }
}
