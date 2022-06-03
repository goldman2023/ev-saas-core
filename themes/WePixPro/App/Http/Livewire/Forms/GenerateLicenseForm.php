<?php

namespace WeThemes\WePixPro\App\Http\Livewire\Forms;

use App\Models\User;
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

    public $hw_id;
    public $serial_number;

    protected function rules()
    {
        return [
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

        try {
           
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }

        // $this->inform(translate('Thank you for successfully subscribing to our newsletter!'), '', 'success');

        // $this->resetForm();
    }

    public function resetForm() {
        
    }
}
