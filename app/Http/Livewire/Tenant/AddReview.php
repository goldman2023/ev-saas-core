<?php

namespace App\Http\Livewire\Tenant;

use Livewire\Component;
use App\Models\Review;
use App\Models\ReviewRelationship;
use App\Models\Shop;
use App\Models\Product;

class AddReview extends Component
{
    public $rating = 0;
    public $comment;
    public $content_type = 'App\Models\Product';
    public Product $product;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($product_id)
    {
        //
        $this->product = Product::find($product_id);
    }

    public function render()
    {
        return view('livewire.tenant.add-review');
    }

    public function setRating($val)
    {
        if ($this->rating == $val) {    // user can click on the same rating to reset the value
            $this->rating = 0;
        } else {
            $this->rating = $val;
        }
    }

    public function store()
    {
        $this->validate();
        $review = new Review;
        $review->comment = $this->comment;
        $review->rating = $this->rating;
        $review->content_type = $this->content_type;
        $review->status = 0;
        $review->product_id = $this->product->product_id;
        $review->save();

        $review_relationship = new ReviewRelationship;
        $review_relationship->review()->associate($review);
        $product = Product::where('slug', $this->product->slug)->first();
        if ($product == null) {
            $review->delete();
            flash(translate('Unable to find the Product.'))->error();
            return back();
        }
        $review_relationship->reviewable()->associate($product);
        $review_relationship->creator()->associate(auth()->user());
        $review_relationship->save();

        flash(translate('Review has been created successfully.'))->success();
        return back();
    }
}
