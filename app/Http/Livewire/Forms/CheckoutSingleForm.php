<?php

namespace App\Http\Livewire\Forms;

use DB;
use EVS;
use Categories;
use App\Models\Order;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use Str;
use Auth;
use App\Models\User;
use App\Traits\Livewire\RulesSets;

class CheckoutSingleForm extends Component
{
    use RulesSets;

    public $form;
    public $manual_mode_billing = true;
    public $manual_mode_shipping = true;
    public $show_addresses = false;
    public $addresses = [];
    public $selected_billing_address_id;
    public $selected_shipping_address_id;
    public $checkout_newsletter = false;
    public $buyers_consent = false;

    // Account
    public $account_password;
    public $account_password_confirmation;

    protected $listeners = [];

    protected function rules()
    {
        $rules = [];
        $rulesSets = [
            'main' => [
                'form.email' => 'required|email:rfc,dns',
                'form.billing_first_name' => 'required|min:3',
                'form.billing_last_name' => 'required|min:3',
                'form.billing_company' => 'nullable',
                'form.same_billing_shipping' => 'nullable',
                'form.phone_numbers' => 'array|required',

                'payment_method' => ['required', Rule::in(\App\Models\PaymentMethodUniversal::$available_gateways)],
                'checkout_newsletter' => 'nullable',
                'buyers_consent' => 'required',
                'selected_billing_address_id' => '',
            ],
            'account_creation' => [
                'account_password' => 'required|confirmed|min:6'
            ],
            'billing' => [
                'form.billing_address' => 'required|min:5',
                'form.billing_country' => ['required', Rule::in(\Countries::getCodesAll(true))],
                'form.billing_state' => 'nullable',
                'form.billing_city' => 'required|min:3',
                'form.billing_zip' => 'required|min:2',
            ],
            'selected_billing_address' => [
                'selected_shipping_address_id' => 'required|if_id_exists:App\Models\Address,id',
            ],
            'shipping' => [
                'shipping_address' => 'required|min:5',
                'shipping_country' => ['required', Rule::in(\Countries::getCodesAll(true))],
                'shipping_state' => 'nullable',
                'shipping_city' => 'required|min:3',
                'shipping_zip' => 'required|min:2',
            ],
            'selected_shipping_address' => [
                'selected_shipping_address_id' => 'required|if_id_exists:App\Models\Address,id',
            ],
            'registered_user_password_rule' => [
                'account_password' => 'match_password:App\Models\User,email'
            ],
            'non_registered_user_password_rule' => [
                'account_password' => 'required|confirmed|min:6'
            ]
        ];

        $add_billing_shipping_rules = function($is_billing_selected = false) use(&$rulesSets, &$rules) {
            $rules = array_merge($rulesSets['main'], $is_billing_selected ? $rulesSets['selected_billing_address'] : $rulesSets['billing']);

            if(empty($this->same_billing_shipping)) {
                if((int) $this->selected_shipping_address_id === -1) {
                    // Shipping address IS NOT a selected address, but a manually added address!
                    $rules = array_merge($rules, $rulesSets['shipping']);
                } else {
                    // Shipping address IS a selected address
                    $rules = array_merge($rules, $rulesSets['selected_shipping_address']);
                }
            }

            // User cretion rules (password)
            if(!Auth::check()) {
                $new_user = User::where('email', $this->form->email)->first(); // check if user with a given email already exists
                
                // Check if user with email is not already registered user.
                if($new_user instanceof User && !empty($new_user->id ?? null)) {
                    // Registered user
                    $rules = array_merge($rules, $rulesSets['registered_user_password_rule']);
                } else {
                    // Not registered user
                    $rules = array_merge($rules, $rulesSets['non_registered_user_password_rule']);
                }
            }
        };

        if(Auth::check()) {
            if((int) $this->selected_billing_address_id === -1) {
                // Always validate billing info when user IS logged-in AND DID NOT select billing address
                $add_billing_shipping_rules();
            } else {
                $add_billing_shipping_rules(true);
            }
        } else {
            // Always validate billing info when user is not authenticated
            $add_billing_shipping_rules();
        }

    
        return $rules;
    }

    protected function messages()
    {
        return [
            'account_password.match_password' => translate('Password is not correct for a given email. If you want to create an order under provided email, you have to know password of the user under given email. If you don\'t know, either use Forgot password or create another account. under different email.')
        ];
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount()
    {
        $this->form = new Order();
        $this->form->same_billing_shipping = true;

        $this->manual_mode_billing = !\Auth::check();
        $this->manual_mode_shipping = !\Auth::check();
        $this->show_addresses = \Auth::check() && auth()->user()->addresses->isNotEmpty();
        $this->addresses = \Auth::check()  ? auth()->user()->addresses->map(function($item) {
            $item->country = \Countries::get(code: $item->country)->name ?? translate('Unknown');
            return $item;
        }) : [];
        $this->selected_billing_address_id = $this->show_addresses ?
            (auth()->user()->addresses->firstWhere('is_primary', true)->id ?? -1) : -1;

        $this->selected_shipping_address_id = $this->show_addresses ?
            (auth()->user()->addresses->firstWhere('is_primary', true)->id ?? -1) : -1;

        if($this->selected_billing_address_id === -1)
            $this->manual_mode_billing = true;

        if($this->selected_shipping_address_id === -1)
            $this->manual_mode_shipping = true;
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initCheckoutForm');
    }

    public function render()
    {
        return view('livewire.checkout.checkout-single-form');
    }

    protected function pay(): void
    {
        dd($this->getRules());
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }
    }
}
