<?php

namespace App\Http\Livewire\Dashboard\Forms\Addresses;


use App\Models\Address;
use DB;
use EVS;
use Categories;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use App\Traits\Livewire\RulesSets;

class AddressesForm extends Component
{
    use RulesSets;

    public $addresses;
    public ?Address $currentAddress;
    public $toast_id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($addresses, $currentAddress = null, $toast_id = 'my-account-updated-toast')
    {
        $this->addresses = $addresses;
        $this->currentAddress = !empty($currentAddress) ? $currentAddress : $addresses->first();
        $this->toast_id = $toast_id;
    }

    protected function rules()
    {
        return [
            'addresses.*' => [],
            'currentAddress.*' => [],
            'currentAddress.address' => ['required'],
            'currentAddress.country' => ['required'],
            'currentAddress.city' => ['required'],
            'currentAddress.state' => ['required'],
            'currentAddress.zip_code' => ['required'],
            'currentAddress.phones' => ['required'],
            'currentAddress.set_default' => ['required'],
        ];
    }

    public function updatingCurrentAddress(&$address, $key) {
        if(!$address instanceof Address) {
            $address = new Address($address); // alpinejs passes arrays as data instead of Model type. This is the reason why we have to convert it to Address model.
        }
    }

    public function changeCurrentAddress($key) {
        $this->currentAddress = $this->addresses->get($key);
        $this->dispatchBrowserEvent('display-address-modal');
    }

    protected function messages()
    {
        return [

        ];
    }

    public function render()
    {
        return view('livewire.dashboard.forms.addresses.addresses-form');
    }

    public function saveAddress() {
        $this->validate();

        $address = Address::find($this->currentAddress->id)->fill($this->currentAddress->toArray());
        $address->save();

        if($address->set_default) {
            Address::where('id', '!=', $address->id)->update(['set_default' => 0]);
        }

        $this->addresses = auth()->user()->addresses()->get(); // re-init addresses

        $this->dispatchBrowserEvent('display-address-modal');
        $this->dispatchBrowserEvent('toastit', ['id' => $this->toast_id, 'content' => "Address successfully updated!"]);
    }
}
