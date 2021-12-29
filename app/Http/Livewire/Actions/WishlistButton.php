<?php

namespace App\Http\Livewire\Actions;

use App\Models\Product;
use App\Models\Wishlist;
use App\Notifications\WishlistItemAdded;
use Livewire\Component;

class WishlistButton extends Component
{
    public $object;
    public $added = false;
    public $model_class;

    public function mount($object, $subject_type = 'App\Models\Product')
    {
        $this->model_class = $object->getMorphClass();
        $this->object = $object;
        $this->added = $this->checkIfProductExistsInWishlist();

    }

    public function render()
    {
        return view('livewire.actions.wishlist-button');
    }

    public function addToWishlist()
    {
        if ($this->checkIfProductExistsInWishlist()) {
            /* If product exists, toggle the database entry - delete if exists, create if does not exist */
            if (auth()->user()) {
                $item = Wishlist::where('subject_id', $this->object->id)
                    ->where('subject_type', $this->model_class)
                    ->where('user_id', auth()->user()->id)
                    ->first()->delete();
            } else {
                $item = Wishlist::where('subject_id', $this->object->id)
                    ->where('subject_type', $this->model_class)
                    ->where('session_id', session()->getId())
                    ->first()->delete();
            }
        } else {
            $item =  new Wishlist();
            $item->subject_type = $this->model_class;
            $item->subject_id = $this->object->id;
            if (auth()->user()) {
                $item->user_id = auth()->user()->id;
                /* TODO: I think notifications should be defined in events on Wishlist item created outside of controller/component logic
                    so we can have clear entry points for all notificaitons */
                // $this->object->user->notify(new WishlistItemAdded($item));

            } else {
                $item->session_id = session()->getId();
            }

            $item->save();

            $this->emit('addedToWishlist');
        }

        $this->added = $this->checkIfProductExistsInWishlist();
    }

    public function checkIfProductExistsInWishlist()
    {
        if (auth()->user()) {
            $item = Wishlist::where('subject_id', $this->object->id)
                ->where('subject_type', $this->model_class)
                ->where('user_id', auth()->user()->id)
                ->first();
        } else {
            $item = Wishlist::where('subject_id', $this->object->id)
                ->where('subject_type', $this->model_class)
                ->where('session_id', session()->getId())
                ->first();
        }

        if ($item) {
            return true;
        } else {
            return false;
        }
    }
}
