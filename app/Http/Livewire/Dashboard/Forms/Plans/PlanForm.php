<?php

namespace App\Http\Livewire\Dashboard\Forms\Plans;

use App\Enums\StatusEnum;
use App\Enums\AmountPercentTypeEnum;
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
use FX;
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
    public $is_update;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($plan = null)
    {
        $this->plan = empty($plan) ? new Plan() : $plan;
        $this->is_update = isset($this->plan->id) && !empty($this->plan->id);
        
        if(!$this->is_update) {
            $this->plan->base_currency = FX::getCurrency()->code;
            $this->plan->discount_type = AmountPercentTypeEnum::amount()->value;
            $this->plan->tax_type = AmountPercentTypeEnum::amount()->value;
        }

        $this->initCategories($this->plan);
    }

    protected function rules()
    {
        return [
            'selected_categories' => 'required',
            'plan.thumbnail' => ['if_id_exists:App\Models\Upload,id'],
            'plan.cover' => ['if_id_exists:App\Models\Upload,id,true'],
            'plan.title' => 'required|min:10',
            'plan.status' => [Rule::in(StatusEnum::toValues('archived'))],
            'plan.excerpt' => 'required|min:10',
            // 'plan.content' => 'required|min:10',
            'plan.features' => 'required|array',
            'plan.base_currency' => [Rule::in(FX::getAllCurrencies()->map(fn($item) => $item->code)->toArray())],
            'plan.price' => 'required|numeric',
            'plan.discount' => 'sometimes|numeric',
            'plan.discount_type' => [Rule::in(AmountPercentTypeEnum::toValues())],
            'plan.tax' => 'sometimes|numeric',
            'plan.tax_type' => [Rule::in(AmountPercentTypeEnum::toValues())],
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
            'selected_categories' => translate('You must select at least one category'),

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
            
            'plan.base_currency' => translate('Base currency must be one of the following: ').FX::getAllCurrencies()->map(fn($item) => $item->code)->join(', '),
            'plan.price.required' => translate('Price is required'),
            'plan.price.numeric' => translate('Price must be a valid number'),
            'plan.discount.numeric' => translate('Discount must be a valid number'),
            'plan.discount_type.in' => translate('Discount type must be one of the following:').' '.AmountPercentTypeEnum::implodedLabels(),
            'plan.tax.numeric' => translate('Tax must be a valid number'),
            'plan.tax_type.in' => translate('Tax type must be one of the following:').' '.AmountPercentTypeEnum::implodedLabels(),
        ];
    }

    public function dehydrate()
    {
        //$this->dispatchBrowserEvent('initSlugGeneration');
        $this->dispatchBrowserEvent('initPlanForm');
    }

    public function savePlan() {
        $msg = '';

        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

        DB::beginTransaction();

        try {
            // Insert or Update plan
            $this->plan->shop_id = MyShop::getShopID();

            // If user has no permissions to publish the post, change the status to Pending (all plans with pending will be visible to users who can publish the plan)
            if(!Permissions::canAccess(User::$non_customer_user_types, ['publish_plan'], false)) {
                $this->plan->status = StatusEnum::pending();
                $msg = translate('Plan status is set to '.(StatusEnum::pending()->value).' because you don\'t have enough Permissions to publish it right away.');
            }
            
            $this->plan->save();
            $this->plan->syncUploads();

            // Set Categories
            $this->setCategories($this->plan);

            // TODO: Determine which package to use for Translations! Set Translations...

            DB::commit();

            if($this->is_update) {
                $this->toastify(translate('Subscription plan successfully updated!').' '.$msg, 'success');
            } else {
                $this->toastify(translate('Subscription plan successfully created!').' '.$msg, 'success');
            }
        } catch(\Exception $e) {
            DB::rollBack();
            
            if($this->is_update) {
                $this->dispatchGeneralError(translate('There was an error while updating a subscription plan...Please try again.'));
            } else {
                $this->dispatchGeneralError(translate('There was an error while creating a subscription plan...Please try again.'));
            }
        }
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
