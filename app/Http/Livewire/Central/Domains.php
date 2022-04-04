<?php

namespace App\Http\Livewire;

use App\Models\Domain;
use Livewire\Component;

class Domains extends Component
{
    protected $listeners = ['domainsUpdated' => '$refresh'];

    public function makePrimary($domain)
    {
        /** @var Domain $domain */
        $domain = tenant()->domains()->where('id', $domain)->first();

        if ($domain) {
            $domain->makePrimary();
        }
    }

    public function delete($domain)
    {
        $domain = tenant()->domains()->firstWhere('id', $domain);

        $domain->delete();
    }

    public function requestCertificate($domain)
    {
        ploi()->requestCertificate(tenant()->domains()->firstWhere('id', $domain));
    }

    public function revokeCertificate($domain)
    {
        ploi()->revokeCertificate(tenant()->domains()->firstWhere('id', $domain));
    }

    public function render()
    {
        return view('livewire.tenant.domains');
    }
}
