<?php

namespace App\Http\Livewire\Dashboard\Forms\Addresses;


use App\Facades\MyShop;
use App\Models\Address;
use App\Models\ShopAddress;
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
    public ShopAddress|Address|null $currentAddress;
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
            'currentAddress.phones' => ['check_array:1,4'],
            'currentAddress.is_primary' => ['required'],
            'currentAddress.is_billing' => ['required'],
            'currentAddress.location' => [],
            'currentAddress.features' => [],
        ];
    }

    public function updatingCurrentAddress(&$address, $key) {
        if(!$address instanceof Address && !$address instanceof ShopAddress) {
            // alpinejs passes arrays as data instead of Model type. This is the reason why we have to convert it to ShopAddress|Address model.
            if(isset($address['features'], $address['location'])) {
                $address = new ShopAddress($address); // only ShopAddress has features and location
            } else {
                $address = new Address($address);
            }
        }
    }

    public function changeCurrentAddress($key) {
        $this->currentAddress = $this->addresses->get($key);
        $this->dispatchBrowserEvent('display-address-modal');
    }

    protected function messages()
    {
        return [
            'currentAddress.address.required' => translate('Address is required'),
            'currentAddress.country.required' => translate('Country is required'),
            'currentAddress.city.required' => translate('City is required'),
            'currentAddress.state.required' => translate('State is required'),
            'currentAddress.zip_code.required' => translate('Zip Code is required'),
            'currentAddress.phones.check_array' => translate('Must have at least one phone number with min 4 numbers'),
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.forms.addresses.addresses-form');
    }

    public function saveAddress() {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchBrowserEvent('validation-errors', ['errors' => $e->validator->messages()->toArray()]);
            $this->validate();
        }

        $address = app($this->currentAddress::class)->find($this->currentAddress->id)->fill($this->currentAddress->toArray());

        $address->save();


        if($address->is_primary) {
            app($this->currentAddress::class)::where('id', '!=', $address->id)->update(['is_primary' => 0]);
        }

        if($this->currentAddress instanceof ShopAddress) {
            $this->addresses = MyShop::getShop()->addresses()->get(); // re-init shop addresses
        } else if($this->currentAddress instanceof Address) {
            $this->addresses = auth()->user()->addresses()->get(); // re-init user addresses
        }


        $this->dispatchBrowserEvent('display-address-modal');
        $this->toastify('Address successfully updated!', 'success');
    }

    protected function toastify($msg = '', $type = 'info') {
        $this->dispatchBrowserEvent('toastit', ['id' => $this->toast_id, 'content' => $msg, 'type' => $type ]);
    }
}
