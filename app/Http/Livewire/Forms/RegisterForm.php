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
use App\Models\UserMeta;
use App\Models\UserInvite;
use App\Enums\UserTypeEnum;
use App\Traits\Livewire\RulesSets;
use App\Traits\Livewire\DispatchSupport;
use MailerService;
use App\Enums\WeMailingListsEnum;
use App\Facades\StripeService;
use Illuminate\Auth\Events\Registered;
use MikeMcLin\WpPassword\Facades\WpPassword;
use Permissions;
use Carbon;
use Illuminate\Support\Facades\Mail;

class RegisterForm extends Component
{
    use DispatchSupport;

    protected $user;
    public $is_ghost;
    public $ghostUser;
    public $entity = 'individual';
    public $name;
    public $surname;
    public $email;
    public $password;
    public $password_confirmation;
    public $terms_consent;
    public $token;
    protected $invite = null;
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

        if ($this->is_ghost) {
            $rules['email'] = ['required', 'unique:App\Models\User,email,' . $this->ghostUser->id];
        }

        if ($this->available_meta->count() > 0) {
            foreach ($this->available_meta as $key => $options) {
                $rules['user_meta.' . $key] = [];

                if (in_array($key, UserMeta::metaForCompanyEntity())) {
                    $rules['user_meta.' . $key][] = 'exclude_if:entity,individual';

                    if($key === 'company_vat') {
                        $rules['user_meta.' . $key][] = 'check_eu_vat_number:company_country';

                    }
                }

                if ($options['required'] ?? false) {
                    $rules['user_meta.' . $key][] = 'required';
                }
            }
        }

        return $rules;
    }

    protected function messages()
    {
        $msgs = [
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
            'user_meta.company_vat.check_eu_vat_number' => translate('VAT number not valid'),
        ];

        if ($this->available_meta->count() > 0) {
            foreach ($this->available_meta as $key => $options) {
                if ($options['required'] ?? false) {
                    $msgs['user_meta.' . $key . '.required'] = translate('Required');
                }
            }
        }

        return $msgs;
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($ghostUser = null)
    {
        $this->token = request()->token ?? null;
        if (!empty($this->token)) {
            $this->invite = UserInvite::where('token', $this->token)->first();
            $this->email = $this->invite->email;
        }

        $this->available_meta = collect(get_tenant_setting('user_meta_fields_in_use'))->where('registration', true);

        if ($this->available_meta->count() > 0) {
            foreach ($this->available_meta as $key => $options) {
                $this->user_meta[$key] = '';
            }
        }

        // If ghost user is provided, finalize registration
        if (!empty($ghostUser)) {
            $this->is_ghost = true;
            $this->ghostUser = $ghostUser;
            $this->entity = $ghostUser->entity;
            $this->name = $ghostUser->name;
            $this->surname = $ghostUser->surname;
            $this->email = $ghostUser->email;
        }
    }

    public function render()
    {
        return view('livewire.forms.register-form');
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    public function register()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            // Register new User here!
            $this->createUser();

            // Create UserMeta if any is allowed in registration process
            if (!empty($this->user_meta)) {
                foreach ($this->user_meta as $key => $value) {
                    UserMeta::create([
                        'user_id' => $this->user->id,
                        'key' => $key,
                        'value' => $value,
                    ]);
                }
            }

            // Invite processing (if any)
            if (!empty($this->token)) {
                $this->invite = UserInvite::where('token', $this->token)->first();

                if (!empty($this->invite) && $this->invite->email === $this->user->email && !$this->invite->accepted) {
                    $this->invite->accepted = true;
                    $this->invite->save();

                    // If invited user if for new staff member, change the user_type and relate it to specified Shop from invite.
                    if ($this->invite->new_user_type === UserTypeEnum::staff()->value) {
                        $this->user->user_type = UserTypeEnum::staff()->value;
                        $this->user->shop()->syncWithoutDetaching([$this->invite->shop_id]);
                        $this->user->save();

                        // Sync permissions and roles
                        if (Permissions::getRoleNames()->contains($this->invite->new_user_role)) {
                            $permissions = Permissions::getRolePermissions($this->invite->new_user_role);
                            $this->user->syncPermissions($permissions);
                            $this->user->syncRoles([$this->invite->new_user_role]);
                        }
                    }
                }
            }

            DB::commit();

            // Login user and start display `verification` or `onboarding` flow
            if (Auth::attempt(['email' => $this->user->email, 'password' => $this->password], true)) {
                request()->session()->regenerate();

                // Automatically verify newly created user email if onboarding flow is disabled AND email verification is not forced!
                if (!get_tenant_setting('onboarding_flow') && !get_tenant_setting('force_email_verification')) {
                    $this->user->email_verified_at = date('Y-m-d H:m:s');
                }

                $this->user->save();
                // flash(translate('Registration successfull. Please verify your email.'))->success();

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
        if ($this->is_ghost) {
            $this->user = User::updateOrCreate([
                'email' => $this->email,
            ], [
                'is_temp' => false,
                'entity' => $this->entity,
                'name' => $this->name,
                'surname' => $this->surname,
                'email' => $this->email,
                'user_type' => UserTypeEnum::customer()->value,
                'password' => Hash::make($this->password),
                'email_verified_at' => date('Y-m-d H:i:s') // must be added manually, cuz ghost user is already in DB
            ]);
        } else {
            $this->user = User::create([
                'entity' => $this->entity,
                'name' => $this->name,
                'surname' => $this->surname,
                'email' => $this->email,
                'user_type' => UserTypeEnum::customer()->value,
                'password' => Hash::make($this->password),
            ]);
        }


        // Save WP md5 password in core_meta
        $this->user->saveCoreMeta('password_md5', Hash::driver('wp')->make($this->password));

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
        do_action('user.registered', $this->user);

        if (get_tenant_setting('onboarding_flow')) {
            return redirect()->route('onboarding.step1');
        }

        if (get_tenant_setting('register_dynamic_redirect')) {
            try {
                $selected_plan_id = request()->session()->get('selected_plan');
                $selected_plan_interval = request()->session()->get('selected_plan_interval');
                
                if(!empty($selected_plan_id) && ($selected_plan_interval == 'month' || $selected_plan_interval == 'year' || $selected_plan_interval == 'annual')) {
                    $selected_plan = \App\Models\Plan::findOrFail($selected_plan_id);

                    $stripe_checkout_link = \StripeService::createSubscriptionCheckoutLink(items: [
                        [
                            'id' => $selected_plan->id,
                            'class' => $selected_plan::class,
                            'qty' => 1
                        ]
                    ], interval: $selected_plan_interval);

                    return redirect($stripe_checkout_link);
                }
            } catch(\Exception $e) {
                return redirect(get_tenant_setting('register_redirect_url'));
            }

            return redirect(get_tenant_setting('register_redirect_url'));
        }

        if (!get_tenant_setting('onboarding_flow')) {
            if (!empty(get_tenant_setting('register_redirect_url', null))) {
                return redirect(get_tenant_setting('register_redirect_url'));
            } else {


                return redirect()->route('dashboard');
            }
        }

        return redirect()->route('home');
    }
}
