<?php

namespace App\Http\Livewire\Dashboard\Forms\SerialNumbers;

use App\Facades\MyShop;
use App\Models\SerialNumber;
use App\Traits\Livewire\DispatchSupport;
use App\Enums\SerialNumberStatusEnum;
use DB;
use EVS;
use Categories;
use Livewire\Component;
use App\Traits\Livewire\RulesSets;
use Illuminate\Validation\Rule;

class SerialNumberFormModal extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $serialNumber;
    public $show;
    public $product;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($product)
    {
        $this->product = $product;
    }

    protected function rules()
    {
        return [
            // 'serialNumber.id' => [],
            'serialNumber.subject_id' => [],
            'serialNumber.subject_type' => [],
            'serialNumber.serial_number' => ['required'],
            'serialNumber.status' => [Rule::in(SerialNumberStatusEnum::toValues())],
        ];
    }


    protected function messages()
    {
        return [
            'serialNumber.status.in' => translate('Status must be one of the following: '.SerialNumberStatusEnum::implodedLabels()),
        ];
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    public function render()
    {
        return view('livewire.dashboard.forms.serial-numbers.serial-number-form-modal');
    }

    public function loadSerialNumber($id) {

        if(empty($id)) {
            $this->serialNumber = new SerialNumber();
            $this->serialNumber->subject_id = $this->product->id;
            $this->serialNumber->subject_type = $this->product::class;
        } else {
            $this->serialNumber = SerialNumber::find($id);
        }
        
    }

    public function saveSerialNumber() {
        $is_update = isset($this->serialNumber->id) && !empty($this->serialNumber->id);

        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // $this->dispatchValidationErrors($e);
            $this->validate();
        }

        DB::beginTransaction();

        try {
            $this->serialNumber->save();

            DB::commit();

            if($is_update) {
                $this->inform('Serial number successfully updated!', '', 'success');
            } else {
                $this->inform('Serial number successfully created!', '', 'success');
            }

            $this->emit('refreshDatatable');
            $this->emit('refreshForm');
        } catch(\Exception $e) {
            DB::rollBack();

            if($is_update) {
                $this->dispatchGeneralError(translate('There was an error while updating a serial number...Please try again.'));
                $this->inform('There was an error while updating a serial number...Please try again.', '', 'fail');
            } else {
                $this->dispatchGeneralError(translate('There was an error while creating a serial number...Please try again.'));
                $this->inform('There was an error while creating a serial number...Please try again.', '', 'fail');
            }

        }
    }

    public function archiveSerialNumber() {
//        $address = app($this->currentAddress::class)->find($this->currentAddress->id)->fill($this->currentAddress->toArray());
//        $address->remove();
    }
}
