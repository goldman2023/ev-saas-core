<div class="w-full" x-data="{
    type: @js($order->type ?? \App\Enums\OrderTypeEnum::standard()->value),
    tax_incl: @js($order->tax_incl),
    payment_status: @js($order->payment_status ?? \App\Enums\PaymentStatusEnum::unpaid()->value),
    shipping_status: @js($order->shipping_status ?? \App\Enums\ShippingStatusEnum::not_sent()->value),
    shop_id: @js($order->shop_id),
    user_id: @js($order->user_id),
    billing_country: @js($order->billing_country),
    shipping_country: @js($order->shipping_country),
    same_billing_shipping: @js($order->same_billing_shipping === true ? true : false),
    tax: @js($order->tax ?? (get_tenant_setting('company_tax_rate') ?? 0)),
    shipping_cost: @js($hideShipping ? 0 : ($order->shipping_cost ?? 0)),
    email: @js($order->email),
    core_meta: @js($core_meta),
    wef: @js($wef),

    billing_first_name: @js($order->billing_first_name),
    billing_last_name: @js($order->billing_last_name),
    billing_company: @js($order->billing_company),
    billing_address: @js($order->billing_address),
    billing_state: @js($order->billing_state),
    billing_city: @js($order->billing_city),
    billing_zip: @js($order->billing_zip),

    shipping_first_name: @js($order->shipping_first_name),
    shipping_last_name: @js($order->shipping_last_name),
    shipping_company: @js($order->shipping_company),
    shipping_address: @js($order->shipping_address),
    shipping_state: @js($order->shipping_state),
    shipping_city: @js($order->shipping_city),
    shipping_zip: @js($order->shipping_zip),

    subtotal: 0,
    total: 0,
    global_installments_deposit_amount: @js(empty(get_tenant_setting('installments_deposit_amount')) ? 0 : get_tenant_setting('installments_deposit_amount')),

    get taxAmount() {
        let subtotal = this.subtotal + this.shipping_cost;

        if(this.tax_incl) {
            return FX.formatPrice((subtotal * 100 / (100 + this.tax)) * this.tax / 100);
        } else {
            return FX.formatPrice(subtotal * this.tax / 100);
        }
    },
    save() {
        $wire.set('order.type', this.type, true);
        $wire.set('order.payment_status', this.payment_status, true);
        $wire.set('order.shipping_status', this.shipping_status, true);
        $wire.set('order.shop_id', this.shop_id, true);
        $wire.set('order.user_id', this.user_id, true);
        $wire.set('order.email', this.email, true);
        $wire.set('order.billing_country', this.billing_country, true);
        $wire.set('order.shipping_country', this.shipping_country, true);
        $wire.set('order.same_billing_shipping', this.same_billing_shipping, true);
        $wire.set('order.shipping_cost', this.shipping_cost, true);
        $wire.set('order.tax', this.tax, true);
        $wire.set('core_meta', this.core_meta, true);
        $wire.set('wef', this.wef, true);

        $wire.set('order.billing_first_name', this.billing_first_name, true);
        $wire.set('order.billing_last_name', this.billing_last_name, true);
        $wire.set('order.billing_company', this.billing_company || '', true);
        $wire.set('order.billing_address', this.billing_address || '', true);
        $wire.set('order.billing_state', this.billing_state || '', true);
        $wire.set('order.billing_city', this.billing_city || '', true);
        $wire.set('order.billing_zip', this.billing_zip || '', true);

        if(this.same_billing_shipping) {
            $wire.set('order.shipping_first_name', this.shipping_first_name, true);
            $wire.set('order.shipping_last_name', this.shipping_last_name, true);
            $wire.set('order.shipping_company', this.user_meta?.shipping_company || '', true);
            $wire.set('order.shipping_address', this.shipping_address || '', true);
            $wire.set('order.shipping_state', this.shipping_state || '', true);
            $wire.set('order.shipping_city', this.shipping_city || '', true);
            $wire.set('order.shipping_zip', this.shipping_zip || '', true);
        }

        @do_action('view.order-form.wire_set');
    },
    setDefaults() {
        if(this.wef.billing_entity !== 'individual' && this.wef.billing_entity !== 'company') {
            this.wef.billing_entity = 'individual';
        }

        if(this.type === 'installments' && _.get(this.wef, 'deposit_amount', null) === null) {
            this.wef.deposit_amount = this.global_installments_deposit_amount
        }
    }
}"
@validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
@init-form.window=""
x-init="
    $watch('type', type => {
        if(type === 'installments' && _.get(wef, 'deposit_amount', null) === null) {
            wef.deposit_amount = global_installments_deposit_amount
        }
    });
    setDefaults();
"
x-cloak>
    <div wire:ignore.self class="w-full relative" x-data="{
        order_items: @entangle('order_items').defer,
        get orderItemsCount() {
            return _.get(this.order_items, 'length', 0);
        },
        calculateTotals() {
            tax = Number(tax);
    
            if(this.order_items) {
                subtotal = 0;
    
                this.order_items.forEach((item, index) => {
                    subtotal += item.total_price;
                });
            } else {
                subtotal = 0;
            }
    
            if(tax < 0 || tax > 100) {
                tax = 0;
            }
    
            total = Number(subtotal) + Number(shipping_cost);
    
            if(!tax_incl) {
                total += total * tax / 100;
            }
        },
        saveOrderItems() {
            $wire.set('order_items', this.order_items, true);
        }
    }" x-init="
        $watch('order_items', order_items => {
            if(order_items) {
                for(index in order_items) {
                    order_items[index].base_price = Number(order_items[index].unit_price);
                    order_items[index].qty = Number(order_items[index].qty);
                    order_items[index].subtotal_price = Number(order_items[index].qty) * order_items[index].unit_price;
                    order_items[index].total_price = Number(order_items[index].qty) * order_items[index].unit_price;
                }
            }
        
            calculateTotals();
        });
        $watch('tax', order_items => calculateTotals());
        $watch('shipping_cost', order_items => calculateTotals());
        calculateTotals();
    ">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                              wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full"
             wire:loading.class="opacity-30 pointer-events-none"
        >

            <div class="grid grid-cols-12 gap-8 mb-10">
                {{-- Left side --}}
                <div class="col-span-12 sm:col-span-8">
                    {{-- Order Information --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mb-7">
                        <div class="w-full pb-4 mb-4 border-b ">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Order information') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Here you can edit all important information about the order') }}</p>
                        </div>

                        <div class="w-full">
                            <div class="grid grid-cols-12 gap-x-7">
                                {{-- Vendor/Shop --}}
                                <x-dashboard.form.blocks.model-selection-form 
                                    field="shop_id"
                                    modal-id="vendor-selection-modal"
                                    :defaultModel="$order->shop"
                                    model-class="{{ \App\Models\Shop::class }}"
                                    api-route="{{ route('api.dashboard.shops.search') }}"
                                    field-title="{{ translate('Vendor') }}"
                                    modal-title="{{ translate('Select Vendor') }}"
                                    empty-selected-item-title="{{ translate('Vendor not selected') }}"
                                    empty-selected-item-subtitle="{{ translate('Please select vendor by clicking this button') }}"
                                    model-title-property="name"
                                    model-subtitle-property="slug"
                                    item-subtitle-prefix="@"
                                ></x-dashboard.form.blocks.model-selection-form>
                                {{-- END Vendor/Shop --}}

                                {{-- Customer --}}
                                <x-dashboard.form.blocks.model-selection-form 
                                    field="user_id"
                                    modal-id="customer-selector-modal"
                                    :defaultModel="$order->user"
                                    model-class="{{ \App\Models\User::class }}"
                                    :model-with-relations="['user_meta', 'addresses']"
                                    api-route="{{ route('api.dashboard.users.search') }}"
                                    field-title="{{ translate('Customer') }}"
                                    modal-title="{{ translate('Select Customer') }}"
                                    empty-selected-item-title="{{ translate('Customer not selected') }}"
                                    empty-selected-item-subtitle="{{ translate('Please select customer by clicking this button') }}"
                                    :model-title-property="['name', 'surname']"
                                    model-subtitle-property="email"
                                    custom-select-logic="
                                        email = item?.email;

                                        {{-- Fill order billing info based on item data --}}
                                        wef.billing_entity = item?.entity;
                                        wef.billing_company_vat = item?.user_meta?.company_vat || '';
                                        wef.billing_company_code = item?.user_meta?.company_registration_number || '';
                                        
                                        let address = item?.addresses.find(address => address.is_billing === true);

                                        if(address === undefined) {
                                            address = item?.addresses[0];
                                        }

                                        billing_first_name = item?.name || '';
                                        billing_last_name = item?.surname || '';
                                        billing_company = item?.user_meta?.company_name || '';
                                        billing_country = address?.country || '';
                                        billing_address = address?.address || '';
                                        billing_state = address?.state || '';
                                        billing_city = address?.city || '';
                                        billing_zip = address?.zip_code || '';

                                        if(same_billing_shipping) {
                                            shipping_first_name = item?.name || '';
                                            shipping_last_name = item?.surname || '';
                                            shipping_company = item?.user_meta?.company_name || '';
                                            shipping_country = address?.country || '';
                                            shipping_address = address?.address || '';
                                            shipping_state = address?.state || '';
                                            shipping_city = address?.city || '';
                                            shipping_zip = address?.zip_code || '';
                                        }

                                        save(); // set other parameters!
                                    "
                                    custom-deselect-logic="
                                        email = null;

                                        billing_country = '';
                                        wef.billing_entity = 'individual';
                                        wef.billing_company_vat = '';
                                        wef.billing_company_code = '';
                                        
                                        $wire.set('order.billing_first_name', '');
                                        $wire.set('order.billing_last_name', '');
                                        $wire.set('order.billing_company', '');

                                        $wire.set('order.billing_address', '');
                                        $wire.set('order.billing_state', '');
                                        $wire.set('order.billing_city', '');
                                        $wire.set('order.billing_zip', '');

                                        save();
                                    "
                                ></x-dashboard.form.blocks.model-selection-form>
                                {{-- END Customer --}}

                                <div class="col-span-12 mt-6">
                                      {{-- Order Items --}}
                    {{-- TODO: Implement ordering of order_items! (draggable sorting) --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow" :key="'order-items-form'" wire:ignore>

                        <div class="w-full pb-4 mb-4 border-b ">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ translate('Order Items') }}
                                <span x-text="'('+orderItemsCount+')'"></span>
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Here you can specify all items included in the order') }}</p>
                        </div>

                        <div class="w-full flex flex-col" >
                            <template x-if="orderItemsCount > 0">
                                <ul class="w-full flex flex-col gap-y-4">
                                    <template x-for="(item, index) in order_items" :key="'order-items-'+index">

                                        <li class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm "
                                            >
                                            <div class="flex-shrink-0" x-show="item?.thumbnail">
                                                <img class="h-10 w-10 rounded-full" :src="window.WE.IMG.url(item?.thumbnail)" alt="">
                                            </div>

                                            <div class="min-w-0 flex-1">
                                                <div class="outline-none">
                                                    <p class="text-sm font-medium text-gray-900" x-text="item.name"></p>
                                                    <p class="truncate text-sm text-gray-500 line-clamp-1" x-text="item.excerpt"></p>
                                                </div>
                                            </div>

                                            <div class="flex-shrink-0 flex items-center gap-x-4">
                                                <span x-text="FX.formatPrice(item.total_price)"></span>
                                                <input type="number" min="0" x-model="item.qty" class="form-standard max-w-[90px]" />
                                            </div>

                                            {{-- <template x-if="_.get(item, 'subject_id', null) === null && _.get(item, 'subject_type', null) === null"> --}}
                                            <button type="button" class="btn btn-primary btn-sm" @click="$dispatch('display-modal', {'id': 'order-item-editor-modal', 'order_item_index': index })" >
                                                {{ translate('Edit') }}
                                            </button>
                                            {{-- </template> --}}

                                            <div class="flex-shrink-0 flex items-center " @click="order_items.splice(index, 1);">
                                                @svg('heroicon-o-x-mark', ['class' => 'w-5 h-5 text-danger cursor-pointer'])
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </template>

                            {{-- Empty state --}}
                            <template x-if="orderItemsCount <= 0">
                                <div class="text-center py-2 cursor-pointer" @click="$dispatch('display-modal', {'id': 'order-item-selector-modal' })">
                                    @svg('heroicon-o-plus-circle', ['class' => 'mx-auto h-12 w-12 text-gray-400'])
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">{{ translate('No order items') }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ translate('Start by adding new item to the order') }}</p>
                                </div>
                            </template>

                            {{-- Add new item --}}
                            <div class="w-full flex pt-4 mt-4 border-t">
                                <button type="button" class="btn btn-primary btn-sm w-full !font-medium !text-lg" @click="$dispatch('display-modal', {'id': 'order-item-selector-modal' })" >
                                    {{ translate('Add new item') }}
                                </button>
                            </div>

                            {{-- OrderItem selector modal --}}
                            {{-- TODO: Repalce with:  --}}
                            <x-system.form-modal id="order-item-selector-modal" title="Add New Order Item" class="!max-w-xl" :prevent-close="true">
                                <div class="w-full flex flex-col" x-data="{
                                        q: '',
                                        results: [],
                                        content_type: null,
                                        available_content_types: [
                                            {
                                                title: '{{ translate('Product') }}',
                                                slug: 'product',
                                                model_class: @js(base64_encode(\App\Models\Product::class)),
                                            },
                                            {
                                                title: '{{ translate('Product Addon') }}',
                                                slug: 'product_addon',
                                                model_class: @js(base64_encode(\App\Models\ProductAddon::class)),
                                            },
                                            {
                                                title: '{{ translate('Custom') }}',
                                                slug: 'custom',
                                                model_class: '',
                                            }
                                        ],
                                        hide_content_selector: false,
                                        order_item_index: null,
                                        custom_order_item: {
                                            id: null,
                                            name: '',
                                            excerpt: '',
                                            qty: 1,
                                            unit_price: 0,
                                            base_price: 0,
                                            subtotal_price: 0,
                                            total_price: 0,
                                            custom_attributes: @js($custom_attributes),
                                            selected_predefined_attribute_values: @js($selected_predefined_attribute_values),
                                        },
                                        getCurrentContentTypeOptions() {
                                            return this.available_content_types.find(item => item.slug === this.content_type);
                                        },
                                        search() {
                                            let fetch_route = null;

                                            if(this.content_type === 'product') {
                                                fetch_route = '{{ route('api.dashboard.products.search') }}';
                                            } else if(this.content_type === 'product_addons') {
                                                fetch_route = '{{ route('api.dashboard.products.addons.search') }}';
                                            }

                                            if(fetch_route) {
                                                wetch.get(fetch_route+'?q='+this.q)
                                                .then(data => {
                                                    if(data.status === 'success' && data.results) {
                                                        this.results = data.results;
                                                    }
                                                })
                                                .catch(error => {
                                                    alert(error);
                                                });
                                            }
                                        },
                                        reset() {
                                            this.q = '';
                                            this.results = null;

                                            this.order_item_index = null;
                                            this.hide_content_selector = false;

                                            this.custom_order_item.id = null;
                                            this.custom_order_item.name = '';
                                            this.custom_order_item.excerpt = '';
                                            this.custom_order_item.qty = 1;
                                            this.custom_order_item.unit_price = 0;
                                            this.custom_order_item.base_price = 0;
                                            this.custom_order_item.subtotal_price = 0;
                                            this.custom_order_item.total_price = 0;

                                            {{-- Send event to reset attributes form --}}
                                            $dispatch('reset-attributes-form', {form_id: 'custom-order-item-form'});
                                        },
                                        select(item) {
                                            let existing_item_index = order_items.findIndex(order_item => {
                                                return order_item.subject_type == this.getCurrentContentTypeOptions().model_class && order_item.subject_id == item.id;
                                            });

                                            if(existing_item_index !== -1) {
                                                order_items[existing_item_index].qty = Number(order_items[existing_item_index].qty) + 1;
                                                order_items[existing_item_index].base_price = Number(order_items[existing_item_index].unit_price);
                                                order_items[existing_item_index].subtotal_price = Number(order_items[existing_item_index].qty) * order_items[existing_item_index].unit_price;
                                                order_items[existing_item_index].total_price = Number(order_items[existing_item_index].qty) * order_items[existing_item_index].unit_price;
                                            } else {
                                                order_items.push({
                                                    id: null,
                                                    subject_type: this.getCurrentContentTypeOptions().model_class,
                                                    subject_id: item.id,
                                                    name: item.name,
                                                    excerpt: item.excerpt,
                                                    qty: 1,
                                                    unit_price: item.unit_price,
                                                    base_price: item.unit_price,
                                                    subtotal_price: item.unit_price * 1,
                                                    total_price: item.unit_price * 1,
                                                    tax: 0,
                                                    thumbnail: item.thumbnail?.file_name,
                                                    custom_attributes: item.custom_attributes,
                                                    selected_predefined_attribute_values: item.selected_predefined_attribute_values,
                                                });
                                            }
                                        },
                                        selectContentType(content_type) {
                                            this.content_type = content_type;
                                        },
                                        saveCustomOrderItem(order_item_index = null) {
                                            this.custom_order_item.base_price = Number(this.custom_order_item.unit_price);
                                            this.custom_order_item.subtotal_price = Number(this.custom_order_item.qty) * this.custom_order_item.unit_price;
                                            this.custom_order_item.total_price = Number(this.custom_order_item.qty) * this.custom_order_item.unit_price;

                                            {{-- Cuz order_item_index can be 0 -_- --}}
                                            if(order_item_index !== null) {
                                                order_items[order_item_index] = deep_copy(this.custom_order_item);
                                            } else {
                                                order_items.push(deep_copy(this.custom_order_item));
                                            }

                                            this.reset();
                                            show = false;
                                        },
                                        setCustomOrderItem(order_item_index) {
                                            this.selectContentType('custom');
                                            this.order_item_index = order_item_index;
                                            this.hide_content_selector = true;

                                            modal_title = '{{ translate('Edit Order item') }}';

                                            let order_item = order_items[order_item_index];

                                            if(order_item !== undefined) {
                                                this.custom_order_item = deep_copy(order_item);
                                            }
                                        }
                                    }"
                                    @display-modal.window="
                                        if($event.detail.id === id && _.get($event, 'detail.order_item_index', null) !== null ) {
                                            setCustomOrderItem(Number($event.detail.order_item_index));
                                        } else if($event.detail.id === id) {
                                            reset();
                                        }
                                    "
                                    wire:ignore
                                >
                                    <div class="w-full" x-show="!hide_content_selector">
                                        <fieldset>
                                            <legend class="text-base font-medium text-gray-900">{{ translate('Select a content type') }}</legend>

                                            <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4">
                                                <template x-for="type in available_content_types">
                                                    <div class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none"
                                                        :class="{'border-success ring-2 ring-success': content_type === type.slug, 'border-gray-300': content_type !== type.slug}"
                                                        @click="content_type = type.slug; reset()">
                                                        <span class="flex flex-1">
                                                            <span id="project-type-0-label" class="block text-sm font-medium text-gray-900" x-text="type.title"></span>
                                                        </span>

                                                        <svg class="h-5 w-5 text-success" :class="{'hidden': content_type !== type.slug}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                                        </svg>
                                                        {{--
                                                        <span class="pointer-events-none absolute -inset-px rounded-lg border-2" aria-hidden="true"
                                                            :class="{'border-success': content_type === type.slug, 'border-transparent': content_type !== type.slug}"></span> --}}
                                                    </div>
                                                </template>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <template x-if="content_type == 'product' || content_type == 'product_addon'">
                                        <div class="mt-4">
                                            {{-- Products --}}
                                            <x-dashboard.form.blocks.model-selection-form
                                                :inline="true"
                                                :hide-reset="true"
                                                model-class="{{ \App\Models\Product::class }}"
                                                api-route="{{ route('api.dashboard.products.search') }}"
                                                custom-select-logic="select(item);"
                                                custom-deselect-logic=""
                                            ></x-dashboard.form.blocks.model-selection-form>
                                            {{-- END Products --}}
                                        </div>
                                        
                                    
                                        <div class="w-full pt-3 mt-5 border-t">
                                            <template x-if="results">
                                                <div class="w-full mt-3">
                                                    <ul role="list" class="-my-1 divide-y divide-gray-200 max-h-[545px] overflow-y-auto overflow-x-hidden">
                                                        <template x-for="item in results">
                                                            <li class="py-4">
                                                                <div class="flex items-center space-x-4">
                                                                <div class="flex-shrink-0">
                                                                    <img class="h-8 w-8 rounded-full" :src="window.WE.IMG.url(item.thumbnail?.file_name)" alt="">
                                                                </div>
                                                                <div class="min-w-0 flex-1">
                                                                    <p class="truncate text-sm font-medium text-gray-900" x-text="item.name"></p>
                                                                    <p class="truncate text-sm text-gray-500" x-text="item.slug"></p>
                                                                </div>
                                                                <div>
                                                                    <div @click="select(item); reset(); show = false;" class="cursor-pointer inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">
                                                                        {{ translate('Select') }}
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </li>
                                                        </template>
                                                    </ul>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    <template x-if="content_type == 'custom'">
                                        <div class="w-full " :class="{hide_content_selector: 'pt-3 mt-5 border-t'}">
                                            <div class="grid grid-cols-12 gap-x-3">
                                                <div class="col-span-12 flex-col gap-y-2">
                                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                        {{ translate('Name') }}
                                                    </label>

                                                    <div class="w-full ">
                                                        <input type="text" class="form-standard" x-model="custom_order_item.name">
                                                    </div>
                                                </div>

                                                <div class="col-span-12 flex-col gap-y-2">
                                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                        {{ translate('Description') }}
                                                    </label>

                                                    <div class="w-full ">
                                                        <input type="text" class="form-standard  " x-model="custom_order_item.excerpt">
                                                    </div>
                                                </div>

                                                <div class="col-span-8 flex-col gap-y-2">
                                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                        {{ translate('Unit Price') }}
                                                    </label>

                                                    <div class="w-full ">
                                                        <input type="number" class="form-standard  " x-model="custom_order_item.unit_price">
                                                    </div>
                                                </div>

                                                <div class="col-span-4 flex-col gap-y-2">
                                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                        {{ translate('Quantity') }}
                                                    </label>

                                                    <div class="w-full ">
                                                        <input type="number" class="form-standard  " x-model="custom_order_item.qty">
                                                    </div>
                                                </div>

                                                {{-- Attributes Divider --}}
                                                <div class="col-span-12 relative py-5">
                                                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                                    <div class="w-full border-t border-gray-300"></div>
                                                    </div>
                                                    <div class="relative flex justify-center">
                                                    <button type="button" class="inline-flex items-center rounded-full border border-gray-300 bg-white px-4 py-1.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                        <span>{{ translate('Attributes') }}</span>
                                                    </button>
                                                    </div>
                                                </div>

                                                <div class="col-span-12 ">
                                                    <x-dashboard.form.blocks.attributes-selection-form
                                                        form-id="custom-order-item-form"
                                                        attributes-field="custom_order_item.custom_attributes"
                                                        selected-attributes-field="custom_order_item.selected_predefined_attribute_values"
                                                        :no-variations="true">

                                                    </x-dashboard.form.blocks.attributes-selection-form>
                                                </div>

                                                <div class="col-span-12 flex justify-between sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-2">
                                                    <button type="button" class="btn btn-primary ml-auto btn-sm" @click="saveCustomOrderItem(order_item_index)" >
                                                        {{ translate('Save Custom Item') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </x-system.form-modal>
                            {{-- END OrderItem selector modal --}}

                            {{-- OrderItem editor modal --}}
                            <x-system.form-modal id="order-item-editor-modal" title="Add New Order Item" class="!max-w-xl" :prevent-close="true">
                                <div class="w-full flex flex-col" x-data="{
                                        order_item_index: null,
                                        order_item: {
                                            id: null,
                                            subject_id: '',
                                            subject_type: '',
                                            name: '',
                                            excerpt: '',
                                            qty: 1,
                                            unit_price: 0,
                                            base_price: 0,
                                            subtotal_price: 0,
                                            total_price: 0,
                                            custom_attributes: @js($custom_attributes),
                                            selected_predefined_attribute_values: @js($selected_predefined_attribute_values),
                                        },
                                        reset() {
                                            this.order_item_index = null;

                                            this.order_item.id = null;
                                            this.order_item.subject_id = '';
                                            this.order_item.subject_type = '';
                                            this.order_item.name = '';
                                            this.order_item.excerpt = '';
                                            this.order_item.qty = 1;
                                            this.order_item.unit_price = 0;
                                            this.order_item.base_price = 0;
                                            this.order_item.subtotal_price = 0;
                                            this.order_item.total_price = 0;

                                            {{-- Send event to reset attributes form --}}
                                            $dispatch('reset-attributes-form', {form_id: 'order-item-attributes-form'});
                                        },
                                        setOrderItem(order_item_index) {
                                            this.order_item_index = order_item_index;

                                            modal_title = '{{ translate('Edit Order item') }}';

                                            let order_item_copy = order_items[order_item_index];

                                            if(order_item_copy !== undefined) {
                                                this.order_item = deep_copy(order_item_copy);
                                            }
                                        },
                                        saveOrderItem(order_item_index = null) {
                                            this.order_item.base_price = Number(this.order_item.unit_price);
                                            this.order_item.subtotal_price = Number(this.order_item.qty) * this.order_item.unit_price;
                                            this.order_item.total_price = Number(this.order_item.qty) * this.order_item.unit_price;

                                            {{-- Cuz order_item_index can be 0 -_- --}}
                                            if(order_item_index !== null) {
                                                order_items[order_item_index] = deep_copy(this.order_item);
                                            } else {
                                                order_items.push(deep_copy(this.order_item));
                                            }

                                            this.reset();
                                            show = false;
                                        },
                                    }"
                                    @display-modal.window="
                                        if($event.detail.id === id && _.get($event, 'detail.order_item_index', null) !== null ) {
                                            setOrderItem(Number($event.detail.order_item_index));
                                        }
                                    "
                                    wire:ignore
                                >
                                    <div class="w-full">
                                        <div class="grid grid-cols-12 gap-x-3">
                                            <div class="col-span-12 flex-col gap-y-2">
                                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    {{ translate('Name') }}
                                                </label>

                                                <div class="w-full ">
                                                    <input type="text" class="form-standard" x-model="order_item.name">
                                                </div>
                                            </div>

                                            <div class="col-span-12 flex-col gap-y-2">
                                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    {{ translate('Description') }}
                                                </label>

                                                <div class="w-full ">
                                                    <input type="text" class="form-standard  " x-model="order_item.excerpt" >
                                                </div>
                                            </div>

                                            <div class="col-span-8 flex-col gap-y-2">
                                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    {{ translate('Unit Price') }}
                                                </label>

                                                <div class="w-full ">
                                                    <input type="number" class="form-standard  " x-model="order_item.unit_price">
                                                </div>
                                            </div>

                                            <div class="col-span-4 flex-col gap-y-2">
                                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    {{ translate('Quantity') }}
                                                </label>

                                                <div class="w-full ">
                                                    <input type="number" class="form-standard  " x-model="order_item.qty">
                                                </div>
                                            </div>

                                            {{-- Attributes Divider --}}
                                            <div class="col-span-12 relative py-5">
                                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                                    <div class="w-full border-t border-gray-300"></div>
                                                </div>
                                                <div class="relative flex justify-center">
                                                    <button type="button" class="inline-flex items-center rounded-full border border-gray-300 bg-white px-4 py-1.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">
                                                        <span>{{ translate('Attributes') }}</span>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="col-span-12 ">
                                                <x-dashboard.form.blocks.attributes-selection-form
                                                    form-id="order-item-attributes-form"
                                                    attributes-field="order_item.custom_attributes"
                                                    selected-attributes-field="order_item.selected_predefined_attribute_values"
                                                    :no-variations="true">

                                                </x-dashboard.form.blocks.attributes-selection-form>
                                            </div>

                                            <div class="col-span-12 flex justify-between sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-2">
                                                <button type="button" class="btn btn-primary ml-auto btn-sm" @click="saveOrderItem(order_item_index)" >
                                                    {{ translate('Save') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </x-system.form-modal>
                            {{-- END OrderItem editor modal --}}


                        </div>
                    </div>
                {{-- END Order Items --}}
                                </div>

                                {{-- Billing & Shipping divider --}}
                                <div class="relative pt-10 pb-5 col-span-12">
                                    <div class="absolute inset-0 flex items-center pt-5" aria-hidden="true">
                                      <div class="w-full border-t border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-center">
                                      <button type="button" class="inline-flex items-center rounded-full border border-gray-300 bg-white px-4 py-1.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        <span>{{ translate('Billing & Shipping') }}</span>
                                      </button>
                                    </div>
                                </div>
                                {{-- END Billing & Shipping divider --}}

                                {{-- Billing Info --}}
                                <div class="col-span-12 md:col-span-6 flex flex-col gap-y-3">

                                    <div class="col-span-12 flex flex-col gap-y-2">
                                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            {{ translate('Billing Entity') }}
                                        </label>

                                        <div class="w-full flex gap-x-4">
                                            <div class="flex items-center">
                                                <x-dashboard.form.input field="wef.billing_entity" :x="true" type="radio" value="individual" input-id="entity_individual_radio" class="w-auto flex items-center" />

                                                <label for="entity_individual_radio" class="pl-3 block text-sm font-medium text-gray-700">
                                                    {{ translate('Individual') }}
                                                </label>
                                            </div>
                    
                                            <div class="flex items-center">
                                                <x-dashboard.form.input field="wef.billing_entity" :x="true" type="radio" value="company" 
                                                    input-id="entity_company_radio" class="w-auto flex items-center" />

                                                <label for="entity_company_radio" class="pl-3 block text-sm font-medium text-gray-700">
                                                    {{ translate('Company') }} </label>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="grid grid-cols-12 gap-x-3">
                                        <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                {{ translate('Billing First Name') }}
                                            </label>

                                            <x-dashboard.form.input :x="true" field="billing_first_name" error-field="order.billing_first_name" />
                                        </div>

                                        <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                {{ translate('Billing Last Name') }}
                                            </label>

                                            <x-dashboard.form.input :x="true" field="billing_last_name" error-field="order.billing_last_name" />
                                        </div>
                                    </div>

                                    <div class="-full flex flex-col gap-y-2" x-show="!user_id">
                                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            {{ translate('Customer Email') }}
                                        </label>

                                        <x-dashboard.form.input field="email" error-field="order.email" :x="true" />
                                    </div>

                                    <div class="-full flex flex-col gap-y-2" x-show="wef.billing_entity === 'company'">
                                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            {{ translate('Billing Company') }}
                                        </label>

                                        <x-dashboard.form.input :x="true" field="billing_company" error-field="order.billing_company" />
                                    </div>

                                    <div class="grid grid-cols-12 gap-x-3" x-show="wef.billing_entity === 'company'">
                                        <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                {{ translate('Company VAT') }}
                                            </label>

                                            <x-dashboard.form.input field="wef.billing_company_vat" :x="true" />
                                        </div>

                                        <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                {{ translate('Company Code') }}
                                            </label>

                                            <x-dashboard.form.input field="wef.billing_company_code" :x="true" />
                                        </div>
                                    </div>

                                    <div class="w-full flex flex-col gap-y-2">
                                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            {{ translate('Billing Address') }}
                                        </label>

                                        <x-dashboard.form.input :x="true" field="billing_address" error-field="order.billing_address" />
                                    </div>

                                    <div class="grid grid-cols-12 gap-x-3">
                                        <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                {{ translate('Billing Country') }}
                                            </label>

                                            <x-dashboard.form.select field="order.billing_country" selected="billing_country" :items="\Countries::getCodesForSelect(as_array: true)" :search="true" :nullable="false" />
                                        </div>

                                        <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                {{ translate('Billing State') }}
                                            </label>

                                            <x-dashboard.form.input :x="true" field="billing_state" error-field="order.billing_state" />
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-12 gap-x-3">
                                        <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                {{ translate('Billing City') }}
                                            </label>

                                            <x-dashboard.form.input :x="true" field="billing_city" error-field="order.billing_city" />
                                        </div>

                                        <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                {{ translate('Billing ZIP') }}
                                            </label>

                                            <x-dashboard.form.input :x="true" field="billing_zip" error-field="order.billing_zip" />
                                        </div>
                                    </div>

                                </div>
                                {{-- END Billing Info --}}

                                {{-- Shipping Info --}}
                                @if(!$hideShipping)
                                    <div class="col-span-12 md:col-span-6 flex flex-col gap-y-3">

                                        <div class="grid grid-cols-12 gap-x-3">
                                            <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    {{ translate('Shipping First Name') }}
                                                </label>

                                                <x-dashboard.form.input :="true" field="shipping_first_name" error-field="order.shipping_first_name" />
                                            </div>

                                            <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    {{ translate('Shipping Last Name') }}
                                                </label>

                                                <x-dashboard.form.input :="true" field="shipping_last_name" error-field="order.shipping_last_name" />
                                            </div>
                                        </div>

                                        <div class="w-full flex flex-col gap-y-2">
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                {{ translate('Shipping Address') }}
                                            </label>

                                            <x-dashboard.form.input :="true" field="shipping_address" error-field="order.shipping_address" />
                                        </div>

                                        <div class="grid grid-cols-12 gap-x-3">
                                            <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    {{ translate('Shipping Country') }}
                                                </label>

                                                <x-dashboard.form.select field="order.shipping_country" selected="shipping_country" :items="\Countries::getCodesForSelect(as_array: true)" :search="true" :nullable="false" />
                                            </div>

                                            <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    {{ translate('Shipping State') }}
                                                </label>

                                            <x-dashboard.form.input :="true" field="shipping_state" error-field="order.shipping_state" />
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-12 gap-x-3">
                                            <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    {{ translate('Shipping City') }}
                                                </label>

                                            <x-dashboard.form.input :="true" field="shipping_city" error-field="order.shipping_city" />
                                            </div>

                                            <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    {{ translate('Shipping ZIP') }}
                                                </label>

                                            <x-dashboard.form.input :="true" field="shipping_zip" error-field="order.shipping_zip" />
                                            </div>
                                        </div>

                                    </div>
                                @endif
                                {{-- END Shipping Info --}}

                                <div class="col-span-12 flex gap-x-2 pt-6 ">
                                    <label class="block text-sm font-medium text-gray-700 shrink-0">
                                        {{ translate('Same billing and shipping address?') }}
                                    </label>

                                    <x-dashboard.form.toggle field="same_billing_shipping" />
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END Order Information --}}


                </div>

                {{-- Right side --}}
                <div class="col-span-12 sm:col-span-4">
                    @do_action('view.dashboard.form.order.right.start', $order)

                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div class="w-full flex items-center justify-between border-b border-gray-200 pb-3 mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Actions') }}</h3>
                        </div>

                        <div class="w-full">
                            <!-- Type -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center">
                                <label class="flex items-center text-sm font-medium text-gray-700">
                                    <span class="mr-2">{{ translate('Type') }}</span>

                                    @if($order->type === App\Enums\OrderTypeEnum::standard()->value)
                                        <span class="badge-success">{{ ucfirst($order->type) }}</span>
                                    @elseif($order->type === App\Enums\OrderTypeEnum::subscription()->value)
                                        <span class="badge-warning">{{ ucfirst($order->type) }}</span>
                                    @elseif($order->type === App\Enums\OrderTypeEnum::installments()->value)
                                        <span class="badge-info">{{ ucfirst($order->type) }}</span>
                                    @endif
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.select :items="\App\Enums\OrderTypeEnum::toArray()" selected="type" :nullable="false"></x-dashboard.form.select>
                                </div>
                            </div>
                            <!-- END Type -->

                            <!-- Payment Status -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:pt-5">
                                <label class="flex items-center text-sm font-medium text-gray-700">
                                    <span class="mr-2">{{ translate('Payment status') }}</span>

                                    @if($order->payment_status === App\Enums\PaymentStatusEnum::unpaid()->value)
                                        <span class="badge-danger">{{ ucfirst($order->payment_status) }}</span>
                                    @elseif($order->payment_status === App\Enums\PaymentStatusEnum::pending()->value)
                                        <span class="badge-info">{{ ucfirst($order->payment_status) }}</span>
                                    @elseif($order->payment_status === App\Enums\PaymentStatusEnum::canceled()->value)
                                        <span class="badge-dark">{{ ucfirst($order->payment_status) }}</span>
                                    @elseif($order->payment_status === App\Enums\PaymentStatusEnum::paid()->value)
                                        <span class="badge-success">{{ ucfirst($order->payment_status) }}</span>
                                    @endif
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.select :items="\App\Enums\PaymentStatusEnum::toArray()" selected="payment_status" :nullable="false"></x-dashboard.form.select>
                                </div>
                            </div>
                            <!-- END Payment Status -->

                            <!-- Shipping Status -->
                            @if(!$hideShipping)
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:pt-5">
                                    <label class="flex items-center text-sm font-medium text-gray-700">
                                        <span class="mr-2">{{ translate('Shipping status') }}</span>

                                        @if($order->shipping_status === App\Enums\ShippingStatusEnum::not_sent()->value)
                                            <span class="badge-danger">{{ ucfirst($order->shipping_status) }}</span>
                                        @elseif($order->shipping_status === App\Enums\ShippingStatusEnum::sent()->value)
                                            <span class="badge-info">{{ ucfirst($order->shipping_status) }}</span>
                                        @elseif($order->shipping_status === App\Enums\ShippingStatusEnum::delivered()->value)
                                            <span class="badge-success">{{ ucfirst($order->shipping_status) }}</span>
                                        @endif
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.select :items="\App\Enums\ShippingStatusEnum::toArray()" selected="shipping_status" :nullable="false"></x-dashboard.form.select>
                                    </div>
                                </div>
                            @endif
                            <!-- END Shipping Status -->

                            {{-- Tracking number --}}
                            <div class="sm:grid sm:grid-cols-3 sm:items-center sm:gap-4 sm:pt-5">
                                <label class="flex items-center text-sm font-medium text-gray-700">
                                    <span class="mr-2">{{ translate('Tracking number') }}</span>
                                </label>

                                <div class="sm:col-span-2">
                                    <x-dashboard.form.input type="text" field="order.tracking_number" />
                                </div>
                            </div>
                            {{-- END Tracking number --}}

                            <div class="w-full flex justify-between sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                                @if(!empty($order->id) && $order->invoices->isEmpty())
                                    @ob_start()
                                        <button type="button" class="btn btn-warning btn-sm" 
                                            @click="save()"
                                            wire:click="generateInvoice()">

                                            {{ translate('Generate Invoice') }}
                                        </button>
                                    @ob_do_action('view.dashboard.form.order.generate-invoice-btn', $order)
                                @endif

                                <button type="button" class="btn btn-primary ml-auto btn-sm" @click="save()" wire:click="saveOrder()" >
                                    {{ translate('Save') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Order Summary --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-7" wire:ignore>
                        <div class="w-full flex items-center justify-between border-b border-gray-200 pb-3 mb-3">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Order Summary') }}</h3>
                        </div>

                        <div class="w-full flex flex-col">
                            <template x-if="orderItemsCount > 0">
                                <ul class="w-full flex flex-col gap-y-2">
                                    <template x-for="(item, index) in order_items" :key="'summary-order-item-'+index">
                                        <li class="relative flex items-center">
                                            <div class="min-w-0 flex-1 pr-7">
                                                <p class="text-sm font-medium text-gray-900" x-text="item.qty+' x '+item.name"></p>
                                            </div>
                                            <div class="flex-shrink-0 flex items-center gap-x-4">
                                                <span x-text="FX.formatPrice(item.total_price)"></span>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </template>

                            {{-- Empty state --}}
                            <template x-if="orderItemsCount <= 0">
                                <div class="text-center py-2">
                                    <h3 class="text-sm font-medium text-gray-900">{{ translate('No order items') }}</h3>
                                </div>
                            </template>

                            <div class="w-full pt-3 mt-3 border-t flex flex-col">
                                @if(!$hideShipping)
                                    {{-- Shipping method --}}
                                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 pt-2">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">{{ translate('Shipping cost') }}</label>
                                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                                            <x-dashboard.form.input type="number" field="shipping_cost" min="0" :x="true" />
                                        </div>
                                    </div>
                                    {{-- END Shipping method --}}
                                @endif

                                {{-- TAX --}}
                                <div class="sm:grid sm:grid-cols-3 sm:items-center sm:gap-4 pt-2">
                                    <label for="first-name" class="block text-sm font-medium text-gray-700">
                                        {{ translate('Tax(percent)') }}
                                    </label>
                                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                                        <x-dashboard.form.input disabled type="number" field="tax" :x="true" min="0" max="100" />
                                    </div>
                                </div>
                                {{-- END TAX --}}


                                {{-- Deposit amount (value in percentage of total value which needs to be paid in advance by customer) --}}
                                <div class="sm:grid sm:grid-cols-3 sm:items-center sm:gap-4 pt-2" x-show="type === 'installments'">
                                    <label for="first-name" class="block text-sm font-medium text-gray-700">
                                        {{ translate('Deposit amount (in % of total value)') }}
                                    </label>
                                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                                        <x-dashboard.form.input type="number" field="wef.deposit_amount" :x="true" min="0" max="100" :disabled="true" class="flex flex-col">
                                            <div class="flex justify-end items-center mt-1">
                                                <button type="button" class="text-12 hover:underline" :class="{'text-primary': disabled, 'text-success': !disabled}" 
                                                    x-text="disabled ? '{{ translate('Change') }}' : '{{ translate('Lock') }}'" @click="disabled = !disabled;"></button>
                                            </div>
                                        </x-dashboard.form.input>
                                    </div>
                                </div>
                                {{-- END Deposit amount --}}
                            </div>

                            <div class="w-full pt-3 mt-4 border-t flex flex-col">
                                <dl class="flex flex-col gap-y-4 pt-2 text-sm font-medium text-gray-500">
                                    <div class="flex justify-between">
                                      <dt>{{ translate('Subtotal') }}</dt>
                                      <dd class="text-gray-900" x-text="FX.formatPrice(subtotal)"></dd>
                                    </div>

                                    @if(!$hideShipping)
                                        <div class="flex justify-between">
                                            <dt>{{ translate('Shipping') }}</dt>
                                            <dd class="text-gray-900" x-text="FX.formatPrice(shipping_cost)"></dd>
                                        </div>
                                    @endif

                                    <div class="flex justify-between">
                                      <dt x-text="'{{ translate('Tax') }} ('+tax+'%)'"></dt>
                                      <dd class="text-gray-900" x-text="tax_incl ? '('+taxAmount+')' : taxAmount"></dd>
                                    </div>

                                    <div class="flex items-center justify-between border-t border-gray-200 pt-4 text-gray-900">
                                      <dt class="text-base">{{ translate('Total') }}</dt>
                                      <dd class="text-base" x-text="FX.formatPrice(total)"></dd>
                                    </div>

                                    <template x-if="type === 'installments' && wef.deposit_amount > 0 && wef.deposit_amount <= 100">
                                        <div class="flex items-center justify-between border-t border-gray-200 pt-4 text-gray-900">
                                            <dt class="text-base">{{ translate('Deposit amount') }}</dt>
                                            <dd class="text-base" x-text="FX.formatPrice(total * wef.deposit_amount / 100)"></dd>
                                        </div>
                                    </template>
                                </dl>
                            </div>
                        </div>
                    </div>
                    {{-- END Order Summary --}}


                    <x-dashboard.form.blocks.core-meta-form></x-dashboard.form.blocks.core-meta-form>

                </div>
            </div>

        </div>
    </div>
</div>
