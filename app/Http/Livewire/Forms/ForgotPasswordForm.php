<?php

namespace App\Http\Livewire\Forms;

use Log;
use Uuid;
use MailerService;
use App\Models\User;
use Livewire\Component;
use App\Traits\Livewire\DispatchSupport;
use App\Notifications\PasswordResetRequest;

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
            $user->verification_code = sha1($this->id.'_'.$this->email.'_'.Uuid::generate(4)->string);
            $user->save();

            try {
                MailerService::notify($user, new PasswordResetRequest());
            } catch(\Exception $e) {
                Log::error($e->getMessage());

                $this->inform(translate('Could not send reset password email'), 'Please try again or call support', 'fail');
                return;
            }

            $this->inform(translate('Password reset link successfully sent'), 'Please check your email to reset the password', 'success');
        }        
    }
}
