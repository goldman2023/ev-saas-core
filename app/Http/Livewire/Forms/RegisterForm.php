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
USE App\Models\UserMeta;
use App\Traits\Livewire\RulesSets;
use App\Traits\Livewire\DispatchSupport;
use MailerService;
use App\Enums\WeMailingListsEnum;

use Illuminate\Auth\Events\Registered;
use MikeMcLin\WpPassword\Facades\WpPassword;

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
    public $available_meta;
    public $user_meta = [];

    protected function rules()
    {
        $rules = [
            'entity' => 'required|in:individual,company',
            'name' => 'required|min:2',
            'surname' => 'required|min:2',
            'email' => 'required|unique:App\Models\User,email',
            'password' => ['required', 'min:8', 'regex:/^.*(?=.{1,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/', 'confirmed'],
            'terms_consent' => ['required', 'boolean', 'is_true']
        ];

        if($this->available_meta->count() > 0) {
            foreach($this->available_meta as $key => $options) {
                $rules['user_meta.'.$key] = [];

                if(in_array($key, UserMeta::metaForCompanyEntity())) {
                    $rules['user_meta.'.$key][] = 'exclude_if:entity,individual';
                }

                if($options['required'] ?? false) {
                    $rules['user_meta.'.$key][] = 'required';
                }
            }
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'name.required' => translate('First name is required'),
            'name.min' => translate('Minimum 2 characters required'),
            'surname.required' => translate('Last name is required'),
            'surname.min' => translate('Minimum 2 characters required'),
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
        $this->available_meta = collect(get_tenant_setting('user_meta_fields_in_use'))->where('registration', true);

        if($this->available_meta->count() > 0) {
            foreach($this->available_meta as $key => $options) {
                $this->user_meta[$key] = '';
            }
        }
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
            
            // Create UserMeta if any is allowed in registration process
            if(!empty($this->user_meta)) {
                foreach($this->user_meta as $key => $value) {
                    UserMeta::create([
                        'user_id' => $this->user->id,
                        'key' => $key,
                        'value' => $value,
                    ]);
                }
            }
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

        // Save md5 password in core_meta
        $this->user->saveCoreMeta('password_md5', WpPassword::make($this->password));

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
        do_action('user.registered', $this->user); // If there's any hook attached to `user.registered` action, do it!   

        if(get_tenant_setting('onboarding_flow')) {
            return redirect()->route('onboarding.step1');
        }

        if(!get_tenant_setting('onboarding_flow')) {
            if(!empty(get_tenant_setting('register_redirect_url', null))) {
                return redirect(get_tenant_setting('register_redirect_url'));
            } else {
                return redirect()->route('dashboard');
            } 
        }
    }
}
