<?php

namespace App\Http\Livewire\Feed\Elements;

use Livewire\Component;

class ShopCard extends Component
{
    public $shop;

    public function mount($shop)
    {
        $this->shop = $shop;
    }

    public function render()
    {
        return view('livewire.feed.elements.shop-card');
    }
}
