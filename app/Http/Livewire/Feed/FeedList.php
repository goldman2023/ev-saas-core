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
        $data = Activity::
            whereNotIn('description', ['viewed', 'deleted', 'updated', 'liked'])
            ->whereNotIn('subject_type', ['Spatie\Activitylog\Models\Activity', 'App/Models/User'])
            ->where('causer_id', '<>', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
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

    public function track_impression($id)
    {
        $activity = Activity::find($id);
        $activity->impressions++;
        $activity->save();
    }
}
