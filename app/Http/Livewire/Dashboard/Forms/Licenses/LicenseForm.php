<?php

namespace App\Http\Livewire\Dashboard\Forms\Licenses;

use App\Models\User;
use App\Models\License;
use App\Traits\Livewire\DispatchSupport;
use MailerService;
use App\Enums\WeMailingListsEnum;
use Illuminate\Support\Collection;
use Livewire\Component;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Admin\ContactNotification;
use Str;
use Log;

class LicenseForm extends Component
{
    use DispatchSupport;

    public $license;
    public $license_data;

    protected function rules()
    {
        return [
            'license' => '',
            'license.license_name' => 'nullable',
            'license.serial_number' => 'nullable',
            'license.license_type' => 'nullable',
            'license_data' => 'nullable|array',
        ];
    }

    protected function messages()
    {
        return [
            'license_data.array' => translate('Data must be an array'),
        ];
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($license = null)
    {
        if($license instanceof License) {
            $this->license = $license->toArray();
        }
    }

    public function render()
    {
        return view('livewire.dashboard.forms.licenses.license-form');
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    public function setLicense($license_id) {
        try {
            $this->license = License::findOrFail($license_id);
            $this->license_data = $this->license->getEditableData();

            $this->license = $this->license->toArray();
        } catch(\Exception $e) {
            $this->inform(translate('Error: Cannot edit selected license...Please refresh and try again.'), $e->getMessage(), 'fail');
        }
    }

    public function save()
    { 
        $this->validate();

        if(!\Permissions::canAccess(User::$non_customer_user_types, ['all_licenses', 'browse_licenses'], false)) {
            $this->inform(translate('You don\'t have enough permissions to change License!'), $this->license['id'], 'fail');
            return;
        }

        try {
            // From Array to Model object
            $old_license = License::findOrFail($this->license['id']);
            
            $license = License::findOrFail($this->license['id']);
            $license->forceFill($this->license);
            $license->setEditableData($this->license_data);
            $license->save();
            
            do_action('license.saved', $license, $old_license);
            
            $this->license = License::findOrFail($this->license['id'])->toArray();
            $this->license_data = $license->getEditableData();
            
            $this->emit('refreshDatatable');
            $this->inform(translate('You successfully saved the license!'), translate('Serial number: ').$license->serial_number, 'success');
        } catch(\Exception $e) {
            $this->inform(translate('Error: Couldn\'t save/update license...'), $e->getMessage(), 'fail');

            Log::error($e->getMessage());
        }
    }
}
