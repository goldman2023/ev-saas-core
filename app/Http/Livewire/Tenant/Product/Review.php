<?php

namespace App\Http\Livewire\Tenant\Product;

use App\Models\Product;
use Livewire\Component;

class Review extends Component
{
    public Product $product;
    public $product_id;
    public $reviews;

    protected $listeners = ['review-stored' => '$refresh'];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($product_id)
    {
        //
        $this->product_id = $product_id;
        $this->product = Product::find($this->product_id);
        $this->reviews = Product::find($this->product_id)->reviews;
    }

    public function render()
    {
        $this->reviews = Product::find($this->product_id)->reviews;
        return view('livewire.tenant.product.review');
    }

    public function getProductReview() {
        $this->reviews = Product::find($this->product_id)->reviews;
    }
}
