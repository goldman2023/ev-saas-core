<?php

namespace App\Http\Livewire\Dashboard\Forms\Categories;

use App\Facades\MyShop;
use App\Models\Address;
use App\Models\Category;
use App\Models\ShopAddress;
use App\Traits\Livewire\DispatchSupport;
use DB;
use EVS;
use Categories;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use App\Traits\Livewire\RulesSets;

class CategoryForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $category;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($category = null)
    {
        $this->category = empty($category) ? new Category() : $category;
    }

    protected function rules()
    {
        return [
            'category.*' => [],
            'category.name' => 'required|'
        ];
    }


    protected function messages()
    {
        return [];
    }

    public function render()
    {
        return view('livewire.dashboard.forms.categories.category-form');
    }

    public function saveCategory() {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

//        DB::beginTransaction();
//
//        try {
//            // Update address
//            $address = app($this->currentAddress::class)->find($this->currentAddress->id)->fill($this->currentAddress->toArray());
//            $address->save();
//
//            // if address IS PRIMARY, set other addresses to non-primary
//            if($address->is_primary) {
//                app($this->currentAddress::class)::where('id', '!=', $address->id)->update(['is_primary' => 0]);
//            }
//
//            DB::commit();
//
//            if($this->currentAddress instanceof ShopAddress) {
//                $this->addresses = MyShop::getShop()->addresses()->get(); // re-init shop addresses
//            } else if($this->currentAddress instanceof Address) {
//                $this->addresses = auth()->user()->addresses()->get(); // re-init user addresses
//            }
//
//            $this->dispatchBrowserEvent('display-address-modal');
//            $this->toastify('Address successfully updated!', 'success');
//        } catch(\Exception $e) {
//            DB::rollBack();
//            $this->dispatchGeneralError(translate('There was an error while updating the shop address...Try again.'));
//        }
    }

    public function removeCategory() {
//        $address = app($this->currentAddress::class)->find($this->currentAddress->id)->fill($this->currentAddress->toArray());
//        $address->remove();
    }
}
