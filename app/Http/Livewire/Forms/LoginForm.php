<?php

namespace App\Http\Livewire\Forms;

use App\Models\Address;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\RulesSets;
use Auth;
use Carbon;
use Categories;
use DB;
use EVS;
use MailerService;
use Payments;
use StripeService;
use App\Enums\WeMailingListsEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\ValidationRules\Rules\ModelsExist;
use Str;
use Log;

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
        return view('livewire.forms.login-form');
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    public function login()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            request()->session()->regenerate();

            // Add to mailerlite if user's 'in_mailerlite' core_meta is null or non existent (must be loose comparison)
            if(auth()->user()->getCoreMeta('in_mailerlite') != 1) {
                $subscriber = MailerService::mailerlite()?->addSubscriberToGroup(WeMailingListsEnum::all_users()->label, auth()->user()) ?? null;
                
                if(!empty($subscriber)) {
                    auth()->user()->core_meta()->updateOrCreate(
                        ['key' => 'in_mailerlite'],
                        ['value' => 1]
                    );
                }
            }

            // Check customer existence in Stripe if Stripe is enabled
            if(Payments::isStripeEnabled()) {
                StripeService::createStripeCustomer(auth()->user()); // will create customer in stripe if one doesn't already exist
            }

            if (!empty(get_tenant_setting('login_redirect_url'))) {
                return redirect(get_tenant_setting('login_redirect_url'));
            } else {
                return redirect()->route('home');
            }
        }

        return redirect()->route('home');
    }
}
