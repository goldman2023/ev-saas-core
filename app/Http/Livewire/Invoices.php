<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Invoices extends Component
{
    protected $listeners = ['billingUpdated' => '$refresh'];

    public function render()
    {
        return view('livewire.tenant.invoices');
    }
}
