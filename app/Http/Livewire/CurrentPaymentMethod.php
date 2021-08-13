<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CurrentPaymentMethod extends Component
{
    protected $listeners = ['billingUpdated' => '$refresh'];

    public function render()
    {
        return view('livewire.tenant.current-payment-method');
    }
}
