<?php

namespace App\Http\Livewire\Dashboard\Forms\Licenses;

use App\Models\License;
use Livewire\Component;

class LicenseHistory extends Component
{
    public $license;

    public function setLicense($license_id) {
        try {
            $this->license = License::findOrFail($license_id);
            $this->license_data = $this->license->getEditableData();

            $this->license = $this->license;
            // dd($this->license);
        } catch(\Exception $e) {
            $this->inform(translate('Error: Cannot edit selected license...Please refresh and try again.'), $e->getMessage(), 'fail');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.forms.licenses.license-history');
    }
}
