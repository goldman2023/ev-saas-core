<?php

namespace WeThemes\WePixPro\App\Http\Livewire\Dashboard\Forms;

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

class GenerateLicenseForm extends Component
{
    use DispatchSupport;

    public $license_id;
    public $hw_id;
    public $serial_number;

    protected function rules()
    {
        return [
            'license_id' => 'nullable',
            'hw_id' => 'required',
            'serial_number' => ['required'],
        ];
    }

    protected function messages()
    {
        return [
            'hw_id.required' => translate('Hardware ID is required'),
            'serial_number.required' => translate('Serial Number is required'),
        ];
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.dashboard.forms.generate-license-form');
    }

    public function generate()
    {
        $this->validate();

        $license = License::findOrFail($this->license_id);

        try {
            $response = pix_pro_activate_license($license->user, $this->serial_number, $this->hw_id);

            if(!empty($response) && ($response['status'] ?? null) === 'success' && ($response['license_file']['status'] ?? null) === 'success') {
                $license->mergeData([
                    'file_name' => $response['license_file']['file_name'] ?? '',
                    'file_contents' => $response['license_file']['file_contents'] ?? '',
                    'hardware_id' => $response['license']['hardware_id'] ?? $this->hw_id,
                ]);
                $license->save();

                $this->emit('refreshDatatable');
                $this->inform(translate('You successfully activated your license!'), translate('Serial number: ').$this->serial_number, 'success');

                return response()->streamDownload(function () use($license) {
                    echo $license->getData('file_contents');
                }, $license->getData('file_name'));
            }

            $this->inform(translate('Cannot activate the license(invalid Hardware ID) OR license is already activated...'), translate('Serial number: ').$this->serial_number, 'fail');
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            $this->inform(translate('Cannot activate the license(invalid Hardware ID) OR license is already activated...'), $e->getMessage(), 'fail');

        }
    }

    public function resetForm() {

    }
}
