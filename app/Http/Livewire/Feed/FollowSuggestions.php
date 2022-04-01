<?php

namespace App\Http\Livewire\Feed;

use App\Models\Shop;
use Livewire\Component;

class FollowSuggestions extends Component
{

    public $accounts;
    public $readyToLoad = false;

    public function mount()
    {
        $currently_liked = auth()->user()->following();
        $this->accounts = Shop::where('id', '!=', auth()->user()->id)->take(5)->get();
    }

    public function render()
    {
        return view('livewire.feed.follow-suggestions');
    }

    public function loadInit()
    {
        $this->readyToLoad  = true;
    }
}
