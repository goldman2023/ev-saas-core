<?php

namespace App\Http\Livewire\Feed\Elements;

use Livewire\Component;

class ProductCard extends Component
{
    public $product;

    public function mount($product) {
        $this->product = $product;
    }
    public function render()
    {
        return view('livewire.feed.elements.product-card');
    }
}
