<?php

namespace WeThemes\WePixPro\App\Http\Livewire\Forms;

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
        return view('livewire.forms.generate-license-form');
    }

    public function generate()
    {
        $this->validate();

        $license = License::findOrFail($this->license_id);

        try {
            $response = pix_pro_activate_license($license->user, $this->serial_number, $this->hw_id);

            if(!empty($response) && !empty($response['status'] ?? null) && $response['status'] === 'success') {
                $license->data = array_merge($license->data, [
                    'file_name' => $response['license_file']['file_name'] ?? '',
                    'file_contents' => $response['license_file']['file_contents'] ?? ''
                ]);
                $license->save();

                $this->emit('refreshDatatable');
                $this->inform(translate('You successfully activated your license!'), translate('Serial number: ').$this->serial_number, 'success');

                return response()->streamDownload(function () {
                    echo $response['license_file']['file_contents'] ?? '';
                }, $response['license_file']['file_name'] ?? '');
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
