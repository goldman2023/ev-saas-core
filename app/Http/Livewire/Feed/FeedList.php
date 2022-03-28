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
    public $readyToLoad = false;
    public $loading = false;

    public function mount()
    {
        $this->perPage = 10;
    }

    public function render()
    {
        $data = Activity::whereNotIn('description', ['viewed', 'deleted'])->orderBy('created_at', 'desc')->paginate($this->perPage);
        $this->loading = false;

        return view('livewire.feed.feed-list', [
            'activities' => $data,
        ]);
    }

    public function loadInit()
    {
        $this->readyToLoad  = true;
    }

    public function loadMore()
    {
        $this->loading = true;
        $this->perPage += 10;
    }
}
