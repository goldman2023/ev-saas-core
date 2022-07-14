<?php

namespace App\Http\Livewire\Dashboard\Forms\Settings;

use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use App\Traits\Livewire\RulesSets;
use Illuminate\Support\Facades\Http;
use TenantSettings;
use App\Models\TenantSetting;
use App\Models\Shop;
use App\Models\ShopSetting;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Validation\Rule;
use DB;
use MyShop;

class BusinessProfileForm extends Component
{
    public $business;
    public $settings;

    public function mount(){
        $this->business = MyShop::getShop();

        // User Meta
        ShopSetting::createMissingSettings($this->business->id);
        $business_settings = $this->business->settings()->select('id', 'setting', 'value')->get()->keyBy('setting')->toArray();
        castValuesForGet($business_settings, ShopSetting::metaDataTypes());
        
        $this->settings = $business_settings;

    }

    protected function getRuleSet($set = null)
    {
        $rulesSets = collect([
            'basic' => [
                'settings.*' => [],
                'business.thumbnail' => ['sometimes', 'if_id_exists:App\Models\Upload,id,true'],
                'business.cover' => ['sometimes','if_id_exists:app\models\upload,id,true'],
                'business.name' => ['required', 'min:3'],
                'business.excerpt' => ['required', 'min:30'],
                'business.content' => ['required', 'min:30'],
                'settings.tagline' => ['required'],
                'settings.phones' => ['required'],
                'settings.email' => ['required','email:rfs','dns'], 
                'settings.websites' => ['required'],
            ],
            'company_info' => [
                'settings.tax_number' => [''],
                'settings.registration_number' => [''],
            ],
            'settings' => [
                'settings.*' => [],

            ],
            'contact_details' => [
                'settings.contact_details' => ['required'],
            ],
            'domains' => [],
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

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    protected function messages()
    {
        return [
            'business.thumbnail.if_id_exists' => translate('Selected thumbnail does not exist in Media Library. Please select again.'),
            'business.cover.if_id_exists' => translate('Selected cover does not exist in Media Library. Please select again.'),
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.forms.settings.business-profile-form');
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

        $this->business->offsetUnset('pivot'); 

        DB::beginTransaction();

        try {
            $this->business->syncUploads();
            // $this->business->content = Purifier::clean($this->business->content); // TODO: Fix purifier to prevent XSS

            $this->business->save();

            $this->saveSettings($rules);

            DB::commit();

            $this->inform(translate('Basic business information successfully saved.'), '', 'success');

        } catch (\Exception $e) {
            DB::rollback();
            $this->inform(translate('Could not save basic business information.'), $e->getMessage(), 'fail');
        }
    }

    public function saveCompanyInfo()
    {
        $rules = $this->getRuleSet('company_info');

        try {
            $this->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate($rules);
        }

        try {
            $this->saveSettings($rules);

            DB::commit();

            $this->inform(translate('Company information successfully saved.'), '', 'success');
        } catch (\Exception $e) {
            DB::rollback();
            $this->inform(translate('Could not save company information.'), $e->getMessage(), 'fail');
        }
    }

    public function saveContactDetails($contacts, $current = null)
    {
        if ($current['is_primary'] ?? null) {
            $contacts = collect($contacts)->map(function ($item) use ($current) {
                if ($item['email'] == $current['email'] && $item['department_name'] == $current['department_name']) {
                    $item['is_primary'] = true;
                } else {
                    $item['is_primary'] = false;
                }

                return $item;
            })->toArray();
        }

        $contact_details = $this->business->settings()->get()->keyBy('setting')->get('contact_details');

        if (empty($contact_details)) {
            $contact_details = new ShopSetting();
            $contact_details->business_id = $this->business->id;
            $contact_details->setting = 'contact_details';
        }

        $contact_details->value = json_encode($contacts);
        $contact_details->save();

        $this->settings['contact_details'] = $contacts;

        // $this->dispatchBrowserEvent('contact-details-modal-hide');
        $this->dispatchBrowserEvent('toggle-flyout-panel', ['id' => 'contact-panel', 'timeout' => '500']);
        $this->inform(translate('Contact details successfully updated.'), '', 'success');
    }

    public function removeContactDetails($contacts, $current = null)
    {
        $contact_details = $this->business->settings->keyBy('setting')->get('contact_details');

        foreach ($contacts as $key => $contact) {
            if ($contact == $current) {
                unset($contacts[$key]);
            }
        }

        $contacts = array_values($contacts);

        $has_primary = false;
        foreach ($contacts as $key => $contact) {
            if ($contact['is_primary'] ?? false) {
                $has_primary = true;
            }
        }

        if (! $has_primary && isset($contacts[0])) {
            $contacts[0]['is_primary'] = true;
        }

        $contact_details->value = json_encode(array_values($contacts));
        $contact_details->save();

        $this->settings['contact_details'] = $contact_details->value;

        $this->dispatchBrowserEvent('contact-details-modal-hide');
        $this->toastify(translate('Contact details successfully removed.', 'success'));
    }

    /*
     * Saves all settings provided in $rules variable.
     */
    protected function saveSettings($rules)
    {
        foreach (collect($rules)->filter(fn ($item, $key) => str_starts_with($key, 'settings')) as $key => $value) {
            $setting_key = explode('.', $key)[1]; // get the part after `core_meta.`

            if (! empty($setting_key) && $setting_key !== '*') {
                $new_value = castValueForSave($setting_key, $this->settings[$setting_key], ShopSetting::metaDataTypes());

                try {
                    ShopSetting::updateOrCreate(
                        [
                            'shop_id' => $this->business->id, 
                            'setting' => $setting_key, 
                        ],
                        ['value' => $new_value]
                    );
                } catch(\Exception $e) {
                    Log::error($e->getMessage());
                }
            }
        }
    }
}
