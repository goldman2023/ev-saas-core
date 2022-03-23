<?php

namespace App\Http\Livewire\Feed;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class FeedList extends Component
{
    use WithPagination;

    protected $activitiesObjects;
    public $perPage = 10;
    public $links;

    public function mount()
    {
        $this->perPage = 10;
    }

    public function render()
    {

        return view('livewire.feed.feed-list', [
            'activities' => Activity::whereNotIn('description', ['viewed', 'deleted'])->orderBy('created_at', 'desc')->paginate($this->perPage),
        ]);
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }
}
