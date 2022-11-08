<?php

namespace App\Http\Livewire\Dashboard\Forms\BlogPosts;

use App\Enums\StatusEnum;
use App\Enums\BlogPostTypeEnum;
use App\Facades\MyShop;
use App\Models\Address;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Plan;
use App\Models\ShopAddress;
use App\Models\User;
use App\Models\CoreMeta;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\HasCategories;
use App\Traits\Livewire\HasCoreMeta;
use App\Traits\Livewire\RulesSets;
use Categories;
use DB;
use EVS;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Permissions;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;

class BlogPostForm extends Component
{
    use RulesSets;
    use DispatchSupport;
    use HasCategories;
    use HasCoreMeta;

    public $blogPost;

    public $selectedPlans;

    public $model_core_meta;

    public $is_update;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($blogPost = null)
    {
        $this->blogPost = empty($blogPost) ? (new BlogPost())->load(['uploads']) : $blogPost;
        $this->is_update = isset($this->blogPost->id) && ! empty($this->blogPost->id);

        if (! $this->is_update) {
            $this->blogPost->status = StatusEnum::draft()->value;
            $this->blogPost->type = BlogPostTypeEnum::blog()->value;
        }

        $this->initCategories($this->blogPost);

        $this->selectedPlans = $this->blogPost->plans->keyBy('id')->map(fn ($item) => $item->title);

        $this->model_core_meta = CoreMeta::getMeta($blogPost?->core_meta ?? [], BlogPost::class, true);

    }

    protected function getRuleSet($set = null)
    {
        $rulesSets = collect([
            'meta' => [
                'model_core_meta.portfolio_link' => 'nullable',
            ],
            'core_meta' => [
                'core_meta' => '',
            ]
        ]);

        return empty($set) || $set === 'all' ? $rulesSets : $rulesSets->get($set);
    }

    protected function rules()
    {
        return [
            'selected_categories' => 'required',
            'blogPost.type' => [Rule::in(BlogPostTypeEnum::toValues('archived'))],
            'blogPost.thumbnail' => ['if_id_exists:App\Models\Upload,id'],
            'blogPost.cover' => ['if_id_exists:App\Models\Upload,id,true'],
            'blogPost.name' => 'required|min:10',
            'blogPost.subscription_only' => [],
            'blogPost.status' => [Rule::in(StatusEnum::toValues('archived'))],
            'blogPost.excerpt' => 'required|min:10',
            'blogPost.content' => 'required|min:10',
            'blogPost.content_structure' => 'required',
            'blogPost.gallery' => [''],
            'blogPost.meta_title' => [''],
            'blogPost.meta_keywords' => [''],
            'blogPost.meta_description' => [''],
            'blogPost.meta_img' => ['if_id_exists:App\Models\Upload,id,true'],
        ];
    }

    protected function messages()
    {
        return [
            'selected_categories.required' => translate('At least one category is required.'),

            'blogPost.thumbnail.if_id_exists' => translate('Selected thumbnail does not exist in Media Library. Please select again.'),
            'blogPost.cover.if_id_exists' => translate('Selected cover does not exist in Media Library. Please select again.'),
            'blogPost.meta_img.if_id_exists' => translate('Selected meta image does not exist in Media Library. Please select again.'),

            'blogPost.name.required' => translate('Title is required'),
            'blogPost.name.min' => translate('Minimum title length is :min'),

            'blogPost.excerpt.required' => translate('Excerpt is required'),
            'blogPost.excerpt.min' => translate('Minimum excerpt length is :min'),

            'blogPost.content.required' => translate('Content is required'),
            'blogPost.content.min' => translate('Minimum content length is :min'),

            'blogPost.status.in' => translate('Status must be one of the following:').' '.implode(', ', StatusEnum::toLabels('archived')),
            'blogPost.subscription_only' => translate('Subscription only must be either true or false'),
        ];
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initSlugGeneration');
        $this->dispatchBrowserEvent('init-form');
    }

    // public function hydrate() {
    //     dd($this->blogPost);
    // }

    public function saveBlogPost()
    {
        $msg = '';

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

            // If user has no permissions to publish the post, change the status to Pending (all pending blog posts will be visible to users who can publish the Blog Post)
            if (! Permissions::canAccess(User::$non_customer_user_types, ['publish_post'], false)) {
                $this->blogPost->status = StatusEnum::pending();
                $msg = translate('Blog post status is set to '.(StatusEnum::pending()->value).' because you don\'t have enough Permissions to publish it right away.');
            }

            $this->blogPost->save();

            // Sync gallery and uploads
            $this->blogPost->syncUploads();

            // Sync authors
            $this->blogPost->authors()->syncWithoutDetaching(auth()->user()); //

            $this->saveModelCoreMeta();

            // Save Other Product Core Meta
            /* TODO: Fix Saving Core meta, core meta fields are missing in the form, so add those and uncoment */
            $this->setCoreMeta($this->blogPost);

            // TODO: Make a function to relate blog post and plans in order to make posts subscription_only

            // Set Categories
            $this->setCategories($this->blogPost);

            // TODO: Determine which package to use for Translations! Set Translations...
//
            DB::commit();



            if ($this->is_update) {
                $this->inform(translate('Blog post successfully updated!'), $msg, 'success');
            } else {
                $this->inform(translate('Blog post successfully created!'), $msg, 'success');
            }

            if (!$this->is_update) {
                return redirect()->route('blog.post.edit', $this->blogPost->id);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            if ($this->is_update) {
                $this->dispatchGeneralError(translate('There was an error while updating a blog post...Please try again.'));
                $this->inform(translate('There was an error while updating a blog post...Please try again.'), $e->getMessage(), 'fail');
            } else {
                $this->dispatchGeneralError(translate('There was an error while creating a blog post...Please try again.'));
                $this->inform(translate('There was an error while creating a blog post...Please try again.'), $e->getMessage(), 'fail');
            }
        }
    }

    public function removeBlogPost()
    {
//        $address = app($this->currentAddress::class)->find($this->currentAddress->id)->fill($this->currentAddress->toArray());
//        $address->remove();
    }

    public function render()
    {
        return view('livewire.dashboard.forms.blog-posts.blog-post-form');
    }

    // TODO: Move this to Trait and replace this function in PlanForm and in ProductForm
    protected function saveModelCoreMeta()
    {
        return true;
        foreach (collect($this->getRuleSet('meta'))->filter(fn ($item, $key) => str_starts_with($key, 'model_core_meta')) as $key => $value) {
            $core_meta_key = explode('.', $key)[1]; // get the part after `core_meta.`

            if (! empty($core_meta_key) && $core_meta_key !== '*') {
                if(array_key_exists($core_meta_key, is_array($this->model_core_meta) ? $this->model_core_meta : $this->model_core_meta->toArray())) {
                    $new_value = castValueForSave($core_meta_key, $this->model_core_meta[$core_meta_key], CoreMeta::metaBlogPostDataTypes());

                    try {
                        CoreMeta::updateOrCreate(
                            ['subject_id' => $this->blogPost->id, 'subject_type' => $this->blogPost::class, 'key' => $core_meta_key],
                            ['value' => $new_value]
                        );
                    } catch(\Exception $e) {
                        Log::error($e->getMessage());
                        // dd($this->model_core_meta[$core_meta_key]);
                    }
                }
            }
        }
    }
}
