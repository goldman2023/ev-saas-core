<?php

namespace App\Http\Livewire\Dashboard\Forms\Settings;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\SerialNumber;
use App\Models\Shop;
use App\Models\ShopSetting;
use App\Models\TenantSetting;
use App\Rules\UniqueSKU;
use App\Traits\Livewire\DispatchSupport;
use DB;
use EVS;
use MyShop;
use Categories;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use App\Traits\Livewire\RulesSets;
use TenantSettings;
use Payments;

class AppSettingsForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $shop;
    public $settings;
    public $addresses;
    public $domains;
    public $universal_payment_methods;

    protected function getRuleSet($set = null, $with_wildcard = true) {
        $rulesSets = collect([
            'general' => [
                // 'shop.*' => [],
                // 'settings.*' => [],
                'settings.site_logo.value' => ['required'],
                'settings.site_logo_dark.value' => ['nullable'],
                'settings.site_name.value' => ['required'],
                'settings.site_motto.value' => ['required', ],
                'settings.maintenance_mode.value' => ['required'],
            ],
            'features' => [
                /* Example field for creating new TenantSetting */
                'settings.feed_enabled.value' => ['boolean'],
                'settings.multiplan_purchase.value' => ['boolean'],
                'settings.onboarding_flow.value' => ['boolean'],
                'settings.force_email_verification.value' => ['boolean'],
                'settings.register_redirect_url.value' => ['nullable'],
                'settings.login_redirect_url.value' => ['nullable'],

                'settings.chat_feature.value' => ['boolean'],
                'settings.weedit_feature.value' => ['boolean'],
                'settings.wishlist_feature.value' => ['boolean'],
                'settings.vendor_mode_feature.value' => ['boolean'],
                'settings.plans_trial_mode.value' => ['boolean'],
                'settings.plans_trial_duration.value' => ['exclude_if:settings.plans_trial_mode.value,false', 'required', 'numeric', 'gt:0'],

            ],
            'integrations' => [
                'settings.mailerlite_api_token.value' => [''],
                'settings.mailersend_api_token.value' => [''],

                'settings.mail_from_address.value' => ['required'],
                'settings.mail_from_name.value' => ['nullable'],
                'settings.mail_reply_to_address.value' => ['required'],
                'settings.mail_reply_to_name.value' => ['nullable'],

                'settings.google_analytics_enabled.value' => ['boolean'],
                'settings.gtag_id.value' => ['exclude_if:settings.google_analytics_enabled.value,false', 'required'],

                'settings.google_recaptcha_enabled.value' => ['boolean'],
                'settings.google_recaptcha_site_key.value' => ['exclude_if:settings.google_recaptcha_enabled.value,false', 'required' ],
                'settings.google_recaptcha_secret_key.value' => ['exclude_if:settings.google_recaptcha_enabled.value,false', 'required'],
            ],
            'social' => [
                'settings.enable_social_logins.value' => ['boolean'],
                'settings.google_login.value' => ['boolean'],
                'settings.facebook_login.value' => ['boolean', ],
                'settings.linkedin_login.value' => ['boolean'],
                'settings.facebook_app_id.value' => [''],
                'settings.facebook_app_secret.value' => [''],
                'settings.google_oauth_client_id.value' => [''],
                'settings.google_oauth_client_secret.value' => [''],
                'settings.linkedin_client_id.value' => [''],
                'settings.linkedin_client_secret.value' => [''],
            ],
            'currency' => [
                'settings.show_currency_switcher.value' => ['boolean'],
                'settings.system_default_currency.value' => ['required'], // TODO: Put Rule:in(All enabled currencies codes)
                'settings.no_of_decimals.value' => ['numeric', 'min:0', 'max:3'],
                'settings.decimal_separator.value' => ['required', Rule::in([1,2])],
                'settings.currency_format.value' => ['required', Rule::in([1,2])],
                'settings.symbol_format.value' => ['required', Rule::in([1,2])],
            ],
            'payments' => [
                'settings.stripe_pk_test_key.value' => [],
                'settings.stripe_sk_test_key.value' => [],
                'settings.stripe_pk_live_key.value' => [],
                'settings.stripe_sk_live_key.value' => [],
            ],
            'design' => [
                'settings.colors.value' => ['']
            ],
            'user_meta_fields' => [
                'settings.user_meta_fields_in_use.value' => ['']
            ]
        ]);

        return empty($set) || $set === 'all' ? $rulesSets : $rulesSets->get($set);
    }

    protected function rules()
    {
        $rules = [];
        foreach($this->getRuleSet('all') as $key => $items) {
            $rules = array_merge($rules, $items);
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'shop.thumbnail.if_id_exists' => translate('Selected thumbnail does not exist in Media Library. Please select again.'),
            'shop.cover.if_id_exists' => translate('Selected cover does not exist in Media Library. Please select again.'),
        ];
    }

    /**
     * Mount a new component instance.
     *
     * @return void
     */
    public function mount()
    {
        $this->settings = TenantSettings::getAll();
        $this->universal_payment_methods = Payments::getPaymentMethodsAll();
    }

    // public function updatingShop(&$shop, $key) {
    //     if(!$shop instanceof Shop) {
    //         $shop = Shop::find($shop['id'])->fill($shop); // alpinejs passes arrays as data instead of Model type. This is the reason why we have to convert it to Address model.
    //     }
    // }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    public function render()
    {
        return view('livewire.dashboard.forms.settings.app-settings-form');
    }

    public function saveGeneral() {
        $rules = $this->getRuleSet('general');

        try {
            $this->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate($rules);
        }

        DB::beginTransaction();

        try {
            $this->saveSettings($rules);

            TenantSettings::clearCache();

            DB::commit();

            $this->inform(translate('General settings successfully saved.'), '', 'success');
        } catch(\Exception $e) {
            DB::rollback();
            $this->inform(translate('Could not save general settings.'), $e->getMessage(), 'fail');
        }
    }

    public function saveDesign() {
        $rules = $this->getRuleSet('design');

        try {
            $this->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate($rules);
        }

        DB::beginTransaction();

        try {
            $this->saveSettings($rules);

            TenantSettings::clearCache();

            DB::commit();

            $this->inform(translate('Design settings successfully saved.'), '', 'success');
        } catch(\Exception $e) {
            DB::rollback();
            $this->inform(translate('Could not save design settings.'), $e->getMessage(), 'fail');
        }
    }

    public function saveCurrency() {
        $rules = $this->getRuleSet('currency');

        try {
            $this->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate($rules);
        }

        DB::beginTransaction();

        try {
            $this->saveSettings($rules);

            TenantSettings::clearCache();

            DB::commit();

            $this->inform(translate('Currency settings successfully saved.'), '', 'success');
        } catch(\Exception $e) {
            DB::rollback();
            $this->inform(translate('Could not save currency settings.'), $e->getMessage(), 'fail');
        }
    }

    public function savePayments() {
        $rules = $this->getRuleSet('payments');

        try {
            $this->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate($rules);
        }

        DB::beginTransaction();

        try {
            $this->saveSettings($rules);

            TenantSettings::clearCache();

            DB::commit();

            $this->inform(translate('Payments settings successfully saved.'), '', 'success');
        } catch(\Exception $e) {
            DB::rollback();
            $this->inform(translate('Could not save payments settings.'), $e->getMessage(), 'fail');
        }
    }

    public function saveFeatures() {
        $rules = $this->getRuleSet('features');

        try {
            $this->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate($rules);
        }

        DB::beginTransaction();

        try {
            $this->saveSettings($rules);

            TenantSettings::clearCache();

            DB::commit();

            $this->inform(translate('Features settings successfully saved.'), '', 'success');
        } catch(\Exception $e) {
            DB::rollback();
            $this->inform(translate('Could not save features settings.'), $e->getMessage(), 'fail');
        }
    }

    public function saveSocial() {
        $rules = $this->getRuleSet('social');

        try {
            $this->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate($rules);
        }

        DB::beginTransaction();

        try {
            $this->saveSettings($rules);

            TenantSettings::clearCache();

            DB::commit();

            $this->inform(translate('Social settings successfully saved.'), '', 'success');
        } catch(\Exception $e) {
            DB::rollback();
            $this->inform(translate('Could not save social settings.'), $e->getMessage(), 'fail');
        }
    }

    public function saveIntegrations() {
        $rules = $this->getRuleSet('integrations');
        
        try {
            $this->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate($rules);
        }

        DB::beginTransaction();

        try {
            $this->saveSettings($rules);

            TenantSettings::clearCache();

            DB::commit();

            // TODO: Move this somewhere else, to be MailerLite specific!!!
            \MailerService::mailerlite()->addDefaultFields();

            $this->inform(translate('Integrations settings successfully saved.'), '', 'success');
        } catch(\Exception $e) {
            DB::rollback();
            $this->inform(translate('Could not save integrations settings.'), $e->getMessage(), 'fail');
        }
    }

    public function saveBasicInformation() {
        $rules = $this->getRuleSet('basic');

        try {
            $this->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate($rules);
        }

        $this->shop->offsetUnset('pivot'); // WHY THE FUCK IS PIVOT attribute ADDED TO THE MODEL ATTRIBUTES LIST????

        DB::beginTransaction();

        try {
            $this->shop->syncUploads();
            // $this->shop->content = Purifier::clean($this->shop->content); // TODO: Fix purifier to prevent XSS

            $this->shop->save();

            $this->saveSettings($rules);

            DB::commit();

            $this->inform(translate('Basic shop information successfully saved.'), '', 'success');
        } catch(\Exception $e) {
            DB::rollback();
            $this->inform(translate('Could not save basic shop information.'), $e->getMessage(), 'fail');
        }
    }

    public function saveCompanyInfo() {
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
        } catch(\Exception $e) {
            DB::rollback();
            $this->inform(translate('Could not save company information.'), $e->getMessage(), 'fail');
        }
    }

    public function saveContactDetails($contacts, $current = null) {
        if($current['is_primary'] ?? null) {
            $contacts = collect($contacts)->map(function($item) use ($current) {
                if($item['email'] == $current['email'] && $item['department_name'] == $current['department_name']) {
                    $item['is_primary'] = true;
                } else {
                    $item['is_primary'] = false;
                }
                return $item;
            })->toArray();
        }

        $contact_details = $this->shop->settings()->get()->keyBy('setting')->get('contact_details');

        if(empty($contact_details)) {
            $contact_details = new ShopSetting();
            $contact_details->shop_id = $this->shop->id;
            $contact_details->setting = 'contact_details';
        }

        $contact_details->value = json_encode($contacts);
        $contact_details->save();

        $this->settings['contact_details'] = $contact_details->value;

        // $this->dispatchBrowserEvent('contact-details-modal-hide');
        $this->dispatchBrowserEvent('toggle-flyout-panel', ['id' => 'contact-panel', 'timeout' => '500']);
        $this->inform(translate('Contact details successfully updated.'), '', 'success');
    }

    public function removeContactDetails($contacts, $current = null) {
        $contact_details = $this->shop->settings->keyBy('setting')->get('contact_details');

        foreach($contacts as $key => $contact) {
            if($contact == $current) {
                unset($contacts[$key]);
            }
        }

        $contacts = array_values($contacts);

        $has_primary = false;
        foreach($contacts as $key => $contact) {
            if($contact['is_primary'] ?? false) {
                $has_primary = true;
            }
        }

        if(!$has_primary && isset($contacts[0])) {
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
    protected function saveSettings($rules) {
        foreach(collect($rules)->filter(fn($item, $key) => str_starts_with($key, 'settings')) as $key => $value) {
            $setting_key = explode('.', $key)[1]; // get the part after `settings.`
            
            if(!empty($setting_key) && $setting_key !== '*') {
                TenantSetting::where('setting', $setting_key)
                    ->update(['value' => castValueForSave($setting_key, $this->settings[$setting_key], TenantSettings::settingsDataTypes())]);
            }
        }
    }
}
