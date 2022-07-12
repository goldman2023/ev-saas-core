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
                'business.cover' => ['sometimes', 'if_id_exists:App\Models\Upload,id,true'],
                'business.name' => ['required', 'min:3'],
                'business.excerpt' => ['required', 'min:30'],
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
            'seo' => [
                'business.meta_title' => ['required', 'min:3'],
                'business.meta_description' => ['required', 'min:3'],
                'business.meta_image' => ['if_id_exists:App\Models\Upload,id'],
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
}
