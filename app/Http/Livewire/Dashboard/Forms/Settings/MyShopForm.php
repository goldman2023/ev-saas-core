<?php

namespace App\Http\Livewire\Dashboard\Forms\Settings;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\SerialNumber;
use App\Models\Shop;
use App\Rules\UniqueSKU;
use App\Traits\Livewire\DispatchSupport;
use DB;
use EVS;
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

    protected function getRuleSet($set = null, $with_wildcard = true) {
        $rulesSets = collect([
            'basic' => [
                'shop.*' => [],
                'settings.*' => [],
                'shop.thumbnail' => ['sometimes', 'if_id_exists:App\Models\Upload,id,true'],
                'shop.cover' => ['sometimes', 'if_id_exists:App\Models\Upload,id,true'],
                'shop.name' => ['required', 'min:3'],
                'shop.excerpt' => ['required', 'min:30'],
                'shop.content' => ['required', 'min:50'],
                'settings.shop_tagline' => ['required'],
                'settings.company_phones' => ['required'],
                'settings.company_email' => ['required', ], //'email:rfs,dns'
                'settings.websites' => ['required'],
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
            'me.thumbnail.if_id_exists' => translate('Selected thumbnail does not exist in Media Library. Please select again.'),
            'me.cover.if_id_exists' => translate('Selected cover does not exist in Media Library. Please select again.'),
        ];
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($toast_id = 'my-shop-updated-toast')
    {
        $this->shop = auth()->user()->shop()->first();
        $this->settings = $this->shop->settings->keyBy('setting')->map(fn($item) => $item['value'])->toArray();
        $this->addresses = $this->shop->addresses;
        $this->domains = $this->shop->domains;
        $this->toast_id = $toast_id;
    }

    public function updatingShop(&$shop, $key) {
        if(!$shop instanceof Shop) {
            $shop = Shop::find($shop['id'])->fill($shop); // alpinejs passes arrays as data instead of Model type. This is the reason why we have to convert it to Address model.
        }
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initShopSettingsFormInit');
    }

    public function render()
    {
        return view('livewire.dashboard.forms.settings.my-shop-form');
    }

    public function saveBasicInformation() {
        $rules = $this->getRuleSet('basic');

        $this->validate($rules);
        $this->shop->offsetUnset('pivot'); // WHY THE FUCK IS PIVOT attribute ADDED TO THE MODEL ATTRIBUTES LIST????

        $this->shop->syncUploads();
        $this->shop->content = Purifier::clean($this->shop->content); // TODO: Fix purifier to prevent XSS

        $this->shop->save();

        // Save data in settings table
        $old_settings = $this->shop->settings()->get()->keyBy('setting');

        foreach(collect($rules)->filter(fn($item, $key) => str_starts_with($key, 'settings')) as $key => $value) {
            $setting_key = explode('.', $key)[1];

            if(!empty($setting_key) && $setting_key !== '*') {
                $setting = $old_settings->get($setting_key);
                $setting->value = $this->settings[$setting_key];
                $setting->save();
            }

        }

        $this->toastify(translate('Basic shop information successfully updated.', 'success'));
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

        $contact_details = $this->shop->settings->keyBy('setting')->get('contact_details');
        $contact_details->value = json_encode($contacts);
        $contact_details->save();

        $this->settings['contact_details'] = $contact_details->value;

        $this->dispatchBrowserEvent('contact-details-modal-hide');
        $this->toastify(translate('Contact details successfully updated.', 'success'));
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
}
