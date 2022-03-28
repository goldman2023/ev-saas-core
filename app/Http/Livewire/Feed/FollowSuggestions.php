<?php

namespace App\Http\Livewire\Feed;

use App\Models\User;
use Livewire\Component;

class FollowSuggestions extends Component
{

    public $accounts;

    public function mount() {
        $this->accounts = User::where('id', '!=', auth()->user()->id)->take(5)->get();
    }

    public function render()
    {
        return view('livewire.feed.follow-suggestions');
    }
}
