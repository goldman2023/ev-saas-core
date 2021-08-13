<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Illuminate\Support\Str;

class NewDomain extends Component
{
    public $domain = '';

    public function save()
    {
        $this->validate([
            'domain' => [
                'required',
                'string',
                'unique:central.domains',
                'regex:/^[A-Za-z0-9]+[A-Za-z0-9.-]+[A-Za-z0-9]+$/',
                'regex:/\\./', // Must contain a dot
                function ($attribute, $value, $fail) {
                    if (Str::endsWith($value, config('tenancy.central_domains')[0])) {
                        $fail($attribute . ' must be a custom domain.');
                    }
                }
            ],
        ]);

        $domain = tenant()->createDomain($this->domain);

        $this->emit('domainsUpdated');

        $this->domain = '';
    }

    public function render()
    {
        return view('livewire.tenant.new-domain');
    }
}
