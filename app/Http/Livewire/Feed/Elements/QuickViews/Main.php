<?php

namespace App\Http\Livewire\Feed\Elements\QuickViews;

use Livewire\Component;

class Main extends Component
{
    public $item;

    public function mount($item) {
        $this->item = $item;
    }
    public function render()
    {
        return view('livewire.feed.elements.quick-views.main');
    }
}
