<?php

namespace App\Http\Livewire\Feed\Elements\Shop;

use Livewire\Component;
use App\Traits\Livewire\DispatchSupport;

class ShopArchiveFilters extends Component
{
    use DispatchSupport;

    public $hide_filters;

    public function mount($hide = false) {
        $this->hide_filters = $hide;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $this->hide_filters = false;
        return view('livewire.feed.elements.shop.shop-archive-filters');
    }
}
