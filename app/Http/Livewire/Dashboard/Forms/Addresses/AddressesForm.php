<?php

namespace App\Http\Livewire\Dashboard\Forms\Addresses;

use App\Facades\MyShop;
use App\Models\Address;
use App\Models\ShopAddress;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\RulesSets;
use Categories;
use DB;
use EVS;
use Livewire\Component;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;

class AddressesForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $componentId;

    public $addresses;

    public $type; // can be: 'address', 'shop_address'

    public ShopAddress|Address|null $currentAddress;

    // protected $listeners = ['refreshAddresses' => '$refresh'];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($addresses, $type = 'address', $componentId = '')
    {
        $this->addresses = $addresses;
        $this->type = $type;
        $this->componentId = $componentId;

        $this->initNewAddress();
    }

    public function initNewAddress()
    {
        if ($this->type === 'address') {
            $this->currentAddress = new Address();
            $this->currentAddress->user_id = auth()->user()->id;
        } elseif ($this->type === 'shop_address') {
            $this->currentAddress = new ShopAddress();
            $this->currentAddress->shop_id = MyShop::getShopID();
        }

        $this->currentAddress->is_primary = false;
        $this->currentAddress->is_billing = false;
    }

    protected function rules()
    {
        if ($this->currentAddress instanceof ShopAddress) {
            return [
                'addresses.*' => [],
                'currentAddress.address' => ['required'],
                'currentAddress.country' => ['required'],
                'currentAddress.city' => ['required'],
                'currentAddress.state' => ['nullable'],
                'currentAddress.zip_code' => ['required'],
                'currentAddress.phones' => [''],
                'currentAddress.is_primary' => [],
                'currentAddress.is_billing' => [],
                'currentAddress.location' => [],
                'currentAddress.features' => [],
            ];
        } elseif ($this->currentAddress instanceof Address) {
            return [
                'addresses.*' => [],
                'currentAddress.address' => ['required'],
                'currentAddress.country' => ['required'],
                'currentAddress.city' => ['required'],
                'currentAddress.state' => ['nullable'],
                'currentAddress.zip_code' => ['required'],
                'currentAddress.phones' => ['check_array:1,4'],
                'currentAddress.is_primary' => [],
                'currentAddress.is_billing' => [],
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

    public function changeCurrentAddress($key)
    {
        $this->currentAddress = $this->addresses->get($key);
        $this->dispatchBrowserEvent('display-address-panel');
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

    public function saveAddress()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // $this->dispatchValidationErrors($e);
            $this->validate();
        }

        DB::beginTransaction();

        try {
            // Update address
            if ($this->type === 'address') {
                $this->currentAddress->user_id = auth()->user()->id;
            } elseif ($this->type === 'shop_address') {
                $this->currentAddress->shop_id = MyShop::getShopID();
            }
            $this->currentAddress->save();

            // if address IS PRIMARY, set other user addresses to non-primary
            if ($this->currentAddress->is_primary) {
                if ($this->type === 'address') {
                    app($this->currentAddress::class)::where([
                        ['id', '!=', $this->currentAddress->id],
                        ['user_id', '=', auth()->user()->id],
                    ])->update(['is_primary' => 0]);
                } elseif ($this->type === 'shop_address') {
                    app($this->currentAddress::class)::where([
                        ['id', '!=', $this->currentAddress->id],
                        ['shop_id', '=', MyShop::getShopID()],
                    ])->update(['is_primary' => 0]);
                }
            }

            // if address IS BILLING, set other user addresses to non-billing
            if ($this->currentAddress->is_billing) {
                if ($this->type === 'address') {
                    app($this->currentAddress::class)::where([
                        ['id', '!=', $this->currentAddress->id],
                        ['user_id', '=', auth()->user()->id],
                    ])->update(['is_billing' => 0]);
                } elseif ($this->type === 'shop_address') {
                    app($this->currentAddress::class)::where([
                        ['id', '!=', $this->currentAddress->id],
                        ['shop_id', '=', MyShop::getShopID()],
                    ])->update(['is_billing' => 0]);
                }
            }

            DB::commit();

            $this->refreshAddresses();

            $this->dispatchBrowserEvent('toggle-flyout-panel', ['id' => 'address-panel', 'timeout' => '500']);
            $this->inform(translate('Address successfully saved!'), '', 'success');

            // $this->initNewAddress(); // restart current address
        } catch (\Exception $e) {
            DB::rollBack();
            $this->inform(translate('Address could not be saved'), $e->getMessage(), 'fail');
        }
    }

    public function removeAddress($address_id)
    {
        try {
            if ($this->type === 'address') {
                Address::find($address_id)->delete();
            } elseif ($this->type === 'shop_address') {
                ShopAddress::find($address_id)->delete();
            }

            $this->refreshAddresses();
            $this->inform(translate('Address successfully removed!'), '', 'success');
        } catch (\Exception $e) {
            $this->inform(translate('Address could not be removed'), $e->getMessage(), 'fail');
        }
    }

    protected function refreshAddresses()
    {
        if ($this->type === 'shop_address') {
            $this->addresses = MyShop::getShop()->addresses()->get(); // re-init shop addresses
        } elseif ($this->type === 'address') {
            $this->addresses = auth()->user()->addresses()->get(); // re-init user addresses
        }
    }
}
