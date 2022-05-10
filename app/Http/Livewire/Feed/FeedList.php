<?php

namespace App\Http\Livewire\Feed;


use App\Traits\Livewire\WithCursorPagination;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Cursor;
use App\Enums\StatusEnum;
use App\Models\Activity;
use App\Models\BlogPost;
use App\Models\Plan;
use App\Models\Shop;
use App\Models\Product;
use App\Models\SocialPost;
use App\Models\User;
use App\Models\SocialComment;


class FeedList extends Component
{
    use WithCursorPagination;

    public $activities;

    public $links;

    public $readyToLoad = false;

    public $loading = false;

    public $type = 'recent';

    public $my_new_post = null;

    protected $listeners = [
        'newSocialPostAdded' => 'prependNewSocialPost'
    ];

    public function mount($feedType = 'recent')
    {
        $this->perPage = 5;
        $this->activities = new \Illuminate\Database\Eloquent\Collection();
        $this->type = $feedType;
        $this->loadActivities();
    }

    public function render()
    {
        return view('livewire.feed.feed-list');
    }

    public function loadInit()
    {
        $this->readyToLoad = true;
    }

    public function loadActivities()
    {
        if ($this->hasMorePages !== null  && ! $this->hasMorePages) {
            return;
        }

        $activities = Activity::whereIn('description', ['created'])
            ->whereNotIn('subject_type', [Activity::class, User::class, SocialComment::class])
            ->with(['subject' => function ($query) {
                // If you want to add any other nested relation, like comments/likes count etc.
                // $morphTo->morphWith([
                //     BlogPost::class => [''],
                //     Product::class => [''],
                //     Plan::class => [''],
                // ]);
            }])
            ->withCount('comments') // count comments
            ->where(function($query) {
                // Select only those Products/BlogPosts/Plans/Posts where status is published OR any Shop
                $query
                    ->whereHasMorph('subject', [Product::class, BlogPost::class, Plan::class, SocialPost::class], function($query) {
                        $query->published();
                    })
                    ->orWhereHasMorph('subject', [Shop::class]);
            });
        if ($this->type == 'recent') {
            // Use Cursor Pagination for Recent
            $activities = $activities->orderBy('id', 'desc')->cursorPaginate($this->perPage, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
        } elseif ($this->type == 'trending') {
            // Use Offset pagination for Trending
            $activities = $activities->orderBy('impressions', 'desc')->paginate(perPage: $this->perPage, page: $this->page);
            // TODO: There are duplicates when simple pagination is used for some reason!!!!s
        }

        // dd($activities);
        // TODO: WTF???? ->withCount('comments') is not taken into account on data load!...da fuq?
        $this->activities->push(...$activities->items()); // Append paginated activities to `public $this->activities`
        $this->prepareNextPage($activities);


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
        $this->resetPagination();
        
        $this->activities = new \Illuminate\Database\Eloquent\Collection();

        $this->loadActivities();
    }

    public function prependNewSocialPost($post_id) {
        
        $my_new_activity_post = Activity::where([
            'subject_type' => SocialPost::class,
            'subject_id' => $post_id,
            'causer_type' => auth()->user()::class,
            'causer_id' => auth()->user()->id,
        ])->first();
        
        $this->activities->prepend($my_new_activity_post);
    }
}
