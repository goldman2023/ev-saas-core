<?php

namespace App\Http\Livewire\Actions;

use App\Models\Wishlist;
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
            if(auth()->user()) {
                $item = Wishlist::where('product_id', $this->product->id)
                    ->where('user_id', auth()->user()->id)
                    ->first()->delete();
            } else {
                $item = Wishlist::where('product_id', $this->product->id)
                    ->where('session_id', session()->getId())
                    ->first()->delete();
            }
        } else {
            $item =  new Wishlist();
            $item->product_id = $this->product->id;
            if(auth()->user()) {
                $item->user_id = auth()->user()->id;
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
            $item = Wishlist::where('product_id', $this->product->id)
                ->where('user_id', auth()->user()->id)
                ->first();
        } else {
            $item = Wishlist::where('product_id', $this->product->id)
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
