<?php

namespace App\Http\Livewire\Actions;

use App\Models\Wishlist;
use App\Notifications\WishlistItemAdded;
use Livewire\Component;

class WishlistButton extends Component
{
    public $product;
    public $added = false;

    public function mount($product)
    {
        $this->product = $product;
        $this->added = $this->checkIfProductExistsInWishlist();
    }

    public function render()
    {
        return view('livewire.actions.wishlist-button');
    }

    public function addToWishlist()
    {
        if($this->checkIfProductExistsInWishlist()) {
            /* If product exists, toggle the database entry - delete if exists, create if does not exist */
            if(auth()->user()) {
                $item = Wishlist::where('subject_id', $this->product->id)
                    ->where('user_id', auth()->user()->id)
                    ->first()->delete();
            } else {
                $item = Wishlist::where('subject_id', $this->product->id)
                    ->where('session_id', session()->getId())
                    ->first()->delete();
            }
        } else {
            $item =  new Wishlist();
            $item->subject_id = $this->product->id;
            if(auth()->user()) {
                $item->user_id = auth()->user()->id;
                $this->product->user->notify(new WishlistItemAdded($item));

            } else {
                $item->session_id = session()->getId();
            }

            $item->save();

            $this->emit('addedToWishlist');
        }

        $this->added = $this->checkIfProductExistsInWishlist();

    }

    public function checkIfProductExistsInWishlist() {
        if(auth()->user()) {
            $item = Wishlist::where('subject_id', $this->product->id)
                ->where('user_id', auth()->user()->id)
                ->first();
        } else {
            $item = Wishlist::where('subject_id', $this->product->id)
                ->where('session_id', session()->getId())
                ->first();
        }

        if($item) {
            return true;
        } else {
            return false;
        }
    }
}
