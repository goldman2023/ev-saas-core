<?php

namespace App\Http\Livewire\Dashboard\Forms\Users;

use App\Models\PaymentMethod;
use App\Models\PaymentMethodUniversal;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\SerialNumber;
use App\Models\User;
use App\Rules\UniqueSKU;
use DB;
use EVS;
use Categories;
use Illuminate\Validation\Rule;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use App\Traits\Livewire\RulesSets;

class UserSettingsCard extends Component
{
    use RulesSets;

    public $user;
    public $permissions;
    public $class;

    protected function rules()
    {
        $rules = [
            'user.id' => [],
            'user.user_type' => [Rule::in(User::$user_types)],
            'user.name' => ['required','min:3'],
            'user.email' => ['required', 'email:rfc,dns'],

        ];

        return $rules;
    }

    protected function messages()
    {
        $messages = [
            'user.name.required' => translate('User name is required'),
            'user.name.min' => translate('User name must be at least :min characters'),
            'user.email.required' => translate('User email is required'),
            'user.email.email' => translate('User email must be a valid email address'),
            'user.user_type.in' => translate('Only available user types for now are: '.implode(', ', User::$user_types)),
        ];

        return $messages;
    }

    /**
     * Create a new component instance.
     *
     * @param mixed|null $user
     * @param string $class
     * @return void
     */
    public function mount(mixed &$user = null, $class = '')
    {
        $this->user = $user;
        $this->class = $class;
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initUserSettingsForm');
    }


    public function save() {
        $this->validate();

        $this->user->save();

        $this->dispatchBrowserEvent('toast', ['id' => 'payment-method-updated-toast', 'content' => $this->paymentMethod->name.' '.translate(' method updated successfully!'), 'type' => 'success' ]);
    }

    public function render()
    {
        return view('livewire.dashboard.forms.users.user-settings-card');
    }
}
