<?php

namespace App\Http\Livewire\Feed\Elements;

use Livewire\Component;

class FeedCardEmptyState extends Component
{
    public $variation = 'default';
    public $dynamic_class = 'px-4 py-6 shadow sm:p-6';

    public function mount($variation = 'default') {
        $this->variation = $variation;
        if($this->variation == 'small') {
            $this->dynamic_class = 'px-2 py-3 shadow sm:p-3';
        }
    }
    public function render()
    {
        return view('livewire.feed.elements.feed-card-empty-state');
    }
}
