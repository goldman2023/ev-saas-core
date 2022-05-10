<?php

namespace App\Http\Livewire\Dashboard\Forms\Settings;

use App\Models\User;
use App\Models\UserMeta;
use App\Rules\UniqueSKU;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\RulesSets;
use Categories;
use DB;
use EVS;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;

class MyAccountForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $me;

    public $meta;

    public $currentPassword = '';

    public $newPassword = '';

    public $newPassword_confirmation = '';

    public $onboarding = false;
    

    protected function getRuleSet($set = null)
    {
        if($this->onboarding) {
            $user_meta_fields_in_use = collect(get_tenant_setting('user_meta_fields_in_use'))->where('onboarding', true);
        } else {
            $user_meta_fields_in_use = collect(get_tenant_setting('user_meta_fields_in_use'));
        }
        

        $basic = [
            'me.name' => ['required', 'min:2'],
            'me.surname' => ['required', 'min:2'],
            'me.entity' => ['required'],
            //                'me.email' => ['required', 'email:rfs,dns'],
            'me.phone' => [''],
            'me.thumbnail' => ['if_id_exists:App\Models\Upload,id,true'],
            'me.cover' => ['if_id_exists:App\Models\Upload,id,true'],
        ];

        $meta = [];

        if($user_meta_fields_in_use->count() > 0) {
            foreach($user_meta_fields_in_use as $key => $options) {
                if(in_array($key, UserMeta::metaForCompanyEntity())) {
                    $meta['meta.'.$key.''] = ($options['required'] ?? false) ? ['exclude_if:me.entity,individual', 'required'] : [];
                } else {
                    $meta['meta.'.$key.''] = ($options['required'] ?? false) ? ['required'] : [];
                }
            }
        }
        
        $rulesSets = collect([
            // Basic information rules
            'basic' => array_merge($basic, $meta),
            'language' => [
                'meta.locale' => ''
            ],
            'email' => [
                'me.email' => ['required', 'email:rfs,dns'],
            ],
            'password' => [
                'currentPassword' => ['required', 'match_password:App\Models\User,id,me'],
                'newPassword' => ['required', 'min:8', 'regex:/^.*(?=.{1,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/', 'confirmed'],
            ],
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
        return [
            'me.thumbnail.exists' => translate('Selected thumbnail does not exist in Media Library. Please select again.'),
            'me.cover.exists' => translate('Selected cover does not exist in Media Library. Please select again.'),
            'me.thumbnail.if_id_exists' => translate('Selected thumbnail does not exist in Media Library. Please select again.'),
            'me.cover.if_id_exists' => translate('Selected cover does not exist in Media Library. Please select again.'),

            'me.name.required' => translate('Full name is required'),
            'me.name.min' => translate('Minimum full name length is :min'),

            'currentPassword.required' => translate('Current password is required in order to update password'),
            'currentPassword.match_password' => translate('Current password does not match the user password. You have to know the current password in order to update it!'),
            'newPassword.required' => translate('New password is required in order to update the old one.'),
            'newPassword.min' => translate('Length of password must not be less than :min'),
            'newPassword.regex' => translate('New password is not as per requirements. Please read requirements below.'),
            'newPassword.confirmed' => translate('Your new password confirmation does not match the new password. New password and confirmation must match.'),
        ];
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
        return view('livewire.dashboard.forms.settings.my-account-form');
    }

    public function saveBasicInformation()
    {
        $rules = $this->getRuleSet('basic');

        try {
            $this->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate($rules);
        }

        DB::beginTransaction();

        try {
            $this->me->syncUploads();
            $this->me->save();
            $this->saveMeta($rules);

            DB::commit();

            $this->inform(translate('Basic information successfully saved.'), '', 'success');
        } catch (\Exception $e) {
            DB::rollback();
            $this->inform(translate('Could not save basic information settings.'), $e->getMessage(), 'fail');
        }

        if ($this->onboarding) {
            return redirect()->route('onboarding.work-and-education');
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

    public function saveLanguage()
    {
        $rules = $this->getRuleSet('language');

        $this->validate($rules);

        try {
            $this->saveMeta($rules);

            $this->inform(translate('Language settings successfully saved.'), '', 'success');
        } catch (\Exception $e) {
            $this->inform(translate('Could not save language settings.'), $e->getMessage(), 'fail');
        }
    }

    public function saveEmail()
    {
        // TODO: Validation does not work for some reason. Check the error and fix it!
        $this->validate($this->getRuleSet('email'));

        $this->me->save();

        // TODO: Implement Email verification before email is really swapped with new email in the DB!
        $this->inform(translate('Please go to your email to verify email change!'), '', 'success');
    }

    public function updatePassword()
    {
        $this->validate($this->getRuleSet('current_password'));

        // Update password
        $this->me->password = Hash::make($this->newPassword);
        $this->me->save();

        // TODO: Logout the User
        // TODO: Send an email to user that password is changed

        $this->inform(translate('Your password is successfully updated. You will be logged out.'), '', 'success');
    }

    /*
     * Saves all UserMeta provided in $rules variable.
     */
    protected function saveMeta($rules)
    {
        foreach (collect($rules)->filter(fn ($item, $key) => str_starts_with($key, 'meta')) as $key => $value) {
            $meta_key = explode('.', $key)[1]; // get the part after `settings.`
            
            if (! empty($meta_key) && $meta_key !== '*') { 
                UserMeta::where([
                    ['key', $meta_key],
                    ['user_id', $this->me->id],
                ])->update(['value' => castValueForSave($meta_key, $this->meta[$meta_key], UserMeta::metaDataTypes())]);
            }
        }
    }
}
