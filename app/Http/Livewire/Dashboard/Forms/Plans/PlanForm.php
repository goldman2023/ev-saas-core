<?php

namespace App\Http\Livewire\Dashboard\Forms\Plans;

use App\Enums\AmountPercentTypeEnum;
use App\Enums\StatusEnum;
use App\Facades\FX;
use App\Facades\MyShop;
use App\Models\Address;
use App\Models\Category;
use App\Models\Plan;
use App\Models\ShopAddress;
use App\Models\User;
use App\Models\CoreMeta;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\HasCategories;
use App\Traits\Livewire\RulesSets;
use App\Traits\Livewire\HasCoreMeta;
use App\Traits\Livewire\HasAttributes;
use Categories;
use DB;
use WE;
use Log;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Permissions;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use Spatie\Activitylog\Facades\CauserResolver;

class PlanForm extends Component
{
    use RulesSets;
    use DispatchSupport;
    use HasCategories;
    use HasAttributes;
    use HasCoreMeta;

    public $plan;

    public $is_update;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($plan = null)
    {
        $this->plan = empty($plan) ? (new Plan())->load(['uploads']) : $plan;
        $this->is_update = isset($this->plan->id) && ! empty($this->plan->id);

        if (! $this->is_update) {
            // If insert
            $this->plan->status = StatusEnum::draft()->value;
            $this->plan->primary = false;
            $this->plan->featured = false;
            $this->plan->base_currency = FX::getCurrency()->code;
            $this->plan->yearly_discount_type = AmountPercentTypeEnum::amount()->value;
            $this->plan->non_standard = false;
        }

        $this->initCategories($this->plan);

        $this->refreshAttributes($this->plan);

        $this->initCoreMeta($this->plan);
    }

    protected function rules()
    {
        return [
            'selected_categories' => 'required',
            // 'plan.slug' => 'unique:App\Models\P,id'
            'plan.featured' => ['boolean'],
            'plan.primary' => ['boolean'],
            'plan.thumbnail' => ['if_id_exists:App\Models\Upload,id,true'],
            'plan.cover' => ['if_id_exists:App\Models\Upload,id,true'],
            'plan.name' => 'required|min:2',
            'plan.status' => [Rule::in(StatusEnum::toValues('archived'))],
            'plan.non_standard' => ['nullable', 'boolean'],
            'plan.excerpt' => 'required|min:10',
            'plan.content' => 'nullable', //'required|min:10',
            'plan.features' => 'required|array',
            'plan.features.*' => 'required|string|distinct|min:4',

            'plan.base_currency' => 'nullable',
            /* TODO: @vukasin plan.base_currency FX RULE not working all the time (check if we need some currency seeds or whatever) */
            // 'plan.base_currency' => [Rule::in(FX::getAllCurrencies()->map(fn ($item) => $item->code)->toArray())],
            'plan.price' => 'nullable|numeric',
            'plan.discount' => 'nullable|numeric',
            'plan.discount_type' => [Rule::in(AmountPercentTypeEnum::toValues())],
            'plan.yearly_discount' => 'nullable|numeric',
            'plan.yearly_discount_type' => [Rule::in(AmountPercentTypeEnum::toValues())],
            'plan.gallery' => ['nullable'],
            'plan.meta_title' => [''],
            'plan.meta_keywords' => [''],
            'plan.meta_description' => [''],
            'plan.meta_img' => ['if_id_exists:App\Models\Upload,id,true'],
            'custom_attributes.*' => 'required',
            'selected_predefined_attribute_values.*' => '',
        ];
    }

    protected function messages()
    {
        return [
            'selected_categories' => translate('You must select at least one category'),

            'plan.thumbnail.if_id_exists' => translate('Selected thumbnail does not exist in Media Library. Please select again.'),
            'plan.cover.if_id_exists' => translate('Selected cover does not exist in Media Library. Please select again.'),
            'plan.meta_img.if_id_exists' => translate('Selected meta image does not exist in Media Library. Please select again.'),

            'plan.name.required' => translate('Title is required'),
            'plan.name.min' => translate('Minimum title length is :min'),

            'plan.excerpt.required' => translate('Excerpt is required'),
            'plan.excerpt.min' => translate('Minimum excerpt length is :min'),

            'plan.content.required' => translate('Content is required'),
            'plan.content.min' => translate('Minimum content length is :min'),

            'plan.status.in' => translate('Status must be one of the following:').' '.StatusEnum::implodedLabels('archived'),

            'plan.base_currency' => translate('Base currency must be one of the following: ').FX::getAllCurrencies()->map(fn ($item) => $item->code)->join(', '),
            'plan.price.required' => translate('Price is required'),
            'plan.price.numeric' => translate('Price must be a valid number'),
            'plan.discount.numeric' => translate('Discount must be a valid number'),
            'plan.discount_type.in' => translate('Discount type must be one of the following:').' '.AmountPercentTypeEnum::implodedLabels(),

            'plan.features.*.min' => translate('Minimum 4 chars is required for each feature'),
        ];
    }

    public function getWEFRules() {
        return apply_filters('dashboard.plan-form.rules.wef', [
            'wef.custom_redirect_url' => 'nullable',
            'wef.custom_cta_label' => 'nullable',
            'wef.custom_pricing_label' => 'nullable',
        ]);
    }
    
    public function getWEFMessages() {
        return [];
    }

    public function dehydrate()
    {
        //$this->dispatchBrowserEvent('initSlugGeneration');
        $this->dispatchBrowserEvent('init-form');
    }

    public function savePlan()
    {
        $msg = '';

        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->plan->status = StatusEnum::draft()->value;
            $this->validate();
        }

        DB::beginTransaction();

        try {
            CauserResolver::setCauser(MyShop::getShop());

            // Insert or Update plan
            $this->plan->shop_id = MyShop::getShopID();

            // If user has no permissions to publish the post, change the status to Pending (all plans with pending will be visible to users who can publish the plan)
            if (! Permissions::canAccess(User::$non_customer_user_types, ['publish_plan'], false)) {
                $this->plan->status = StatusEnum::pending()->value;
                $msg = translate('Plan status is set to '.(StatusEnum::pending()->value).' because you don\'t have enough Permissions to publish it right away.');
            }

            // If current Plan is set to primary, all other plans must NOT BE primary
            if($this->plan->primary) {
                Plan::where('primary', 1)->update(['primary' => 0]);
            }

            if(!empty($this->plan->features)) {
                $this->plan->features = array_filter($this->plan->features);
            }

            $this->plan->save();
            $this->plan->syncUploads();

            // Set Categories
            $this->setCategories($this->plan);
            
            // Refresh attributes
            $this->refreshAttributes($this->plan);
            
            // Save all core meta
            $this->saveAllCoreMeta($this->plan);

            // TODO: Determine which package to use for Translations! Set Translations...

            DB::commit();

            $this->inform(translate('Subscription plan saved successfully updated!'), $msg, 'success');

            if (!$this->is_update) {
                return redirect()->route('plan.edit', $this->plan->id);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($this->is_update) {
                $this->dispatchGeneralError(translate('There was an error while updating a subscription plan...Please try again.'));
                $this->inform(translate('There was an error while updating a subscription plan...Please try again.'), '', 'fail');
            } else {
                $this->dispatchGeneralError(translate('There was an error while creating a subscription plan...Please try again.'));
                $this->inform(translate('There was an error while creating a subscription plan...Please try again.'), '', 'fail');
            }
        }
    }

    public function removePlan()
    {
//        $address = app($this->currentAddress::class)->find($this->currentAddress->id)->fill($this->currentAddress->toArray());
//        $address->remove();
    }

    public function render()
    {
        return view('livewire.dashboard.forms.plans.plan-form');
    }
}
