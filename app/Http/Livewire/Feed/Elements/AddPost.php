<?php

namespace App\Http\Livewire\Feed\Elements;

use App\Facades\MyShop;
use App\Models\BlogPost;
use App\Traits\Livewire\RulesSets;
use App\Traits\Livewire\DispatchSupport;
use Livewire\Component;
use DB;

class AddPost extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $post;

    protected function rules()
    {
        return [
            'post.name' => '',
            'post.type' => '',
            'post.excerpt' => '',
            'post.content' => 'required',
            'post.thumbnail' => 'if_id_exists:App\Models\Upload,id,true',
        ];
    }

    protected function messages()
    {
        return [
            'post.content' => translate('Your post is empty!')
        ];
    }

    public function mount() {
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.feed.elements.add-post');
    }

    public function addFeedPost()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

        DB::beginTransaction();

        try{
            $this->post->name = 'Feed Post Post by '.auth()->user()->name;
            $this->post->excerpt = $this->post->content;
    
            if (MyShop::getShop()) {
                $this->post->shop_id = MyShop::getShopID();
                $this->post->user_id = auth()->user()->id;
            } else {
                $this->post->user_id = auth()->user()->id;
            }
    
            $this->post->save();
            $this->post->syncUploads();

            DB::commit();

            $this->emit('newPostAdded', $this->post->id);

            $this->inform(translate('Shared sucesfully!'), '', 'success');
            $this->dispatchBrowserEvent('reset-image-selector');

            $this->resetForm();
        } catch(\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('Could not share a post...Please try again.'));
            $this->inform(translate('Could not share a post...Please try again.'), '', 'fail');
        }
        
    }

    public function resetForm()
    {
        $this->post = new BlogPost();
        $this->post->type = 'post';
    }
}
