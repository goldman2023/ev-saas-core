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
use App\Enums\WeMailingListsEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\ValidationRules\Rules\ModelsExist;
use Str;
use Log;
use App\Mail\PasswordResetEmail;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordForm extends Component
{
    use DispatchSupport;

    public $email;

    protected function rules()
    {
        return [
            'email' => 'required|email:rfc,dns|exists:App\Models\User,email',
        ];
    }

    protected function messages()
    {
        return [
            'email.required' => translate('Email is required'),
            'email.exists' => translate('Invalid credentials'),
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
        return view('livewire.forms.forgot-password-form');
    }

    public function forgotPassword()
    {
        $this->validate();

        $user = User::where('email', $this->email)->first();

        if(!empty($user)) {
            $user->verification_code = sha1($this->email.'_'.rand(100000, 9999999));
            $user->save();

            try {
                Mail::to($user->email)->send(new PasswordResetEmail($user));
            } catch(\Exception $e) {
                Log::error($e->getMessage());

                $this->inform(translate('Could not send reset password email'), 'Please try again or call support', 'fail');
                return;
            }

            $this->inform(translate('Password reset link successfully sent'), 'Please check your email to reset the password', 'success');
        }        
    }
}
