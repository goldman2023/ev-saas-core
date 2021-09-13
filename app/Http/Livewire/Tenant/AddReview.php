<?php

namespace App\Http\Livewire\Tenant;

use Livewire\Component;
use App\Models\Review;
use App\Models\ReviewRelationship;
use App\Models\Product;

class AddReview extends Component
{
    public $rating = 0;
    public $comment;
    public $content_type = 'App\Models\Product';
    public $product_id;
    public $ratingError = null;
    public $open = false;


    protected $rules = [
        'comment' => 'required',
        'rating' => 'required|min:1'
    ];

    protected $listeners = ['show-modal' => 'showModal','hide-modal' => 'hideModal' ];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * Render component.
     *
     * @return void
     */

    public function render()
    {
        return view('livewire.tenant.add-review');
    }

    /**
     * Set Rating Method
     *
     * @param number $val
     * @return void
     */

    public function setRating($val)
    {
        if ($this->rating == $val) {    // user can click on the same rating to reset the value
            $this->rating = 0;
        } else {
            $this->rating = $val;
            $this->ratingError = null;
        }
    }


    /**
     * Store the Review and RevieRelationship
     *
     * @return void
     */
    public function store()
    {
        if(!auth()->user()){
            return redirect('/login');
        }
        if ($this->rating ==  0) {
            $this->ratingError = "The rating field is required";
            $this->validate();
            return;
        } 
        $this->validate();
        $review = new Review;
        $review->comment = $this->comment;
        $review->rating = $this->rating;
        $review->content_type = $this->content_type;
        $review->status = 0;
        $review->product_id = $this->product_id;
        $review->save();
        $review_relationship = new ReviewRelationship;
        $review_relationship->review()->associate($review);
        $product = Product::find($this->product_id);
        $review_relationship->reviewable()->associate($product);
        $review_relationship->creator()->associate(auth()->user());
        $review_relationship->save();
        $this->hideModal();
        $this->emit('review-stored');
        $this->emit('success-notification', "Review successfully created!");
    }

    public function showModal () {
        $this->open = true;
    }

    public function hideModal () {
        $this->open = false;
        $this->comment = null;
        $this->rating = 0;
    }
}
