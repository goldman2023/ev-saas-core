<?php

namespace App\Http\Livewire\Feed;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class FeedList extends Component
{
    public $activities;
    public $perPage = 10;

    public function mount()
    {
        $this->perPage = 10;
        $this->activities = Activity::take(50)->whereNotIn('description', ['viewed', 'deleted'])->orderBy('created_at', 'desc')->get();
    }
    public function render()
    {
        return view('livewire.feed.feed-list', [
            'activities' => $this->activities,
        ]);
    }
}
