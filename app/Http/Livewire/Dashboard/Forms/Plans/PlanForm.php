<?php

namespace App\Http\Livewire\Dashboard\Forms\Plans;

use App\Enums\StatusEnum;
use App\Facades\MyShop;
use App\Models\Address;
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
            'plan.status' => [Rule::in(StatusEnum::toValues('archived'))],
            'plan.excerpt' => 'required|min:10',
            'plan.content' => 'required|min:10',
            'plan.features' => 'required|array',
            'plan.price' => 'required|number',
            'plan.discount' => 'sometimes|number',
            'plan.discount_type' => [Rule::in(DiscountTypeEnum::toValues())],
            'plan.tax' => 'sometimes|number',
            'plan.tax_type' => '',
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
            'plan.thumbnail.if_id_exists' => translate('Selected thumbnail does not exist in Media Library. Please select again.'),
            'plan.cover.if_id_exists' => translate('Selected cover does not exist in Media Library. Please select again.'),
            'plan.meta_img.if_id_exists' => translate('Selected meta image does not exist in Media Library. Please select again.'),

            'plan.title.required' => translate('Title is required'),
            'plan.title.min' => translate('Minimum title length is :min'),

            'plan.excerpt.required' => translate('Excerpt is required'),
            'plan.excerpt.min' => translate('Minimum excerpt length is :min'),

            'plan.content.required' => translate('Content is required'),
            'plan.content.min' => translate('Minimum content length is :min'),

            'plan.status.in' => translate('Status must be one of the following:').' '.StatusEnum::implodedLabels('archived'),
            
            'plan.price.required' => translate('Price is required'),
            'plan.price.number' => translate('Price must be a valid number'),

            'plan.discount.number' => translate('Discount must be a valid number'),
            'plan.discount_type.in' => translate('Discount type must be one of the following:').' '.DiscountTypeEnum::implodedLabels(),

            'plan.tax.number' => translate('Tax must be a valid number'),
        ];
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initSlugGeneration');
        $this->dispatchBrowserEvent('initPlanForm');
    }

    public function savePlan() {
        $msg = '';
        $is_update = isset($this->plan->id) && !empty($this->plan->id);

//         try {
//             $this->validate();
//         } catch (\Illuminate\Validation\ValidationException $e) {
//             $this->dispatchValidationErrors($e);
//             $this->validate();
//         }

//         DB::beginTransaction();

//         try {
//             // Insert or Update plan
//             $this->plan->subscription_only = (bool) $this->plan->subscription_only;
//             $this->plan->shop_id = MyShop::getShopID();

//             // If user has no permissions to publish the post, change the status to Draft
//             if(!Permissions::canAccess(User::$non_customer_user_types, ['publish_post'], false)) {
//                 $this->plan->status = StatusEnum::draft();
//                 $msg = translate('Blog post status is set to '.(StatusEnum::draft()->value).' because you don\'t have enough Permissions to publish it right away.');
//             }

//             $this->plan->save();
//             $this->plan->syncUploads();

//             // Set Categories
//             $this->setCategories($this->plan);

//             // TODO: Determine which package to use for Translations! Set Translations...
// //
//             DB::commit();

//             if($is_update) {
//                 $this->toastify(translate('Blog post successfully updated!').' '.$msg, 'success');
//             } else {
//                 $this->toastify(translate('Blog post successfully created!').' '.$msg, 'success');
//             }
//         } catch(\Exception $e) {
//             DB::rollBack();

//             if($is_update) {
//                 $this->dispatchGeneralError(translate('There was an error while updating a blog post...Please try again.'));
//             } else {
//                 $this->dispatchGeneralError(translate('There was an error while creating a blog post...Please try again.'));
//             }

//         }
    }

    public function removePlan() {
//        $address = app($this->currentAddress::class)->find($this->currentAddress->id)->fill($this->currentAddress->toArray());
//        $address->remove();
    }

    public function render()
    {
        return view('livewire.dashboard.forms.plans.plan-form');
    }
}
