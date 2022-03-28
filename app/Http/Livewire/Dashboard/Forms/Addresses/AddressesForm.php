<?php

namespace App\Http\Livewire\Dashboard\Forms\Addresses;


use App\Facades\MyShop;
use App\Models\Address;
use App\Models\ShopAddress;
use App\Traits\Livewire\DispatchSupport;
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
    use DispatchSupport;

    public $addresses;
    public $type; // can be: 'address', 'shop_address'
    public ShopAddress|Address|null $currentAddress;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($addresses, $type = 'address')
    {
        $this->addresses = $addresses;
        $this->type = $type;

        $this->initNewAddress();
    }

    public function initNewAddress() {
        if($this->type === 'address') {
            $this->currentAddress = new Address();
            $this->currentAddress->user_id = auth()->user()->id;
        } else if($this->type === 'shop_address') {
            $this->currentAddress = new ShopAddress();
            $this->currentAddress->shop_id = MyShop::getShopID();
        }     
    }

    protected function rules()
    {
        if($this->currentAddress instanceof ShopAddress) {
            return [
                'addresses.*' => [],
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
        } else if($this->currentAddress instanceof Address) {
            return [
                'addresses.*' => [],
                'currentAddress.address' => ['required'],
                'currentAddress.country' => ['required'],
                'currentAddress.city' => ['required'],
                'currentAddress.state' => ['required'],
                'currentAddress.zip_code' => ['required'],
                'currentAddress.phones' => ['check_array:1,4'],
                'currentAddress.is_primary' => ['required'],
                'currentAddress.is_billing' => ['required'],
            ];
        }
    }

    // public function updatingCurrentAddress(&$address, $key) {
    //     if(!$address instanceof Address && !$address instanceof ShopAddress) {
    //         // alpinejs passes arrays as data instead of Model type. This is the reason why we have to convert it to ShopAddress|Address model.
    //         if(isset($address['features'], $address['location'])) {
    //             $address = new ShopAddress($address); // only ShopAddress has features and location
    //         } else {
    //             $address = new Address($address);
    //         }
    //     }
    // }

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
            // $this->dispatchValidationErrors($e);
            $this->validate();
        }

        DB::beginTransaction();

        try {
            // Update address
            if($this->type === 'address') {
                $this->currentAddress->user_id = auth()->user()->id;
            } else if($this->type === 'shop_address') {
                $this->currentAddress->shop_id = MyShop::getShopID();
            }     
            $this->currentAddress->save();

            // if address IS PRIMARY, set other user addresses to non-primary
            if($this->currentAddress->is_primary) {
                app($this->currentAddress::class)::where([
                    ['id', '!=', $this->currentAddress->id],
                    ['user_id', '=', auth()->user()->id]
                ])->update(['is_primary' => 0]);
            }

            DB::commit();

            if($this->currentAddress instanceof ShopAddress) {
                $this->addresses = MyShop::getShop()->addresses()->get(); // re-init shop addresses
            } else if($this->currentAddress instanceof Address) {
                $this->addresses = auth()->user()->addresses()->get(); // re-init user addresses
            }

            $this->dispatchBrowserEvent('toggle-flyout-panel', ['id' => 'address-panel']);
            $this->inform(translate('Address successfully saved!'), '', 'success');

            $this->initNewAddress(); // restart current address
        } catch(\Exception $e) {
            DB::rollBack();
            $this->inform(translate('Address could not be saved'), $e->getMessage(), 'fail');
        }
    }

    public function removeAddress() {
        $address = app($this->currentAddress::class)->find($this->currentAddress->id)->fill($this->currentAddress->toArray());
        $address->remove();
    }


}
