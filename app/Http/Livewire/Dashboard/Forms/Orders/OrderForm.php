<?php

namespace App\Http\Livewire\Dashboard\Forms\Orders;

use App\Models\Order;
use App\Models\Invoice;
use Livewire\Component;
use App\Models\OrderItem;
use App\Enums\OrderTypeEnum;
use Illuminate\Validation\Rule;
use App\Enums\PaymentStatusEnum;
use App\Enums\ShippingStatusEnum;
use App\Traits\Livewire\RulesSets;
use Illuminate\Support\Facades\DB;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\HasCoreMeta;
use Uuid;
use Payments;

class OrderForm extends Component
{
    use RulesSets;
    use DispatchSupport;
    use HasCoreMeta;


    public $order;
    public $order_items = [];
    public $is_update;
    public $hideShipping;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($order = null, $hideShipping = false, $customer = null)
    {
        $this->order = empty($order) ? (new Order())->load(['uploads']) : $order;

        if(empty($this->order->id)) {
            $this->order->shop_id = 1;
        }

        /* Enable Core Meta  */
        $this->initCoreMeta($this->order);

        if($customer) {
            $this->order->user = $customer;
        }

        $this->is_update = !empty($this->order->id) ? true : false;
        $this->hideShipping = $hideShipping;

        if(!empty($this->order->order_items)) {
            foreach($this->order->order_items as $item) {
                $this->order_items[] = [
                    'id' => $item->id,
                    'subject_type' => base64_encode($item->subject_type ?? ''),
                    'subject_id' => $item->subject_id ?? null,
                    'name' => $item->name,
                    'excerpt' => $item->excerpt,
                    'qty' => $item->quantity,
                    'unit_price' => $item->base_price,
                    'base_price' => $item->base_price,
                    'subtotal_price' => $item->subtotal_price,
                    'total_price' => $item->total_price,
                    'tax' => $item->tax,
                    'thumbnail' => !empty($item->subject) ? ($item->subject?->thumbnail->file_name ?? null) : '',
                ];
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
            'order.shipping_first_name' => ['nullable'],
            'order.shipping_last_name' => ['nullable'],
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
            'order.core_meta' => ['nullable'],
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
            $this->setCoreMeta($this->order);

            $this->order->save();
            /* Save all meta attributes */

            // Remove missing previous order_items (if any)
            $current_order_items_idx_from_db = collect($this->order_items)->pluck('id')->filter();
            $previous_order_items_idx_from_db = $this->order->order_items?->pluck('id')?->filter() ?? [];

            $order_items_idx_for_removal = $previous_order_items_idx_from_db->diff($current_order_items_idx_from_db);

            // Remove missing order items
            if($order_items_idx_for_removal->isNotEmpty()) {
                OrderItem::destroy($order_items_idx_for_removal->all());
            }

            foreach($this->order_items as $item) {
                if(!empty($item['id'])) {
                    $order_item = OrderItem::find($item['id'])->fill($item);
                } else {
                    $order_item = (new OrderItem())->fill($item);
                }

                $order_item->order_id = $this->order->id;

                if(!empty($item['subject_type'] ?? '')) {
                    $order_item->subject_type = base64_decode($item['subject_type']);
                } else {
                    $order_item->subject_id = null;
                    $order_item->subject_type = null;
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

            if ($this->is_update) {
                $this->dispatchGeneralError(translate('There was an error while updating an order...Please try again.'));
                $this->inform(translate('There was an error while updating an order...Please try again.'), '', 'fail');
            } else {
                $this->dispatchGeneralError(translate('There was an error while creating an order...Please try again.'));
                $this->inform(translate('There was an error while creating an order...Please try again.'), '', 'fail');
            }
        }
    }

    public function generateOrder() {
        if($this->order->invoices->isEmpty()) {
            $invoice = new Invoice();

            $invoice->mode = 'live';
            $invoice->is_temp = false;
            $invoice->payment_method_type = (Payments::wire_transfer())::class;
            $invoice->payment_method_id = Payments::wire_transfer()->id;


            $invoice->order_id = $this->order->id;
            $invoice->shop_id = $this->order->shop_id;
            $invoice->user_id = $this->order->user_id;
            $invoice->payment_status = $this->order->payment_status;
            $invoice->invoice_number = 'invoice-'.Uuid::generate(4)->string; // Change this to be manua; through modal!
            $invoice->real_invoice_prefix = 'invoice-'; // Change this to be manua; through modal!
            $invoice->real_invoice_number = Uuid::generate(4)->string; // Change this to be manua; through modal!

            $invoice->email = $this->order->email;
            $invoice->billing_first_name = $this->order->billing_first_name;
            $invoice->billing_last_name = $this->order->billing_last_name;
            $invoice->billing_company = $this->order->billing_company;
            $invoice->billing_address = $this->order->billing_address;
            $invoice->billing_country = $this->order->billing_country;
            $invoice->billing_state = $this->order->billing_state;
            $invoice->billing_city = $this->order->billing_city;
            $invoice->billing_zip = $this->order->billing_zip;

            // TODO: add base_currency for invoice! and take it from stripe!

            $invoice->start_date = time();
            $invoice->end_date = 0;

            $invoice->base_price = $this->order->base_price;
            $invoice->discount_amount = $this->order->discount_amount;
            $invoice->subtotal_price = $this->order->subtotal_price;
            $invoice->total_price = $this->order->total_price;
            $invoice->shipping_cost = $this->order->shipping_cost;
            $invoice->tax = $this->order->tax;

            $invoice->note = $this->order->note;

            $user = $this->order->user;
            if($user->entity === 'company') {
                $invoice->billing_company = $user->getUserMeta('company_name');

                $invoice->mergeData([
                    'customer' => [
                        'entity' => $user->entity,
                        'billing_country' => $user->getUserMeta('address_country'),
                        'vat' => $user->getUserMeta('company_vat'),
                        'company_registration_number' => $user->getUserMeta('company_registration_number'),
                        'company_name' => $user->getUserMeta('company_name'),
                    ]
                ]);
            } else {
                $invoice->mergeData([
                    'customer' => [
                        'entity' => $user->entity,
                        'billing_country' => $user->getUserMeta('address_country'),
                    ]
                ]);
            }

            $invoice->save();

            $this->inform(translate('Invoice successfully generated!'), '', 'success');

            return redirect()->route('order.details', $this->order->id);
        }

        $this->dispatchGeneralError(translate('Invoice for this order is already generated.'));
        $this->inform(translate('Invoice for this order is already generated.'), '', 'fail');

    }
}
