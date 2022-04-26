<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BillingAddress extends Component
{
    public $line1;

    public $city;

    public $country;

    public $line2;

    public $postal_code;

    public $state;

    public $success;

    protected $listeners = ['billingUpdated' => '$refresh'];

    public function mount()
    {
        $customer = tenant()->asStripeCustomer();

        if ($customer->address) {
            $this->line1 = $customer->address->line1;
            $this->city = $customer->address->city;
            $this->country = $customer->address->country;
            $this->line2 = $customer->address->line2;
            $this->postal_code = $customer->address->postal_code;
            $this->state = $customer->address->state;
        }
    }

    public function save()
    {
        $validated = $this->validate([
            'line1' => 'required|string',
            'city' => 'nullable|string',
            'country' => 'nullable|string|size:2',
            'line2' => 'nullable|string',
            'postal_code' => 'nullable|numeric',
            'state' => 'nullable|string',
        ]);

        tenant()->updateStripeCustomer(['address' => $validated]);

        $this->success = 'Address saved.';

        $this->emit('billingUpdated');
    }

    public function render()
    {
        return view('livewire.tenant.billing-address');
    }
}
