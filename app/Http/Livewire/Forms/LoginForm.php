<?php

namespace App\Http\Livewire\Forms;

use DB;
use EVS;
use Categories;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use Str;
use Auth;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Address;
use App\Traits\Livewire\RulesSets;
use App\Traits\Livewire\DispatchSupport;
use App\Models\PaymentMethodUniversal;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\CardExpirationDate;
use App\Enums\OrderTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\ShippingStatusTypeEnum;
use Carbon;

class LoginForm extends Component
{
    use DispatchSupport;

    public $email;
    public $password;
    public $remember;


    protected function rules()
    {
        return [
            'email' => 'required|exists:App\Models\User,email',
            'password' => 'required|match_password:App\Models\User,email',
        ];
    }

    protected function messages()
    {
        return [
            'email.required' => translate('Email is required'),
            'email.exists' => translate('Invalid credentials'),
            'password.required' => translate('Password is required'),
            'password.match_password' => translate('Invalid credentials'),
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
        if(session('style_framework') === 'tailwind') {
            return view('livewire.tailwind.forms.login-form');
        }

        return view('livewire.forms.login-form');
    }

    public function login() {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            request()->session()->regenerate();

            return redirect()->route('home');
        }

        return redirect()->route('home');
    }
}
