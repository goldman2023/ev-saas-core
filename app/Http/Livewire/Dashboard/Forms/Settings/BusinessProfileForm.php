<?php

namespace App\Http\Livewire\Dashboard\Forms\Settings;

use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use App\Traits\Livewire\RulesSets;
use Illuminate\Support\Facades\Http;
use TenantSettings;
use App\Models\TenantSetting;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Validation\Rule;
use DB;

class BusinessProfileForm extends Component
{
    public $settings;

    public function mount(){
        $this->settings = TenantSettings::getAll();

    }

    public function render()
    {
        return view('livewire.dashboard.forms.settings.business-profile-form');
    }
}
