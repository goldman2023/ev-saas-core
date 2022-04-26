<?php

namespace App\Http\Livewire\Forms;

use App\Mail\WelcomeEmail;
use DB;
use EVS;
use Categories;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use Str;
use Cookie;
use Auth;
use Log;
use App\Models\User;
use App\Traits\Livewire\RulesSets;
use App\Traits\Livewire\DispatchSupport;
use MailerService;
use App\Enums\WeMailingListsEnum;

use Illuminate\Auth\Events\Registered;

use Carbon;
use Illuminate\Support\Facades\Mail;

class RegisterForm extends Component
{
    use DispatchSupport;

    protected $user;
    public $entity = 'individual';
    public $name;
    public $surname;
    public $email;
    public $password;
    public $password_confirmation;
    public $terms_consent;

    protected function rules()
    {
        return [
            'entity' => 'required|in:individual,company',
            'name' => 'required|min:2',
            'surname' => 'required|min:2',
            'email' => 'required|unique:App\Models\User,email',
            'password' => ['required', 'min:8', 'regex:/^.*(?=.{1,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/', 'confirmed'],
            'terms_consent' => ['required', 'boolean', 'is_true']
        ];
    }

    protected function messages()
    {
        return [
            'entity.required' => translate('User type is required'),
            'entity.in' => translate('User type can be either individual or company'),
            'email.required' => translate('Email is required'),
            'email.unique' => translate('Email already in use'),
            'password.required' => translate('Password is required'),
            'password.min' => translate('Length of password must not be less than :min'),
            'password.regex' => translate('Password is not as per requirements - minimum 8 chars with at least one lowercase, one uppercase and one number!'),
            'password.confirmed' => translate('Password and confirmation must match.'),
            'terms_consent.required' => translate('Terms and conditions consent is required.'),
            'terms_consent.boolean' => translate('Terms and conditions consent is required.'),
            'terms_consent.is_true' => translate('Terms and conditions consent is required bool.'),
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
        return view('livewire.forms.register-form');
    }

    public function register()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            // Register new User here!
            $this->createUser();

            DB::commit();

            // Login user and start display `verification` or `onboarding` flow
            if (Auth::attempt(['email' => $this->user->email, 'password' => $this->password], true)) {
                request()->session()->regenerate();

                // Automatically verify newly created user email if onboarding flow is disabled AND email verification is not forced!
                if(!get_tenant_setting('onboarding_flow') && !get_tenant_setting('force_email_verification')) {
                    $this->user->email_verified_at = date('Y-m-d H:m:s');
                }
                
                $this->user->save();
                flash(translate('Registration successfull. Please verify your email.'))->success();

                return $this->registered() ?: redirect('/');
            } else {
                throw new \Exception('There was an error while signing in to newly created account.');
            }
        } catch (\Throwable $e) {
            DB::rollback();
            $this->inform(translate('Error: Could not create a new account!'), $e->getMessage(), 'fail');
        }

        
    }

    protected function createUser()
    {
        $this->user = User::create([
            'entity' => $this->entity,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'user_type' => User::$customer_type,
            'password' => Hash::make($this->password),
        ]);

        if (Cookie::has('referral_code')) {
            $referral_code = Cookie::get('referral_code');
            $referred_by_user = User::where('referral_code', $referral_code)->first();
            if ($referred_by_user != null) {
                $this->user->referred_by = $referred_by_user->id;
                $this->user->save();
            }
        }
    }

    protected function registered()
    {
        
        try {
            // Adding User to MailerLite 'All Users' group
            MailerService::mailerlite()->addSubscriberToGroup(WeMailingListsEnum::all_users()->label, $this->user);
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        } 

        try {
            // Send welcome email to the user
            Mail::to($this->user->email)
                ->send(new WelcomeEmail($this->user));
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
        
        if(get_tenant_setting('onboarding_flow')) {
            return redirect()->route('onboarding.step1');
        }

        if(!get_tenant_setting('onboarding_flow')) {
            if(get_tenant_setting('force_email_verification')) {
                // Registered event will trigger SendEmailVerificationNotification listener which will send EmailVerificationNotification through User model
                event(new Registered($this->user));

                return redirect()->route('user.email.verification.page');
            } else if(!empty(get_tenant_setting('register_redirect_url', null))) {
                return redirect(get_tenant_setting('register_redirect_url'));
            } else {
                return redirect()->route('dashboard');
            } 
        }
    }
}
