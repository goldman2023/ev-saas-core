<?php

namespace App\Http\Livewire\Feed\Elements\Shop;

use Livewire\Component;
use App\Traits\Livewire\DispatchSupport;

class ShopArchiveFilters extends Component
{
    use DispatchSupport;
    
    

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('livewire.feed.elements.shop.shop-archive-filters');
    }
}
