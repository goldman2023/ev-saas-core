<?php

namespace App\Http\Livewire\Feed\Elements;

use Exception;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use Throwable;

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


        /* Check if subject class instance exists */
        try {
            if (! $item->has('subject') || empty($item->subject)) {
                $this->ignore = true;

                return false;
            }
        } catch(\Throwable $e) {
            return false;
        }


        if (!empty($item->properties['action'] ?? null) ) {
            $this->ignore = true;
        }

        $this->item = $item;
        // $this->likes = Activity::where('subject_type', 'Spatie\Activitylog\Models\Activity')
        //     ->where('description', 'liked')
        //     ->where('subject_id', $item->id)
        //     ->count();

        if (empty($item->causer)) {
            $this->ignore = true;
        }

        // Following chain is prevented in Activity query builder itself with proper query clauses
        if ($item->subject_type == \App\Models\Product::class) {
            $this->product = $item->subject;

            if ($this->product->status == 'draft') {
                $this->ignore = true;
            }
        } elseif ($item->subject_type == \App\Models\Wishlist::class) {
            $this->ignore = true;
            if (empty($item->subject->subject)) {
                $this->ignore = true;
            } else {
                // $this->product = $item->subject->subject;
            }
        } elseif (($item->subject_type == \App\Models\SocialComment::class)) {
            $this->ignore = true;
        } elseif (($item->subject_type == \App\Models\User::class)) {
            $this->ignore = true;
        } elseif (($item->subject_type == \App\Models\Shop::class)) {
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
