<?php

namespace App\Http\Livewire\Dashboard\Forms\Settings;

use App\Models\User;
use App\Models\UserMeta;
use App\Rules\UniqueSKU;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\RulesSets;
use Categories;
use DB;
use WE;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;

class MyWorkAndEducationForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $me;
    public $meta;
    public $onboarding = false;
    

    protected function getRuleSet($set = null)
    {
        if($this->onboarding) {
            $user_meta_fields_in_use = collect(get_tenant_setting('user_meta_fields_in_use'))->where('onboarding', true);
        } else {
            $user_meta_fields_in_use = collect(get_tenant_setting('user_meta_fields_in_use'));
        }

        $meta = [];

        if($user_meta_fields_in_use->count() > 0) {
            foreach($user_meta_fields_in_use as $key => $options) {
                if($key === 'education' || $key === 'work_experience') {
                    $meta['meta.'.$key.'.value'] = ($options['required'] ?? false) ? ['required'] : [];
                }
            }
        }
        
        $rulesSets = collect([
            'meta' => $meta,
        ]);

        return empty($set) || $set === 'all' ? $rulesSets : $rulesSets->get($set);
    }

    protected function rules()
    {
        $rules = [];
        foreach ($this->getRuleSet('all') as $key => $items) {
            $rules = array_merge($rules, $items);
        }

        return $rules;
    }

    protected function messages()
    {
        return [];
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($onboarding = false)
    {
        $this->onboarding = $onboarding;
        $this->me = auth()->user();

        // User Meta
        UserMeta::createMissingMeta($this->me->id);
        $user_meta = $this->me->user_meta()->select('id', 'key', 'value')->get()->keyBy('key')->toArray();
        castValuesForGet($user_meta, UserMeta::metaDataTypes());

        $this->meta = $user_meta;
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    public function render()
    {
        return view('livewire.dashboard.forms.settings.my-work-and-education-form');
    }

    public function saveAll() {
        $this->saveWorkExperience();
        $this->saveEducation();

        if($this->onboarding) {
            return redirect()->route('onboarding.step4');
        }
    }

    public function saveWorkExperience() {
        $meta_key = 'work_experience';
        
        try {
            UserMeta::where([
                ['key', $meta_key],
                ['user_id', $this->me->id],
            ])->update(['value' => castValueForSave($meta_key, $this->meta[$meta_key], UserMeta::metaDataTypes())]);

            // $this->inform(translate('Work experience successfully saved.'), '', 'success');
        } catch (\Exception $e) {
            // $this->inform(translate('Could not save basic information settings.'), $e->getMessage(), 'fail');
        }
    }

    public function saveEducation() {
        $meta_key = 'education';

        try {
            UserMeta::where([
                ['key', $meta_key],
                ['user_id', $this->me->id],
            ])->update(['value' => castValueForSave($meta_key, $this->meta[$meta_key], UserMeta::metaDataTypes())]);

            // $this->inform(translate('Work experience successfully saved.'), '', 'success');
        } catch (\Exception $e) {
            // $this->inform(translate('Could not save basic information settings.'), $e->getMessage(), 'fail');
        }
    }
}
