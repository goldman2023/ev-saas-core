<?php

namespace App\Http\Livewire\Dashboard\Forms\Settings;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\SerialNumber;
use App\Rules\UniqueSKU;
use DB;
use EVS;
use Categories;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use App\Traits\Livewire\RulesSets;

class MyAccountForm extends Component
{
    use RulesSets;

    public $me;
    public $currentPassword = '';
    public $newPassword = '';
    public $newPassword_confirmation = '';

    protected function getRuleSet($set = null) {
        $rulesSets = collect([
            // Basic information rules
            'basic' => [
                //'me' => [],
                'me.name' => ['required', 'min:3'],
//                'me.email' => ['required', 'email:rfs,dns'],
                'me.phone' => ['required'],
                'me.thumbnail' => ['if_id_exists:App\Models\Upload,id'],
                'me.cover' => ['if_id_exists:App\Models\Upload,id']
            ],
            'email' => [
                'me.email' => ['required', 'email:rfs,dns'],
            ],
            'password' => [
                'currentPassword' => ['required', 'match_password:App\Models\User,id,me'],
                'newPassword' => ['required', 'min:8', 'regex:/^.*(?=.{1,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/', 'confirmed'],
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
            'me.thumbnail.exists' => translate('Selected thumbnail does not exist in Media Library. Please select again.'),
            'me.cover.exists' => translate('Selected cover does not exist in Media Library. Please select again.'),
            'me.thumbnail.if_id_exists' => translate('Selected thumbnail does not exist in Media Library. Please select again.'),
            'me.cover.if_id_exists' => translate('Selected cover does not exist in Media Library. Please select again.'),

            'me.name.required' => translate('Full name is required'),
            'me.name.min' => translate('Minimum full name length is :min'),

            'currentPassword.required' => translate('Current password is required in order to update password'),
            'currentPassword.match_password' => translate('Current password does not match the user password. You have to know the current password in order to update it!'),
            'newPassword.required' => translate('New password is required in order to update the old one.'),
            'newPassword.min' => translate('Length of password must not be less than :min'),
            'newPassword.regex' => translate('New password is not as per requirements. Please read requirements below.'),
            'newPassword.confirmed' => translate('Your new password confirmation does not match the new password. New password and confirmation must match.'),
        ];
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount()
    {
        $this->me = auth()->user();

    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initAccountSettingsFormInit');
    }

    public function render()
    {
        return view('livewire.dashboard.forms.settings.my-account-form');
    }


    public function saveBasicInformation() {
        $this->validate($this->getRuleSet('basic'));

        $this->me->syncUploads();
        $this->me->save();

        $this->toastify(translate('Basic information successfully updated!'), 'success');
    }

    public function saveEmail() {
        // TODO: Validation does not work for some reason. Check the error and fix it!
        $this->validate($this->getRuleSet('email'));

        $this->me->save();

        // TODO: Implement Email verification before email is really swapped with new email in the DB!
        $this->toastify(translate('Please go to your email to verify email change!'), 'info');
    }

    public function updatePassword() {
        $this->validate($this->getRuleSet('password'));

        // Update password
        $this->me->password = Hash::make($this->newPassword);
        $this->me->save();

        // TODO: Logout the User

        $this->toastify(translate('Your password is successfully updated. You will be logged out.'), 'success');
    }

    protected function toastify($msg = '', $type = 'info') {
        $this->dispatchBrowserEvent('toast', ['id' => $this->toast_id, 'content' => $msg, 'type' => $type ]);
    }
}
