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
use DB;

class LicenseForm extends Component
{
    use DispatchSupport;

    public $license;
    public $license_data;
    public $formType;
    public $componentId;
    public $user;

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
    public function mount($license = null, $componentId = '', $user = null)
    {
        $this->componentId = $componentId;
        $this->user = $user;

        if($license instanceof License) {
            $this->license = $license->toArray();

            // User can be null if $user is not provided in `pix-pro-licenses-table.blade.php` partial
            if(empty($this->user)) {
                $this->user = $this->license->user;
            }
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
            if(!empty($license_id)) {
                // Update
                $license = License::findOrFail($license_id);
                $this->user = $license->user;
            } else {
                // Insert
                $license = new License();
                $license->user_id = $this->user?->id ?? null;
                $license->plan_id = null;
                $license->license_name = '';
                $license->serial_number = '';
                $license->license_type = '';
            }

            $this->license = $license->toArray();

            $this->license_data = $license->getEditableData();
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

        DB::beginTransaction();

        try {
            if(empty($this->license['id'] ?? false)) {
                $old_license = null;
                $license = new License();
                $license->user_id = $this->user->id;
                $license->plan_id = null;
                $license->license_name = '';
                $license->serial_number = '';
                $license->license_type = '';
            } else {
                // From Array to Model object
                $old_license = License::findOrFail($this->license['id'] ?? null);
                $license = clone $old_license;
            }

            $license->forceFill($this->license);

            $license->setEditableData($this->license_data);

            $license->save();

            do_action('license.saved', $license, $old_license);

            $this->license = $license->toArray();
            $this->license_data = $license->getEditableData();

            DB::commit();

            $this->emit('refreshDatatable');
            $this->inform(translate('You successfully saved the license!'), translate('Serial number: ').$license->serial_number, 'success');
        } catch(\Exception $e) {
            DB::rollback();

            $this->inform(translate('Error: Couldn\'t save/update license...'), $e->getMessage(), 'fail');
            Log::error($e->getMessage());
        }
    }
}
