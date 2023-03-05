<?php

namespace App\Http\Livewire\Dashboard\Forms\Orders;

use Log;
use Uuid;
use Payments;
use TaxService;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Invoice;
use App\Models\Product;
use Livewire\Component;
use App\Models\OrderItem;
use App\Enums\UserTypeEnum;
use App\Enums\OrderTypeEnum;
use Illuminate\Validation\Rule;
use App\Enums\PaymentStatusEnum;
use App\Enums\ShippingStatusEnum;
use App\Traits\Livewire\RulesSets;
use Illuminate\Support\Facades\DB;
use App\Traits\Livewire\HasCoreMeta;
use App\Traits\Livewire\HasAttributes;
use App\Traits\Livewire\DispatchSupport;
use App\Http\Services\TenantSettingsService;

class OrderForm extends Component
{
    use RulesSets;
    use DispatchSupport;
    use HasCoreMeta;
    use HasAttributes;

    public $order;
    public $order_items = [];
    public $is_update;
    public $hideShipping;

    protected $listeners = ['refreshComponent' => '$refresh'];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($order = null, $hideShipping = false, $customer = null)
    {
        $this->order = empty($order) ? (new Order())->load(['uploads']) : $order;

        if(empty($this->order->id)) {
            $this->order->shop_id = 1; // Shop ID by default is 1 - app shop itself
        }

        /* Enable Core Meta */
        $this->initCoreMeta($this->order);

        if($customer) {
            $this->order->user = $customer;
        }

        $this->is_update = !empty($this->order->id) ? true : false;
        $this->hideShipping = $hideShipping;

        $fake_product = new Product();
        $this->refreshAttributes($fake_product);

        if(!empty($this->order->order_items)) {
            foreach($this->order->order_items as $item) {
                $custom_attributes = [];
                $selected_predefined_attribute_values = [];
                self::initAttributes($item, $custom_attributes, $selected_predefined_attribute_values, \App\Models\Product::class);
                
                if(!empty($item->subject_type)) {
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
                        'custom_attributes' => $custom_attributes,
                        'selected_predefined_attribute_values' => $selected_predefined_attribute_values,
                        'addons' => []
                    ];

                    // Product Addons
                    if($item->descendants?->isNotEmpty() ?? null) {
                        foreach($item->descendants as $addon) {
                            $custom_attributes = [];
                            $selected_predefined_attribute_values = [];
                            self::initAttributes($addon, $custom_attributes, $selected_predefined_attribute_values, \App\Models\ProductAddon::class);

                            $this->order_items[count($this->order_items) - 1]['addons'][] = [
                                'id' => $addon->id,
                                'subject_type' => base64_encode($addon->subject_type ?? ''),
                                'subject_id' => $addon->subject_id ?? null,
                                'name' => $addon->name,
                                'excerpt' => $addon->excerpt,
                                'qty' => $addon->quantity,
                                'unit_price' => $addon->base_price,
                                'base_price' => $addon->base_price,
                                'subtotal_price' => $addon->subtotal_price,
                                'total_price' => $addon->total_price,
                                'tax' => $addon->tax,
                                'thumbnail' => !empty($addon->subject) ? ($addon->subject?->thumbnail->file_name ?? null) : '',
                                'custom_attributes' => $custom_attributes,
                                'selected_predefined_attribute_values' => $selected_predefined_attribute_values,
                            ];
                        }
                    }
                } else {
                    $this->order_items[] = [
                        'id' => $item->id,
                        'subject_type' => null,
                        'subject_id' => null,
                        'name' => $item->name,
                        'excerpt' => $item->excerpt,
                        'qty' => $item->quantity,
                        'unit_price' => $item->base_price,
                        'base_price' => $item->base_price,
                        'subtotal_price' => $item->subtotal_price,
                        'total_price' => $item->total_price,
                        'tax' => 0,
                        'thumbnail' => '',
                        'custom_attributes' => $custom_attributes,
                        'selected_predefined_attribute_values' => $selected_predefined_attribute_values,
                    ];
                }
            }
        }
    }

    protected function rules()
    {
        $rules =  apply_filters('livewire-order-form-rules', [
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
            
            'order_items' => ['nullable'],
        ]);

        return $rules;
    }

    protected function messages()
    {
        return [
            'order.shop_id.required' => translate('Vendor must be selected'),
            'order.email.required' => translate('Customer must be selected'),
            'order.billing_first_name.required' => translate('Billing First Name is required'),
            'order.billing_last_name.required' => translate('Billing First Name is required'),
            'order.payment_status.required' => translate('Payment status is required'),
            'order.shipping_status.required' => translate('Shipping status is required'),
        ];
    }

    public function getWEFRules() {
        return apply_filters('dashboard.order-form.rules.wef', [
            'wef.deposit_amount' => ['nullable'],
            'wef.billing_entity' => ['in:individual,company'],
            'wef.billing_company_vat' => ['nullable'],
            'wef.billing_company_code' => ['nullable'],
        ]);
    }

    public function getWEFMessages() {
        return [];
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

            $this->order->tax_incl = TaxService::isTaxIncluded();
            $this->order->phone_numbers = [];
            $this->order->is_temp = false;
            $this->order->save();

            /* Save all meta attributes */
            $this->saveAllCoreMeta($this->order);

            // Remove missing previous order_items (if any)
            $current_order_items_idx_from_db = collect($this->order_items)->pluck('id')?->filter()->values() ?? [];
            $previous_order_items_idx_from_db = $this->order->order_items?->pluck('id')?->filter()->values() ?? [];

            $order_items_idx_for_removal = $previous_order_items_idx_from_db->diff($current_order_items_idx_from_db)->values();
            
            // Remove missing/deleted order items
            if($order_items_idx_for_removal->isNotEmpty()) {
                OrderItem::destroy($order_items_idx_for_removal->all());
            }

            // Remove missing/deleted addon order items
            if(collect($this->order_items)->isNotEmpty()) {
                foreach($this->order_items as $order_item) {
                    $current_order_item_addons_idx_from_db = collect($order_item['addons'])->pluck('id')?->filter()?->values() ?? [];
                    $previous_order_item_addons_idx_from_db = $this->order->order_items->firstWhere('id', $order_item['id']) ?? [];

                    if(!empty($previous_order_item_addons_idx_from_db)) {
                        $previous_order_item_addons_idx_from_db = $previous_order_item_addons_idx_from_db->descendants->pluck('id')?->filter()?->values() ?? [];
                        
                        $order_item_addons_idx_for_removal = $previous_order_item_addons_idx_from_db->diff($current_order_item_addons_idx_from_db)->values();

                        if($order_item_addons_idx_for_removal->isNotEmpty()) {
                            OrderItem::destroy($order_item_addons_idx_for_removal->all());
                        }
                    }
                }
            }

            $save_order_item_method = function($item, $parent_id = null) {
                if(!empty($item['id'])) {
                    $order_item = OrderItem::find($item['id'])->fill($item);
                } else {
                    $order_item = (new OrderItem())->fill($item);
                }

                if(!empty($parent_id)) {
                    $order_item->parent_id = $parent_id;
                }
                
                $order_item->order_id = $this->order->id;

                if(!empty($item['subject_type'] ?? null)) {
                    $order_item->subject_type = base64_decode($item['subject_type']);
                } else {
                    $order_item->subject_id = null;
                    $order_item->subject_type = null;
                }

                $order_item->quantity = (float) $item['qty'];
                
                $order_item->save();

                $this->setAttributes($order_item, $item['custom_attributes'], $item['selected_predefined_attribute_values']); // set attributes to OrderItem
            };
            
            foreach($this->order_items as $index => $item) {
                $save_order_item_method($item);

                // Save addons OrderItems
                if(!empty($item['addons'])) {
                    foreach($item['addons'] as $addon_index => $addon_item) {
                        $save_order_item_method($addon_item, parent_id: $item['id']);
                    }
                }
            }

            $this->order->load('order_items'); // load order items

            if (!$this->is_update) {
                do_action('order.insert', $this->order);
            }

            // If customer is not selected, create ghost user or select user based on given email
            if(empty($this->order->user_id)) {
                $user = User::where('email', $this->order->email)->first();

                if(!empty($user)) {
                    // Link fetched user by given email to this $order
                    $this->order->user()->associate($user);
                } else {
                    // There's no user with provided email, create ghost user
                    $ghost_user = User::create(
                        [
                            'email' => $this->order->email,
                            'is_temp' => true,
                            'user_type' => UserTypeEnum::customer()->value,
                            'entity' => $this->wef['billing_entity'],
                            'name' => $this->order->billing_first_name,
                            'surname' => $this->order->billing_last_name,
                            'phone' => $this->order->phone_numbers[0] ?? '',
                        ]
                    );

                    $this->order->user()->associate($ghost_user);

                    // Create user billing address
                    $billing_address = Address::create(
                        [
                            'user_id' => $ghost_user->id,
                            'address' => $this->order->billing_address,
                            'country' => $this->order->billing_country,
                            'state' => $this->order->billing_state,
                            'city' => $this->order->billing_city,
                            'zip_code' => $this->order->billing_zip,
                            'phones' => $this->order->phone_numbers ?? [],
                            'is_primary' => 1,
                            'is_billing' => 1,
                        ]
                    );
                }

                $this->order->save();
            }

            DB::commit();

            $this->inform(translate('Order successfully saved!'), '', 'success');
            
            // $this->emitSelf('refreshComponent');

            if (!$this->is_update) {
                return redirect()->route('order.details', $this->order->id);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
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

    public function generateInvoice() {
        // If there is functions called generateInvoice() in theme Helpers php files, it'll use that one instead of default logic defined here!
        if (function_exists('generateInvoice')) {
            return generateInvoice($this);
        }

        if($this->order->invoices->isEmpty()) {
            if($this->order->type === OrderTypeEnum::installments()->value) {
                // For installments create multiple invoices (deposit and main invoice)
                $deposit_amount = $this->order->getWEF('deposit_amount');

                $deposit_totals = [
                    'base_price' => $this->order->base_price * $deposit_amount / 100,
                    'discount_amount' => $this->order->discount_amount * $deposit_amount / 100,
                    'subtotal_price' => $this->order->subtotal_price * $deposit_amount / 100,
                    'total_price' => $this->order->total_price * $deposit_amount / 100,
                    'shipping_cost' => $this->order->shipping_cost * $deposit_amount / 100,
                    'tax' => ($this->order->subtotal_price * $this->order->tax / 100) * $deposit_amount / 100,
                ];

                $main_totals = [
                    'base_price' => $this->order->base_price * (100 - $deposit_amount) / 100,
                    'discount_amount' => $this->order->discount_amount * (100 - $deposit_amount) / 100,
                    'subtotal_price' => $this->order->subtotal_price * (100 - $deposit_amount) / 100,
                    'total_price' => $this->order->total_price * (100 - $deposit_amount) / 100,
                    'shipping_cost' => $this->order->shipping_cost * (100 - $deposit_amount) / 100,
                    'tax' => ($this->order->subtotal_price * $this->order->tax / 100) * (100 - $deposit_amount) / 100,
                ];
            } else {
                $deposit_amount = 0;
                $deposit_totals = [];
                $main_totals = [
                    'base_price' => $this->order->base_price,
                    'discount_amount' => $this->order->discount_amount,
                    'subtotal_price' => $this->order->subtotal_price,
                    'total_price' => $this->order->total_price,
                    'shipping_cost' => $this->order->shipping_cost,
                    'tax' => ($this->order->subtotal_price * $this->order->tax / 100),
                ];
            }

            $all_totals = [
                (string) $deposit_amount => $deposit_totals, 
                (string) (100 - (float) $deposit_amount) => $main_totals
            ];

            // TODO: Try to load TenantSettings somehow, it's not working (not getting the data from `tenant_settings` table)...
            // dispatch(function() use($all_totals) {
                DB::beginTransaction();

                try {
                    $this->saveOrder();

                    foreach($all_totals as $percentage_of_total => $totals) {
                        if(!empty($totals)) {
                            $percentage_of_total = (float) $percentage_of_total;

                            $invoice = new Invoice();

                            $invoice->mode = 'live';
                            $invoice->is_temp = false;
            
                            // Make this changable in modal (when generate invoice is clicked)
                            $invoice->payment_method_type = (Payments::wire_transfer())::class;
                            $invoice->payment_method_id = Payments::wire_transfer()->id;
                
                            $invoice->order_id = $this->order->id;
                            $invoice->shop_id = $this->order->shop_id;
                            $invoice->user_id = $this->order->user_id;
                            $invoice->payment_status = PaymentStatusEnum::unpaid()->value;
                            $invoice->setInvoiceNumber();
                
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
                
                            $invoice->start_date = $this->order->created_at->timestamp;
                            $invoice->end_date = 0;
                
                            $invoice->base_price = $totals['base_price'];
                            $invoice->discount_amount = $totals['discount_amount'];
                            $invoice->subtotal_price = $totals['subtotal_price'];
                            $invoice->total_price = $totals['total_price'];
                            $invoice->shipping_cost = $totals['shipping_cost'];
                            $invoice->tax = $totals['tax'];
                
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
            
                            $invoice->setRealInvoiceNumber();

                            $invoice->setWEF('percentage_of_total_order_price', $percentage_of_total);
            
                            // generateInvoicePDF - generate invoice document and 
                            $filepath = $invoice->generateInvoicePDF(save: true);
            
                            \MediaService::storeAsUploadFromFile($invoice, $filepath, 'invoice_document', file_display_name: translate('Invoice').' '.$invoice->getRealInvoiceNumber());
            
                            // if($this->order->type !== OrderTypeEnum::installments()->value) {
                            //     return redirect()->route('invoice.download', $invoice->id);
                            // }
                        }
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    Log::error($e);
                    DB::rollBack();
                    // dd($e);
                    // $this->dispatchGeneralError(translate('There was an error while generating an invoice(s)...Please try again.'));
                    // $this->inform(translate('There was an error while generating an invoice(s)...Please try again.'), '', 'fail');
                }
            // });

            $this->inform(translate('Invoice successfully generated!'), '', 'success');

            return redirect()->route('order.details', $this->order->id);
        }

        $this->dispatchGeneralError(translate('Invoice(s) for this order is already generated.'));
        $this->inform(translate('Invoice(s) for this order is already generated.'), '', 'fail');
    }
}
