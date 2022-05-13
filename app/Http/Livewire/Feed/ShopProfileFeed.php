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


class ShopProfileFeed extends Component
{
    public $type = 'products'; // activity/about/products/articles

    public $shop = null;

    protected $queryString = ['type' => ['except' => '', 'as' => 'tab']];

    protected $listeners = [
        // 'newSocialPostAdded' => 'prependNewSocialPost'
    ];

    public function mount($shop = null)
    {
        $this->shop = $shop;
    }

    public function render()
    {
        return view('livewire.feed.shop-profile-feed');
    }


    public function loadType($type)
    {
        $this->type = $type;        
    }
}
