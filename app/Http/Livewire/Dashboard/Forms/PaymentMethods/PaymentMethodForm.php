<?php

namespace App\Http\Livewire\Dashboard\Forms\PaymentMethods;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\SerialNumber;
use App\Rules\UniqueSKU;
use App\Traits\Livewire\RulesSets;
use Categories;
use DB;
use EVS;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;

class PaymentMethodForm extends Component
{
    use RulesSets;

    public $payment_method;

    public $type;

    public $class;

    protected function rules()
    {
        return [
            'payment_method.*' => [],
        ];
    }

    protected function messages()
    {
        // TODO: Implement messages() method.
    }

    /**
     * Create a new component instance.
     *
     * @param mixed|null $payment_method Passed paymentMethod or PaymentMethod Universal model as a reference
     * @return void
     */
    public function mount(mixed &$payment_method = null, $type = 'custom', $class = '')
    {
        $this->payment_method = $payment_method;
        $this->type = $type;
        $this->class = $class;
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initPaymentMethodForm');
    }

    public function render()
    {
        return view('livewire.dashboard.forms.payment-methods.payment-method-form');
    }
}
