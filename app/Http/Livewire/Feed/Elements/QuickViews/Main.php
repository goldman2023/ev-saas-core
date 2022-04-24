<?php

namespace App\Http\Livewire\Feed\Elements\QuickViews;

use Livewire\Component;

class Main extends Component
{
    public $item;

    public $type = 'simple';

    public function mount($item)
    {
        $this->item = $item;
        if (class_basename($this->item->subject) == 'Product') {
            $this->type = 'product';
        }
    }

    public function render()
    {
        return view('livewire.feed.elements.quick-views.main');
    }
}
