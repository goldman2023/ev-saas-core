<?php

namespace App\Http\Livewire\Panels;

use App\Support\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class WishlistFlyout extends Component
{
    public $wishlists;

    public $class;

    public $per_page = 8;

    public $page = 1;

    protected $listeners = [
        'addedSocialAction' => 'resetAfterAdded',
        'removedSocialAction' => 'resetAfterRemoved',
    ];

    public function mount($class = ''): void
    {
        $this->wishlists = $this->getData();
        $this->class = $class;
    }

    public function getData()
    {
        return auth()->user()?->wishlists()->where('subject_type', \App\Models\Product::class)->orderBy('created_at', 'desc')->limit($this->per_page)->offset(($this->page - 1) * $this->per_page)->get();
    }

    public function loadMore(): void
    {
        $this->page++;

        if ($data = $this->getData()) {
            $this->wishlists = $this->wishlists->merge($data);
        }
    }

    public function resetAfterAdded($event_data)
    {
        if($event_data['action'] === 'wishlist') {
            $this->page = 1;
            $this->wishlists = $this->getData();
        }
    }

    public function resetAfterRemoved($event_data)
    {
        if($event_data['action'] === 'wishlist') {
            if ($this->wishlists->filter(fn ($item) => $item->id === $event_data['model_id'] && $item::class === $event_data['model_class'])
                ->first()->id ?? null) {
                // Removed element is currently in Wishlist frontend => reset the wishlist!
                $this->resetAfterAdded();
            }
        }
        
    }

    public function render()
    {
        if (session('style_framework') === 'tailwind') {
            return view('livewire.tailwind.panels.wishlist-flyout');
        }

        return view('livewire.bootstrap.panels.wishlist-flyout');
    }
}
