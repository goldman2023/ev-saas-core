<?php

namespace App\Http\Livewire\Feed\Elements;

use App\Facades\MyShop;
use App\Models\BlogPost;
use App\Traits\Livewire\DispatchSupport;
use Livewire\Component;

class AddPost extends Component
{

    use DispatchSupport;

    public $content;

    public function render()
    {
        return view('livewire.feed.elements.add-post');
    }

    public function addFeedPost()
    {
        $post = new BlogPost();
        $post->title = 'Feed Post Post by' . auth()->user()->name;
        $post->excerpt = $this->content;
        $post->content = $this->content;

        $post->shop_id = MyShop::getShopID();
        $post->save();

        $this->toastify(translate('Shared sucesfully!'), 'success');

        $this->emit('newPostAdded');
    }
}
