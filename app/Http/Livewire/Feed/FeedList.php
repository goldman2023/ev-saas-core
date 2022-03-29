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
    public $type = 'recent';

    public function mount()
    {
        $this->perPage = 10;
    }

    public function render()
    {
        $data = Activity::
            whereNotIn('description', ['viewed', 'deleted', 'updated', 'liked'])
            ->whereNotIn('subject_type', ['Spatie\Activitylog\Models\Activity', 'App/Models/User'])
            ->where('causer_id', '<>', auth()->user()->id);

            if($this->type == "recent"){
                $data = $data->orderBy('id', 'desc');
            } elseif($this->type == 'trending') {
                $data = $data->orderBy('impressions', 'desc');
            }
            $data = $data->paginate($this->perPage);
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

    public function loadType($type)
    {
        $this->type = $type;
    }


}
