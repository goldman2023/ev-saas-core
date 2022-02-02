<?php

namespace App\Http\Livewire\Dashboard\Forms\BlogPosts;

use App\Facades\MyShop;
use App\Models\Address;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\ShopAddress;
use App\Traits\Livewire\DispatchSupport;
use DB;
use EVS;
use Categories;
use Illuminate\Validation\Rule;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use App\Traits\Livewire\RulesSets;

class BlogPostForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $blog_post;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($blog_post = null)
    {
        $this->blog_post = empty($blog_post) ? new BlogPost() : $blog_post;
    }

    protected function rules()
    {
        return [
            'blog_post.*' => [],
            'blog_post.id' => [],
            'blog_post.thumbnail' => ['if_id_exists:App\Models\Upload,id'],
            'blog_post.cover' => ['if_id_exists:App\Models\Upload,id,true'],
            'blog_post.title' => 'required|min:10',
            'blog_post.subscription_only' => ['required'],
            'blog_post.status' => [Rule::in(BlogPost::STATUSES)],
            'blog_post.excerpt' => 'required|min:10',
            'blog_post.content' => 'required|min:10',
            'blog_post.gallery' => [''],
            'blog_post.meta_title' => [''],
            'blog_post.meta_keywords' => [''],
            'blog_post.meta_description' => [''],
            'blog_post.meta_img' => ['if_id_exists:App\Models\Upload,id,true'],
        ];
    }


    protected function messages()
    {
        return [
            'blog_post.thumbnail.if_id_exists' => translate('Selected thumbnail does not exist in Media Library. Please select again.'),
            'blog_post.cover.if_id_exists' => translate('Selected cover does not exist in Media Library. Please select again.'),
            'blog_post.meta_img.if_id_exists' => translate('Selected meta image does not exist in Media Library. Please select again.'),

            'blog_post.title.required' => translate('Title is required'),
            'blog_post.title.min' => translate('Minimum title length is :min'),

            'blog_post.excerpt.required' => translate('Excerpt is required'),
            'blog_post.excerpt.min' => translate('Minimum excerpt length is :min'),

            'blog_post.content.required' => translate('Content is required'),
            'blog_post.content.min' => translate('Minimum content length is :min'),

            'blog_post.status.in' => translate('Status must be one of the following:').' '.implode(',',BlogPost::STATUSES),
            'blog_post.subscription_only' => translate('Subscription only must be either true or false'),
        ];
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initBlogPostForm');
    }

    public function saveBlogPost() {
        $is_update = isset($this->blog_post->id) && !empty($this->blog_post->id);

        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

        DB::beginTransaction();

        try {
//            // Update address
//            if(empty($this->category->parent_id)) {
//                $this->category->parent_id = null;
//            }
//            $this->category->level = \Categories::getCategoryLevel($this->category);
//            $this->category->save();
//            $this->category->syncUploads();
//
//            DB::commit();

            if($is_update) {
                $this->toastify('Blog post successfully updated!', 'success');
            } else {
                $this->toastify('Blog post successfully created!', 'success');
            }
        } catch(\Exception $e) {
            DB::rollBack();

            if($is_update) {
                $this->dispatchGeneralError(translate('There was an error while updating a blog post...Please try again.'));
            } else {
                $this->dispatchGeneralError(translate('There was an error while creating a blog post...Please try again.'));
            }

        }
    }

    public function removeBlogPost() {
//        $address = app($this->currentAddress::class)->find($this->currentAddress->id)->fill($this->currentAddress->toArray());
//        $address->remove();
    }

    public function render()
    {
        return view('livewire.dashboard.forms.blog-posts.blog-post-form');
    }
}
