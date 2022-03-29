<?php

namespace App\Http\Livewire\Feed\Elements;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class FeedCard extends Component
{

    public $item;
    public $product;
    public $ignore = false;
    public $likes = 0;
    public function mount($item)
    {

        $this->ignore = false;

        $this->item = $item;
        $this->likes = Activity::where('subject_type', 'Spatie\Activitylog\Models\Activity')
            ->where('description', 'liked')
            ->where('subject_id', $item->id)
            ->count();

        if (empty($item->causer)) {
            $this->ignore = true;
        }

        if ($item->subject_type == 'App\Models\Product') {
            $this->product = $item->subject;
        } elseif ($item->subject_type == 'App\Models\Wishlist') {
            if (empty($item->subject->subject)) {
                // $this->ignore = true;
            } else {
                $this->product = $item->subject->subject;
            }
        }
    }

    public function render()
    {

        return view('livewire.feed.elements.feed-card', [
            'ignore' => $this->ignore
        ]);
    }

    public function track_impression($id)
    {
        $activity = Activity::find($id);
        $activity->impressions++;
        $activity->save();
    }
}
