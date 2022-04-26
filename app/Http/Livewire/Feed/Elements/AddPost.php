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
        if (! empty($this->content)) {
            $post = new BlogPost();
            $post->name = 'Feed Post Post by '.auth()->user()->name;
            $post->excerpt = $this->content;
            $post->content = $this->content;
            if (MyShop::getShop()) {
                $post->shop_id = MyShop::getShopID();
                $post->user_id = auth()->user()->id;
            } else {
                $post->user_id = auth()->user()->id;
            }
            $post->save();

            $this->resetForm();
            $this->toastify(translate('Shared sucesfully!'), 'success');

            $this->emit('newPostAdded');
        } else {
            $this->toastify(translate('Your post is empty!'), 'danger');
        }
    }

    public function resetForm()
    {
        $this->content = '';
    }
}
