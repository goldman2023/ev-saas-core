<?php

namespace App\Http\Livewire\Feed;

use Illuminate\Support\Facades\Session;
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
    public $type = 'recent';

    public function mount()
    {
        $this->perPage = 10;
    }

    public function render()
    {
        $data = Activity::whereNotIn('description', ['viewed', 'deleted', 'updated', 'liked', 'add_to_cart'])
            ->whereNotIn('subject_type', ['Spatie\Activitylog\Models\Activity', 'App/Models/User'])->whereHas('subject');
        if ($this->type == "recent") {
            $data = $data->orderBy('id', 'desc');
        } elseif ($this->type == 'trending') {
            $data = $data->orderBy('impressions', 'desc');
        }
        $data = $data->paginate($this->perPage);
        $this->loading = false;

        $this->hasMorePages = $data->hasMorePages();


        return view('livewire.feed.feed-list', [
            'activities' => $data,
            'hasMorePages' => $this->hasMorePages
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

        /* $sync_impressions = Session::get('user.impressions_queue');
        foreach ($sync_impressions as $impression) {
            $activity = Activity::find($impression);


            $activity->impressions++;
            $activity->save();
        }

        // Reset the queue
        Session::forget('user.impressions_queue'); */
    }

    public function loadType($type)
    {
        $this->type = $type;
    }
}
