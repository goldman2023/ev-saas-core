<?php

namespace App\Http\Livewire\Dashboard\Forms\Users;

use App\Models\PaymentMethod;
use App\Models\PaymentMethodUniversal;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\SerialNumber;
use App\Models\User;
use App\Traits\Livewire\RulesSets;
use Categories;
use DB;
use EVS;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Permissions;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;

class InviteStaffForm extends Component
{
    use RulesSets;

    public $email;

    protected function rules()
    {
        return [
            'email' => ['required', 'email:rfc,dns'],
        ];
    }

    protected function messages()
    {
        return [
            'email.required' => translate('Email of invitee is required'),
            'email.email' => translate('Not a valid email address'),
        ];;
    }

    /**
     * Create a new component instance.
     *
     * @param mixed|null $user
     * @param string $class
     * @return void
     */
    public function mount()
    {
       
    }

    public function dehydrate()
    {
        // $this->dispatchBrowserEvent('init-form');
    }

    public function sendInvite()
    {
        $this->validate();

        $this->inform(translate('Invite successfully sent!'), '', 'success');
    }

    public function render()
    {
        return view('livewire.dashboard.forms.users.invite-staff-form');
    }
}
