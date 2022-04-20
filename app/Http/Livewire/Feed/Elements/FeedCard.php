<?php

namespace App\Http\Livewire\Feed\Elements;

use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class FeedCard extends Component
{
    public $item;

    public $product;

    public $ignore = false;

    public $likes = 0;

    public $showComments = false;

    public function mount($item)
    {
        $this->ignore = false;

        if (! $item->has('subject') || empty($item->subject)) {
            $this->ignore = true;

            return false;
        }

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
            if ($this->product->status == 'draft') {
                // $this->ignore = true;
            }
        } elseif ($item->subject_type == 'App\Models\Wishlist') {
            $this->ignore = true;
            if (empty($item->subject->subject)) {
                $this->ignore = true;
            } else {
                // $this->product = $item->subject->subject;
            }
        } elseif (($item->subject_type == 'App\Models\SocialComment')) {
            $this->ignore = true;
        }
    }

    public function toggle_comments()
    {
        $this->showComments = ! $this->showComments;
    }

    public function render()
    {
        return view('livewire.feed.elements.feed-card', [
            'ignore' => $this->ignore,
        ]);
    }

    public function track_impression($id)
    {
        /* TODO: Push this data to local storage */
        // Session::push('user.impressions_queue', $id);
    }
}
