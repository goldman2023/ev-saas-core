<?php

namespace App\Http\Livewire\Dashboard\Forms\Orders;

use App\Models\Order;
use Livewire\Component;
use App\Models\OrderItem;
use App\Enums\OrderTypeEnum;
use Illuminate\Validation\Rule;
use App\Enums\PaymentStatusEnum;
use App\Enums\ShippingStatusEnum;
use App\Traits\Livewire\RulesSets;
use Illuminate\Support\Facades\DB;
use App\Traits\Livewire\DispatchSupport;

class OrderForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $order;
    public $order_items = [];
    public $is_update;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($order = null)
    {
        $this->order = empty($order) ? new Order() : $page;

        $this->is_update = !empty($this->order->id) ? true : false;

        if(!empty($this->order->order_items)) {
            foreach($this->order->order_items as $item) {
                // $this->order_items
            }
        }
    }

    protected function rules()
    {
        $rules =  [
            'order.shop_id' => [ 'required' ], //  Rule::in(PageTypeEnum::implodedValues())
            'order.user_id' => [ 'nullable' ],
            'order.type' => ['required', Rule::in(OrderTypeEnum::toValues())],
            'order.email' => ['required'],
            'order.billing_first_name' => ['required'],
            'order.billing_last_name' => ['required'],
            'order.billing_company' => ['nullable'],
            'order.billing_address' => ['nullable'],
            'order.billing_country' => ['nullable'],
            'order.billing_state' => ['nullable'],
            'order.billing_city' => ['nullable'],
            'order.billing_zip' => ['nullable'],
            'order.phone_numbers' => ['nullable'],
            'order.same_billing_shipping' => ['boolean'],
            'order.shipping_first_name' => ['required'],
            'order.shipping_last_name' => ['required'],
            'order.shipping_company' => ['nullable'],
            'order.shipping_address' => ['nullable'],
            'order.shipping_country' => ['nullable'],
            'order.shipping_state' => ['nullable'],
            'order.shipping_city' => ['nullable'],
            'order.shipping_zip' => ['nullable'],
            'order.shipping_method' => ['nullable'],
            'order.shipping_cost' => ['nullable'], // in calculator
            'order.tax' => ['nullable'], // in calculator
            'order.payment_status' => ['required', Rule::in(PaymentStatusEnum::toValues())],
            'order.shipping_status' => ['required', Rule::in(ShippingStatusEnum::toValues())],
            'order.tracking_number' => ['nullable'],
            'order.note' => ['nullable'],
            'order.terms' => ['nullable'],
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            
        ];
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    public function render()
    {
        return view('livewire.dashboard.forms.orders.order-form');
    }

    public function saveOrder() {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

        DB::beginTransaction();

        try {
            $this->invoicing_period = null;
            $this->order->save();

            foreach($this->order_items as $item) {
                $order_item = (new OrderItem())->fill($item);
                $order_item->order_id = $this->order->id;

                if(!empty($item['subject_type'] ?? '')) {
                    $order_item->subject_type = base64_decode($item['subject_type']);
                }

                $order_item->quantity = (float) $item['qty'];
                $order_item->save();
            }

            DB::commit();

            $this->inform(translate('Order successfully saved!'), '', 'success');

            if (!$this->is_update) {
                return redirect()->route('order.edit', $this->order->id);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            if ($this->is_update) {
                $this->dispatchGeneralError(translate('There was an error while updating an order...Please try again.'));
                $this->inform(translate('There was an error while updating an order...Please try again.'), '', 'fail');
            } else {
                $this->dispatchGeneralError(translate('There was an error while creating an order...Please try again.'));
                $this->inform(translate('There was an error while creating an order...Please try again.'), '', 'fail');
            }
        }
    }
}