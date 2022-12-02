<?php

namespace App\Http\Livewire\Forms;

use DB;
use Log;
use MailerService;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Invoice;
use Livewire\Component;
use App\Models\OrderItem;
use Illuminate\Validation\Rule;
use App\Mail\PasswordResetEmail;
use App\Enums\WeMailingListsEnum;
use App\Traits\Livewire\RulesSets;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Contracts\Support\Arrayable;
use Spatie\ValidationRules\Rules\ModelsExist;

class ResetPasswordForm extends Component
{
    use DispatchSupport;

    public $user;
    public $new_password;
    public $new_password_confirmation;


    protected function rules()
    {
        return [
            'new_password' => ['required', 'min:8', 'regex:/^.*(?=.{1,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/', 'confirmed'],
        ];
    }

    protected function messages()
    {
        return [
            'new_password.required' => translate('Password is required'),
            'new_password.min' => translate('Length of password must not be less than :min'),
            'new_password.regex' => translate('Password is not as per requirements - minimum 8 chars with at least one lowercase, one uppercase and one number!'),
            'new_password.confirmed' => translate('Password and confirmation must match.'),
        ];
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.forms.reset-password-form');
    }

    public function resetPassword()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            if(!empty($this->user)) {
                $this->user->resetPassword($this->new_password);

                DB::commit();

                $this->inform(translate('Your password is changed successfully'), 'Please login to your account, you\'ll be redirected soon', 'success');
        
                return redirect()->route('user.login');
            }

            throw new \Exception('Trying to reset password of non-existing user...');
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->inform(translate('Could not reset your password'), 'Please try again or go again through reset password flow', 'fail');
        }
        
    }
}
