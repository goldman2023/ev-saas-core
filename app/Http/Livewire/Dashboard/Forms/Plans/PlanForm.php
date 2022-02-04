<?php

namespace App\Http\Livewire\Dashboard\Forms\BlogPosts;

use App\Enums\StatusEnum;
use App\Facades\MyShop;
use App\Models\Address;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Plan;
use App\Models\ShopAddress;
use App\Models\User;
use App\Traits\Livewire\DispatchSupport;
use DB;
use EVS;
use Categories;
use Illuminate\Validation\Rule;
use Purifier;
use Permissions;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use App\Traits\Livewire\RulesSets;
use App\Traits\Livewire\HasCategories;

class PlanForm extends Component
{
    use RulesSets;
    use DispatchSupport;
    use HasCategories;

    public $plan;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($plan = null)
    {
        $this->plan = empty($plan) ? new Plan() : $plan;

        $this->initCategories($this->plan);
    }

    protected function rules()
    {
        return [
            'selected_categories' => 'required',
            'plan.*' => [],
            'plan.id' => [],
            'plan.thumbnail' => ['if_id_exists:App\Models\Upload,id'],
            'plan.cover' => ['if_id_exists:App\Models\Upload,id,true'],
            'plan.title' => 'required|min:10',
            'blogPost.' => [],
            'plan.status' => [Rule::in(StatusEnum::toValues('archived'))],
            'plan.excerpt' => 'required|min:10',
            'plan.content' => 'required|min:10',
            'plan.gallery' => [''],
            'plan.meta_title' => [''],
            'plan.meta_keywords' => [''],
            'plan.meta_description' => [''],
            'plan.meta_img' => ['if_id_exists:App\Models\Upload,id,true'],
        ];
    }


    protected function messages()
    {
        return [
            'blogPost.thumbnail.if_id_exists' => translate('Selected thumbnail does not exist in Media Library. Please select again.'),
            'blogPost.cover.if_id_exists' => translate('Selected cover does not exist in Media Library. Please select again.'),
            'plan.meta_img.if_id_exists' => translate('Selected meta image does not exist in Media Library. Please select again.'),

            'blogPost.title.required' => translate('Title is required'),
            'blogPost.title.min' => translate('Minimum title length is :min'),

            'blogPost.excerpt.required' => translate('Excerpt is required'),
            'blogPost.excerpt.min' => translate('Minimum excerpt length is :min'),

            'blogPost.content.required' => translate('Content is required'),
            'blogPost.content.min' => translate('Minimum content length is :min'),

            'blogPost.status.in' => translate('Status must be one of the following:').' '.implode(', ',StatusEnum::toLabels('archived')),
            'blogPost.subscription_only' => translate('Subscription only must be either true or false'),
        ];
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initSlugGeneration');
        $this->dispatchBrowserEvent('initBlogPostForm');
    }

    public function saveBlogPost() {
        $msg = '';
        $is_update = isset($this->blogPost->id) && !empty($this->blogPost->id);

        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

        DB::beginTransaction();

        try {
            // Insert or Update BlogPost
            $this->blogPost->subscription_only = (bool) $this->blogPost->subscription_only;
            $this->blogPost->shop_id = MyShop::getShopID();

            // If user has no permissions to publish the post, change the status to Draft
            if(!Permissions::canAccess(User::$non_customer_user_types, ['publish_post'], false)) {
                $this->blogPost->status = StatusEnum::draft();
                $msg = translate('Blog post status is set to '.(StatusEnum::draft()->value).' because you don\'t have enough Permissions to publish it right away.');
            }

            $this->blogPost->save();
            $this->blogPost->syncUploads();

            // Set Categories
            $this->setCategories($this->blogPost);

            // TODO: Determine which package to use for Translations! Set Translations...
//
            DB::commit();

            if($is_update) {
                $this->toastify(translate('Blog post successfully updated!').' '.$msg, 'success');
            } else {
                $this->toastify(translate('Blog post successfully created!').' '.$msg, 'success');
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
