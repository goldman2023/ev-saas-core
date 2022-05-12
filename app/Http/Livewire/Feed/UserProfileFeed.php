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


class UserProfileFeed extends Component
{
    public $type = 'activity';

    public $user = null;

    protected $queryString = ['type' => ['except' => '', 'as' => 'tab']];

    protected $listeners = [
        // 'newSocialPostAdded' => 'prependNewSocialPost'
    ];

    public function mount($user = null)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.feed.user-profile-feed');
    }


    public function loadType($type)
    {
        $this->type = $type;        
    }
}
