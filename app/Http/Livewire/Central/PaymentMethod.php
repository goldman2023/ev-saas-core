<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PaymentMethod extends Component
{
    protected $listeners = ['billingUpdated' => '$refresh'];

    public $paymentMethod = '';

    public function render()
    {
        return view('livewire.tenant.payment-method', [
            'intent' => tenant()->createSetupIntent(),
        ]);
    }

    public function save()
    {
        $this->validate([
            'paymentMethod' => 'required|string|regex:/^pm/',
        ]);

        tenant()->updateDefaultPaymentMethod($this->paymentMethod);

        $this->emit('billingUpdated');
    }
}
