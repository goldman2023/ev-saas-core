<?php

namespace App\Http\Livewire\Dashboard\Forms\Settings;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\SerialNumber;
use App\Models\Shop;
use App\Models\ShopSetting;
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

class MyShopForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $shop;
    public $settings;
    public $addresses;
    public $domains;
    public $onboarding = false;

    protected function getRuleSet($set = null, $with_wildcard = true) {
        $rulesSets = collect([
            'basic' => [
                // 'shop.*' => [],
                'settings.*' => [],
                'shop.thumbnail' => ['sometimes', 'if_id_exists:App\Models\Upload,id,true'],
                'shop.cover' => ['sometimes', 'if_id_exists:App\Models\Upload,id,true'],
                'shop.name' => ['required', 'min:3'],
                'shop.excerpt' => ['required', 'min:30'],
                'shop.content' => 'nullable', //['required', 'min:50'],
                'settings.tagline' => ['required'],
                'settings.phones' => ['required'],
                'settings.email' => ['required', ], //'email:rfs,dns'
                'settings.websites' => ['required'],
            ],
            'company_info' => [
                'settings.tax_number' => [''],
                'settings.registration_number' => ['']
            ],
            'settings' => [
                'settings.*' => [],

            ],
            'contact_details' => [
                'settings.contact_details' => ['required'],
            ],
            'domains' => [],
            'seo' => [
                'shop.meta_title' => ['required', 'min:3'],
                'shop.meta_description' => ['required', 'min:3'],
                //'shop.meta_image' => ['if_id_exists:App\Models\Upload,id'],
            ],
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
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($onboarding = false)
    {
        $this->onboarding = $onboarding;
        $this->shop = MyShop::getShop();
        $this->settings = $this->shop->settings()->get()->keyBy('setting')->map(fn($item) => $item['value'])->toArray();
        $this->addresses = $this->shop->addresses;
        $this->domains = $this->shop->domains;
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
        return view('livewire.dashboard.forms.settings.my-shop-form');
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

        if($this->onboarding) {
            return redirect()->route('onboarding.step4');
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
        // Save data in settings table
        $old_settings = $this->shop->settings()->get()->keyBy('setting'); // Get ShopSetting models and key them by their name (aka. `setting` column)

        foreach(collect($rules)->filter(fn($item, $key) => str_starts_with($key, 'settings')) as $key => $value) {
            $setting_key = explode('.', $key)[1];

            if(!empty($setting_key) && $setting_key !== '*') {
                $setting = $old_settings->get($setting_key);

                // If $setting does not exist in old_settings, create it and save it!!!
                if(empty($setting)) {
                    $setting = new ShopSetting();
                    $setting->shop_id = $this->shop->id;
                    $setting->setting = $setting_key;
                }

                $setting->value = is_array($this->settings[$setting_key]) || is_object($this->settings[$setting_key]) ? json_encode($this->settings[$setting_key]) : $this->settings[$setting_key];
                $setting->save();
            }
        }
    }
}
