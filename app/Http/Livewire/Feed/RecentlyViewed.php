<?php

namespace App\Http\Livewire\Feed;

use Livewire\Component;

class RecentlyViewed extends Component
{
    public $products;

    public function mount()
    {
        $this->products = auth()->user()->recently_viewed_products();
    }

    public function render()
    {
        return view(
            'livewire.feed.recently-viewed',
            [
                'products' => $this->products,
            ]
        );
    }
}
