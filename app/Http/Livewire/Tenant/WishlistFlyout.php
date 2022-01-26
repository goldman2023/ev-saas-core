<?php

namespace App\Http\Livewire\Tenant;

use App\Support\Eloquent\Collection;
use Livewire\WithPagination;
use Livewire\Component;

class WishlistFlyout extends Component
{

    public $wishlists;
    public $class;
    public $per_page = 8;
    public $page = 1;

    protected $listeners = [
        'addedToWishlist' => 'resetAfterAdded',
        'removedFromWishlist' => 'resetAfterRemoved'
    ];

    public function mount($class = ''): void
    {
        $this->wishlists = $this->getData();
        $this->class = $class;

    }

    public function getData() {
        return auth()->user()?->wishlists()->orderBy('created_at', 'desc')->limit($this->per_page)->offset(($this->page - 1) * $this->per_page)->get();
    }

    public function loadMore(): void
    {
        ++$this->page;

        if($data = $this->getData()) {
            $this->wishlists = $this->wishlists->merge($data);
        }
    }

    public function resetAfterAdded() {
        $this->page = 1;
        $this->wishlists = $this->getData();
    }

    public function resetAfterRemoved($model_id = null) {
        if($this->wishlists->filter(fn($item) => $item->id === $model_id)->first()->id ?? null) {
            // Removed element is currently in Wishlist frontend => reset the wishlist!
            $this->resetAfterAdded();
        }
    }

    public function render()
    {
        return view('livewire.tenant.wishlist-flyout');
    }
}