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
use EVS;
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

    public $model_core_meta;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($plan = null)
    {
        $this->plan = empty($plan) ? new Plan() : $plan;
        $this->is_update = isset($this->plan->id) && ! empty($this->plan->id);

        if (! $this->is_update) {
            // If insert
            $this->plan->status = StatusEnum::draft()->value;
            $this->plan->primary = false;
            $this->plan->featured = false;
            $this->plan->base_currency = FX::getCurrency()->code;
            $this->plan->discount_type = AmountPercentTypeEnum::amount()->value;
            $this->plan->yearly_discount_type = AmountPercentTypeEnum::amount()->value;
            $this->plan->tax_type = AmountPercentTypeEnum::amount()->value;
            $this->plan->non_standard = false;
        }

        $this->initCategories($this->plan);

        $this->refreshAttributes($this->plan);

        $this->initCoreMeta($this->plan);

        $this->model_core_meta = CoreMeta::getMeta($this->plan?->core_meta ?? [], Plan::class, true);
    }

    protected function getRuleSet($set = null)
    {
        $rulesSets = collect([
            'meta' => [
                'model_core_meta.custom_redirect_url' => 'nullable',
                'model_core_meta.custom_cta_label' => 'nullable',
                'model_core_meta.custom_pricing_label' => 'nullable',
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
            'plan.tax' => 'nullable|numeric',
            'plan.tax_type' => [Rule::in(AmountPercentTypeEnum::toValues())],
            'plan.gallery' => [''],
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
            'plan.tax.numeric' => translate('Tax must be a valid number'),
            'plan.tax_type.in' => translate('Tax type must be one of the following:').' '.AmountPercentTypeEnum::implodedLabels(),

            'plan.features.*.min' => translate('Minimum 4 chars is required for each feature'),
        ];
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
            $this->refreshAttributes($this->plan);
            $this->setCoreMeta($this->plan);
            $this->saveModelCoreMeta();

            // TODO: Determine which package to use for Translations! Set Translations...

            DB::commit();

            if ($this->is_update) {
                $this->inform(translate('Subscription plan successfully updated!'), $msg, 'success');
            } else {
                $this->inform(translate('Subscription plan successfully created!'), $msg, 'success');
            }

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

    protected function saveModelCoreMeta()
    {
        foreach (collect($this->getRuleSet('meta') ?? [])->filter(fn ($item, $key) => str_starts_with($key, 'model_core_meta')) as $key => $value) {
            $core_meta_key = explode('.', $key)[1]; // get the part after `core_meta.`

            if (! empty($core_meta_key) && $core_meta_key !== '*') {
                if(array_key_exists($core_meta_key, is_array($this->model_core_meta) ? $this->model_core_meta : $this->model_core_meta->toArray())) {
                    $new_value = castValueForSave($core_meta_key, $this->model_core_meta[$core_meta_key], CoreMeta::metaPlanDataTypes());

                    try {
                        CoreMeta::updateOrCreate(
                            ['subject_id' => $this->plan->id, 'subject_type' => $this->plan::class, 'key' => $core_meta_key],
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
