<?php

namespace App\Http\Livewire\Dashboard\Forms\Settings;

use App\Enums\AppSettingsGroupEnum;
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
use Illuminate\Support\Facades\Http;
use TenantSettings;
use Payments;

class AppSettingsForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $settingsGroup;
    public $shop;
    public $settings;
    public $addresses;
    public $domains;
    public $universal_payment_methods;
    public $colors;

    protected function getRuleSet($set = null, $with_wildcard = true) {
        $rulesSets = collect([
            'general' => apply_filters('app-settings-general-rules', [
                // 'shop.*' => [],
                // 'settings.*' => [],
                'settings.site_logo' => ['required'],
                'settings.site_logo_dark' => ['nullable'],
                'settings.site_name' => ['required'],
                'settings.site_motto' => ['required'],
                'settings.site_contact_email' => ['email:rfc,dns'],
                'settings.maintenance_mode' => ['required'],
                'settings.brands_ct_enabled' => ['required'],
                'settings.tos_url' => [''],
                'settings.cookies_url' => [''],
                'settings.eula_url' => [''],
                'settings.shipping_policy_url' => [''],
                'settings.returns_and_refunds_url' => [''],
                'settings.documentation_url' => [''],
            ]),
            /* TODO: Enable disable specific product types in app settings */
            /* WARNING THIS OPTION IS WORK IN PROGRESS */
            'products' =>  apply_filters('app-settings-product-rules', [
                'settings.enabled_product_types' => ['']
            ]),
            'features' => apply_filters('app-settings-features-rules', [
                /* Example field for creating new TenantSetting */
                'settings.multiple_subscriptions_enabled' => ['boolean'],
                'settings.multi_item_subscription_enabled' => ['boolean'],
                'settings.subscription_items_distribution_enabled' => ['boolean'],
                'settings.feed_enabled' => ['boolean'],
                'settings.onboarding_flow' => ['boolean'],
                'settings.force_email_verification' => ['boolean'],
                'settings.register_redirect_url' => ['nullable'],
                'settings.login_redirect_url' => ['nullable'],
                'settings.login_dynamic_redirect' => ['boolean'],
                'settings.register_dynamic_redirect' => ['boolean'],

                'settings.chat_feature' => ['boolean'],
                'settings.addresses_feature' => ['boolean'],
                'settings.notifications_feature' => ['boolean'],
                'settings.weedit_feature' => ['boolean'],
                'settings.wishlist_feature' => ['boolean'],
                'settings.vendor_mode_feature' => ['boolean'],
                'settings.plans_trial_mode' => ['boolean'],
                'settings.plans_trial_duration' => ['exclude_if:settings.plans_trial_mode,false', 'required', 'numeric', 'gt:0'],

            ]),
            'integrations.smtp_server' => [
                'settings.smtp_mail_enabled' => ['boolean'],
                'settings.smtp_mail_host' => ['required'],
                'settings.smtp_mail_port' => ['required'],
                'settings.smtp_mail_username' => ['required'],
                'settings.smtp_mail_password' => ['required'],
                'settings.mail_from_address' => ['required'],
                'settings.mail_from_name' => ['nullable'],
                'settings.mail_reply_to_address' => ['required'],
                'settings.mail_reply_to_name' => ['nullable'],
            ],
            'integrations.mailerlite' => [
                'settings.mailerlite_api_token' => [''],
            ],
            'integrations.mailersend' => [
                'settings.mailersend_api_token' => [''],
                'settings.transactional_email_templates_list' => [''],
            ],
            'integrations.google_analytics' => [
                'settings.google_analytics_enabled' => ['boolean'],
                'settings.gtag_id' => ['exclude_if:settings.google_analytics_enabled,false', 'required'],
            ],
            'integrations.google_recaptcha' => [
                'settings.google_recaptcha_enabled' => ['boolean'],
                'settings.google_recaptcha_site_key' => ['exclude_if:settings.google_recaptcha_enabled,false', 'required' ],
                'settings.google_recaptcha_secret_key' => ['exclude_if:settings.google_recaptcha_enabled,false', 'required'],
            ],
            'integrations.google_tag_manager' => [
                'settings.google_tag_manager_enabled' => ['boolean'],
                'settings.google_tag_manager_id' => ['exclude_if:settings.google_tag_manager_enabled,false', 'required'],
            ],
            'integrations.wordpress_api' => [
                'settings.wordpress_api_enabled' => ['boolean'],
                'settings.wordpress_api_route' => ['exclude_if:settings.wordpress_api_enabled,false', 'required'],
            ],
            'integrations.woo_import' => [
                'settings.woo_import_enabled' => ['boolean'],
                'settings.woo_import_api_key' => ['exclude_if:settings.woo_import_enabled,false', 'required'],
                'settings.woo_import_rest_api_secret_key' => ['exclude_if:settings.woo_import_enabled,false', 'required'],
            ],
            /* TODO: Add woocommerce rules here */
            'integrations.facebook_pixel' => [
                'settings.facebook_pixel_enabled' => ['boolean'],
                'settings.facebook_pixel_id' => ['exclude_if:settings.facebook_pixel_enabled,false', 'required'],
            ],
            'social' => [
                'settings.enable_social_logins' => ['boolean'],
                'settings.google_login' => ['boolean'],
                'settings.facebook_login' => ['boolean', ],
                'settings.linkedin_login' => ['boolean'],
                'settings.facebook_app_id' => [''],
                'settings.facebook_app_secret' => [''],
                'settings.google_oauth_client_id' => [''],
                'settings.google_oauth_client_secret' => [''],
                'settings.linkedin_client_id' => [''],
                'settings.linkedin_client_secret' => [''],
            ],
            'currency' => [
                'settings.show_currency_switcher' => ['boolean'],
                'settings.system_default_currency' => ['required'], // TODO: Put Rule:in(All enabled currencies codes)
                'settings.no_of_decimals' => ['numeric', 'min:0', 'max:3'],
                'settings.decimal_separator' => ['required', Rule::in([1,2])],
                'settings.currency_format' => ['required', Rule::in([1,2])],
                'settings.symbol_format' => ['required', Rule::in([1,2])],
            ],
            'payments' => [
                'settings.stripe_pk_test_key' => [],
                'settings.stripe_sk_test_key' => [],
                'settings.stripe_pk_live_key' => [],
                'settings.stripe_sk_live_key' => [],
            ],
            'design' => [
                'settings.colors' => [''],
                'settings.product_page_style' => [''],
                // 'settings.header-style' => [''],
                'settings.footer_style' => [''],
            ],
            'templates' => [
                // TODO: move all -style settings to separate group
            ],
            'user_meta_fields' => [
                'settings.user_meta_fields_in_use' => ['']
            ],
            'system_notifications_list' => [
                'settings.system_notifications_list' => ['']
            ],
        ]);

        $rulesSets = apply_filters('app-settings-rules', $rulesSets);

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
            'settings.site_contact_email.email' => translate('Invalid email address'),
        ];
    }

    /**
     * Mount a new component instance.
     *
     * @return void
     */
    public function mount($settingsGroup)
    {
        $this->settingsGroup = $settingsGroup;
        $this->settings = TenantSettings::getAll();
        $this->colors = TenantSettings::settingsDataTypes()['colors'];
        $this->universal_payment_methods = Payments::getPaymentMethodsAll();
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    public function render()
    {
        if($this->settingsGroup === AppSettingsGroupEnum::notifications()->value) {
            return view('livewire.dashboard.forms.settings.app-settings-notifications-form');
        }

        return view('livewire.dashboard.forms.settings.app-settings-form');
    }

    public function saveAdvanced($rule_set) {
        $rules = $this->getRuleSet($rule_set);

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

            $this->inform(translate('Advanced settings successfully saved.'), '', 'success');
        } catch(\Exception $e) {
            DB::rollback();
            $this->inform(translate('Could not save advanced settings.'), $e->getMessage(), 'fail');
        }
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

    public function saveIntegrations($rule_set) {
        $rules = $this->getRuleSet($rule_set);

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

    public function generateColorPalette() {
        $response = Http::get('https://tailwind.simeongriggs.dev/api/indigo/' . $this->settings['colors']['primary']);

        $this->settings['colors']['indigo'] = $response->body();
        $this->colors;



        return $response;

    }
}
