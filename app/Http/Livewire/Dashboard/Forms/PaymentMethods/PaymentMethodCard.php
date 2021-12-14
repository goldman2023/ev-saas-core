<?php

namespace App\Http\Livewire\Dashboard\Forms\PaymentMethods;

use App\Models\PaymentMethod;
use App\Models\PaymentMethodUniversal;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\SerialNumber;
use App\Rules\UniqueSKU;
use DB;
use EVS;
use Categories;
use Illuminate\Validation\Rule;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use App\Traits\Livewire\RulesSets;

class PaymentMethodCard extends Component
{
    use RulesSets;

    public $paymentMethod;
    public $class;
    protected $type;

    protected function rules()
    {
        $rules = [
            'paymentMethod.id' => [],
            'paymentMethod.enabled' => ['boolean'],
            'paymentMethod.gateway' => [Rule::in(PaymentMethodUniversal::$available_gateways)],
            'paymentMethod.name' => ['required'],
            'paymentMethod.description' => ['required'],
            'paymentMethod.instructions' => ['required'],
        ];

        return array_merge($rules, $this->paymentMethod->getPaymentMethodValidationRules('paymentMethod'));
    }

    protected function messages()
    {
        $rules = [
            'paymentMethod.enabled.boolean' => translate('Payment methods can be either enabled or disabled'),
            'paymentMethod.gateway.in' => translate('Only available gateways for now are: '.implode(',', PaymentMethodUniversal::$available_gateways)),
        ];

        return array_merge($rules, $this->paymentMethod->getPaymentMethodValidationMessages('paymentMethod'));
    }

    /**
     * Create a new component instance.
     *
     * @param mixed|null $paymentMethod
     * @param string $class
     * @return void
     */
    public function mount(mixed &$paymentMethod = null, $class = '')
    {
        $this->paymentMethod = $paymentMethod;
        $this->type = ($paymentMethod instanceof PaymentMethod) ? 'custom':'universal';
        $this->class = $class;
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initPaymentMethodForm');
    }

//    public function updatingPaymentMethodEnabled($value) {
//        $this->validate();
//    }

    public function updatedPaymentMethodEnabled($value) {
        $this->paymentMethod->save();

        $msg = $value ? $this->paymentMethod->name.' '.translate('method enabled!') : $this->paymentMethod->name.' '.translate('method disabled!');
        $this->dispatchBrowserEvent('toast', ['id' => 'payment-method-updated-toast', 'content' => $msg, 'type' => $value ? 'success' : 'danger' ]);
    }

    public function save() {
        $this->validate();

        $this->paymentMethod->save();

        $this->dispatchBrowserEvent('toast', ['id' => 'payment-method-updated-toast', 'content' => $this->paymentMethod->name.' '.translate(' method updated successfully!'), 'type' => 'success' ]);
    }

    public function render()
    {
        return view('livewire.dashboard.forms.payment-methods.payment-method-card');
    }
}
