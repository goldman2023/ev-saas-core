<div class="relative w-full md:max-w-[920px] flex flex-wrap justify-between items-start self-center z-10 py-[60px]" x-data="{
    order_items: @entangle('order_items').defer,
    get hasOrderItems() {
        return _.get(this.order_items, 'length', 0) > 0;
    },
    manual_mode_billing: @js($manual_mode_billing),
    manual_mode_shipping: @js($manual_mode_shipping),
    show_addresses: @js($show_addresses),
    addresses: @js($addresses),
    selected_billing_address_id: Number(@js($selected_billing_address_id)),
    selected_shipping_address_id: Number(@js($selected_shipping_address_id)),
    same_billing_shipping: @js($order->same_billing_shipping ? true : false),
    buyers_consent: @js($order->buyers_consent ? true : false),
    available_payment_methods: @js(\Payments::getPaymentMethodsForSelect()),
    selected_payment_method: @js($this->selected_payment_method),
    phoneNumbers: @js($order->phone_numbers),
    shippingCountry: @js($order->shipping_country),
    billingCountry: @js($order->billing_country),
    core_meta: @js($core_meta),
    wef: @entangle('wef').defer,
    setDefaults() {
        if(this.wef.billing_entity !== 'individual' && this.wef.billing_entity !== 'company') {
            this.wef.billing_entity = 'individual';
        }
    },
    save() {
        $wire.set('order.phone_numbers', this.phoneNumbers, true);
        $wire.set('order.billing_country', this.billingCountry, true);
        $wire.set('order.shipping_country', this.shippingCountry, true);
        $wire.set('selected_payment_method', this.selected_payment_method, true);
        $wire.set('order.same_billing_shipping', this.same_billing_shipping, true);
        $wire.set('order.buyers_consent', this.buyers_consent, true);
        $wire.set('selected_billing_address_id', this.selected_billing_address_id || -1, true);
        $wire.set('selected_shipping_address_id', this.selected_shipping_address_id || -1, true);

        {{-- $wire.set('order_items', this.order_items, true); --}}
        $wire.set('manual_mode_billing', this.manual_mode_billing, true);
        $wire.set('manual_mode_shipping', this.manual_mode_shipping, true);
        $wire.set('core_meta', this.core_meta, true);
        {{-- $wire.set('wef', this.wef, true); --}}
    }
}"
@validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
x-init="setDefaults();"
x-cloak>
    <div class="w-full md:max-w-[400px]">
        <x-tenant.system.image alt="{{ get_site_name() }} logo"
            class="block p-0 mb-6 max-w-[160px]" :image="get_site_logo()">
        </x-tenant.system.image>

        <div class="item-summary w-full flex-col">
            <div class="pb-2 mb-2 flex justify-between items-center  border-b border-gray-200">
                <strong class="flex">{{ translate('Request a quote for:') }}</strong>
                <button type="button" class="btn btn-primary !py-1 !text-12 focus:!ring-0"
                @click="$dispatch('display-modal', {'id': 'order-item-selector-modal' })">
                    {{ translate('Add item') }}
                </button>
            </div>

            <template x-if="hasOrderItems" key="request-a-quote-order-items" wire:ignore>
                <ul class="flex flex-col list-none pt-3 " wire:ignore>
                    <template x-for="(item, index) in order_items" :key="'order-items-'+index">
                        <li class="w-full flex flex-col justify-left pb-3">
                            <div class="w-full flex justify-left">
                                <div class="w-[65px] h-[65px] shrink-0" x-show="item?.thumbnail">
                                    <img class="w-[65px] h-[65px] object-cover rounded border"
                                        :src="window.WE.IMG.url(item?.thumbnail)" />
                                </div>
                                <div class="w-full flex flex-col">
                                    <div class="w-full flex justify-between pl-4">
                                        <strong class="line-clamp-1" x-text="item.name"></strong>
                                        <span class="pl-2">{{ translate('Qty') }}: <b x-text="item.quantity"></b></span>
                                    </div>
                                    <div class="w-full leading-4 pl-4 mt-auto">
                                        <button type="button" class="btn-standard-outline !py-0.5 !text-12 hover:!bg-primary hover:!text-white focus:!ring-0"
                                            @click="$dispatch('display-modal', {'id': 'order-item-editor-modal', 'order_item_index': index })">
                                            {{ translate('Edit item') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </template>
                </ul>
            </template>

            <template x-if="!hasOrderItems">
                <div class="text-center py-2 cursor-pointer" @click="$dispatch('display-modal', {'id': 'order-item-selector-modal' })">
                    @svg('heroicon-o-plus-circle', ['class' => 'mx-auto h-12 w-12 text-gray-400'])
                    <h3 class="mt-2 text-sm font-medium text-gray-900">{{ translate('No order items') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ translate('Start by adding new item to the order') }}</p>
                </div>
            </template>


            <div class="mt-2 pt-2 flex justify-start border-t border-gray-200">
                <div
                    class="flex flex-row items-center pr-4 relative after:content-[''] after:absolute after:right-0 after:bg-gray-300 after:h-[15px] after:top-[8px] after:w-[1px]">
                    <span class="text-12 mr-1">{{ translate('Powered by') }}</span>

                    <a style="max-width: 120px !important;" class="navbar-brand p-0 mw-100 text-12"
                        href="https://we-saas.com/" aria-label="">
                        {{-- <img src="https://images.we-saas.com/insecure/fill/0/0/ce/0/plain/https://businesspress.io/wp-content/uploads/2021/12/cropped-Screenshot_2021-12-22_at_15.12.45-removebg-preview.png"
                            style="max-width: 100%;" height="auto" alt=""> --}}
                            <b>BusinessPress</b>
                    </a>
                    {{-- <x-default.system.tenant.logo style="max-width: 50px !important;">
                    </x-default.system.tenant.logo> --}}
                </div>
                <ul class="flex flex-row list-none pl-5">
                    <li class="flex pt-1 px-1 mr-1 items-center">
                        <a href="#" class="text-12 text-gray-500">{{ translate('Terms') }}</a>
                    </li>
                    <li class="flex pt-1 px-1 mr-1 items-center">
                        <a href="#" class="text-12 text-gray-500">{{ translate('Privacy') }}</a>
                    </li>
                    <li class="flex pt-1 px-1 mr-1 items-center">
                        <a href="#" class="text-12 text-gray-500">{{ translate('Contact') }}</a>
                    </li>
                </ul>
            </div>

            {{-- OrderItem selector modal --}}
            <x-system.form-modal id="order-item-selector-modal" title="{{ translate('Add New Order Item') }}" class="!max-w-xl" :prevent-close="true">
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
                            quantity: 1,
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
                            this.custom_order_item.quantity = 1;
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
                                order_items[existing_item_index].quantity = Number(order_items[existing_item_index].quantity) + 1;
                                order_items[existing_item_index].base_price = Number(order_items[existing_item_index].unit_price);
                                order_items[existing_item_index].subtotal_price = Number(order_items[existing_item_index].quantity) * order_items[existing_item_index].unit_price;
                                order_items[existing_item_index].total_price = Number(order_items[existing_item_index].quantity) * order_items[existing_item_index].unit_price;
                            } else {
                                order_items.push({
                                    id: null,
                                    subject_type: this.getCurrentContentTypeOptions().model_class,
                                    subject_id: item.id,
                                    name: item.name,
                                    excerpt: item.excerpt,
                                    quantity: 1,
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
                            this.custom_order_item.subtotal_price = Number(this.custom_order_item.quantity) * this.custom_order_item.unit_price;
                            this.custom_order_item.total_price = Number(this.custom_order_item.quantity) * this.custom_order_item.unit_price;

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

                                {{-- <div class="col-span-8 flex-col gap-y-2">
                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Unit Price') }}
                                    </label>

                                    <div class="w-full ">
                                        <input type="number" class="form-standard" x-model="custom_order_item.unit_price">
                                    </div>
                                </div> --}}

                                <div class="col-span-4 flex-col gap-y-2">
                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Quantity') }}
                                    </label>

                                    <div class="w-full ">
                                        <input type="number" class="form-standard  " x-model="custom_order_item.quantity">
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
            <x-system.form-modal id="order-item-editor-modal" title="{{ translate('Add New Order Item') }}" class="!max-w-xl" :prevent-close="true">
                <div class="w-full flex flex-col" x-data="{
                        order_item_index: null,
                        order_item: {
                            id: null,
                            subject_id: '',
                            subject_type: '',
                            name: '',
                            excerpt: '',
                            quantity: 1,
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
                            this.order_item.quantity = 1;
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
                            this.order_item.subtotal_price = Number(this.order_item.quantity) * this.order_item.unit_price;
                            this.order_item.total_price = Number(this.order_item.quantity) * this.order_item.unit_price;

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

                            {{-- <div class="col-span-8 flex-col gap-y-2">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Unit Price') }}
                                </label>

                                <div class="w-full ">
                                    <input type="number" class="form-standard" x-model="order_item.unit_price">
                                </div>
                            </div> --}}

                            <div class="col-span-4 flex-col gap-y-2">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Quantity') }}
                                </label>

                                <div class="w-full ">
                                    <input type="number" class="form-standard  " x-model="order_item.quantity">
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
    <div class="w-full md:max-w-[400px] ">
        <h1 class="font-semibold text-20 ">{{ translate('Contact information') }}</h1>

        <div class="mt-4" x-cloak>
            {{-- Billing Entity --}}
            {{-- TODO: Fix entity change after failed validation --}}
            <div class="w-full flex flex-col  mb-3 gap-y-2">
                <div class="w-full flex gap-x-4" wire:ignore>
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
                            {{ translate('Company') }}
                        </label>
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="w-full mb-3">
                <label for="order.email" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                    {{ translate('Email') }}
                    <span class="text-red-700 ml-1">*</span>
                </label>

                <x-dashboard.form.input field="order.email" :disabled="\Auth::check()" />
            </div>
            <!-- END Email -->

            <!-- First & Last name -->
            <div class="w-full grid md:grid-cols-2 gap-4 mb-3">
                <div class="">
                    <label for="order.billing_first_name" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                        {{ translate('First name') }}
                        <span class="text-red-700 ml-1">*</span>
                    </label>

                    <x-dashboard.form.input field="order.billing_first_name" />
                </div>
                <div class="">
                    <label for="order.billing_last_name" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                        {{ translate('Last name') }}
                        <span class="text-red-700 ml-1">*</span>
                    </label>

                    <x-dashboard.form.input field="order.billing_last_name" />
                </div>
            </div>
            <!-- END First & Last name -->

            <!-- Company -->
            <div class="w-full mb-3" x-show="wef.billing_entity === 'company'">
                <label class="w-full block mb-2 text-12 font-medium text-gray-900 dark:text-gray-300">
                    {{ translate('Company') }}
                </label>

                <x-dashboard.form.input field="order.billing_company" />
            </div>
            <!-- END Company -->

            {{-- Company VAT & Code --}}
            <div class="w-full mb-3 grid grid-cols-12 gap-x-3" x-show="wef.billing_entity === 'company'" wire:ignore>
                <div class="col-span-12 md:col-span-6 flex flex-col">
                    <label class="w-full block mb-2 text-12 font-medium text-gray-900 dark:text-gray-300">
                        {{ translate('Company VAT') }}
                    </label>

                    <x-dashboard.form.input field="wef.billing_company_vat" :x="true" />
                </div>

                <div class="col-span-12 md:col-span-6 flex flex-col">
                    <label class="w-full block mb-2 text-12 font-medium text-gray-900 dark:text-gray-300">
                        {{ translate('Company Code') }}
                    </label>

                    <x-dashboard.form.input field="wef.billing_company_code" :x="true" />
                </div>
            </div>
            {{-- END Company VAT & Code --}}

            <!-- Phones -->
            <div class="w-full mt-3">
                <label class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                    {{ translate('Phones') }}
                </label>

                <x-dashboard.form.text-repeater field="phoneNumbers" error-field="order.phone_numbers" placeholder="{{ translate('Phone') }}"  limit="3"></x-dashboard.form.text-repeater>
            </div>
            <!-- END Phones -->

            <hr class="mt-2" />

            <div class="flex flex-col mt-4">
                <!-- Checkbox -->
                <div class="flex items-center cursor-pointer">
                    <input type="checkbox" class="form-checkbox-standard" id="order-same_billing_shipping" name="order.same_billing_shipping"
                            x-model="same_billing_shipping" @click="$dispatch('shipping-info-errors-clean')">
                    <div class="ml-2">
                        <label for="order-same_billing_shipping" class="text-12 font-medium text-gray-500 mb-0 cursor-pointer">
                            {{ translate('My billing and delivery information are the same') }}
                        </label>
                    </div>
                </div>
                <!-- End Checkbox -->
            </div>

            <hr class="mt-4" />

            <!-- Billing -->
            <div class="d-flex flex-wrap mt-3" x-cloak>
                <h4 class="text-14 font-semibold" >
                    {{ translate('Billing address') }}
                </h4>

                <div class="w-full" wire:ignore>
                    <template x-if="show_addresses">
                        <fieldset>
                            <div class="mt-2 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4" >
                                <template x-for="address in addresses" :key="address">
                                    <label class="relative bg-white border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none"
                                            :class="{'border-transparent ring-2 ring-primary':selected_billing_address_id === address.id  , 'border-gray-300':selected_billing_address_id !== address.id}"
                                            @click="selected_billing_address_id = address.id; manual_mode_billing = false;">
                                        <div class="flex-1 flex">
                                            <div class="flex flex-col">
                                                <span class="block text-sm font-medium text-gray-900" x-text="address.country"></span>
                                                <span class="mt-1 flex items-center text-sm text-gray-700" x-text="address.address+', '+address.city+', '+address.zip_code"></span>
                                            </div>
                                        </div>

                                        @svg('heroicon-s-check-circle', ['class' => 'h-5 w-5 text-primary', ':class' => '{\'hidden\': selected_billing_address_id !== address.id}'])
                                        {{-- <svg class=" text-indigo-600" :class="{ 'hidden ' : selected_billing_address_id === address.id }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg> --}}

                                        <div class="absolute -inset-px rounded-lg border-2 pointer-events-none" aria-hidden="true"
                                            :class="{ 'border border-primary': (selected_billing_address_id === address.id), 'border-2 border-transparent': (selected_billing_address_id !== address.id) }">
                                        </div>
                                    </label>
                                </template>

                                {{-- Manual billing address --}}
                                <label class="relative bg-white border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none"
                                        :class="{'border-transparent ring-2 ring-primary':selected_billing_address_id === -1, 'border-gray-300':selected_billing_address_id !== -1}"
                                        @click="selected_billing_address_id = -1; manual_mode_billing = true;">
                                    <div class="flex-1 flex">
                                        <div class="flex flex-col justify-center items-center">
                                            <span class="text-left text-14">{{ translate('Add billing address manually') }}</span>
                                        </div>
                                    </div>

                                    @svg('heroicon-s-check-circle', ['class' => 'h-5 w-5 text-primary', ':class' => '{\'hidden\': selected_billing_address_id !== -1}'])

                                    <div class="absolute -inset-px rounded-lg border-2 pointer-events-none" aria-hidden="true"
                                        :class="{ 'border border-primary': (selected_billing_address_id === -1), 'border-2 border-transparent': (selected_billing_address_id !== -1) }">
                                    </div>
                                </label>
                                {{-- END Manual billing address --}}

                            </div>
                        </fieldset>
                    </template>
                </div>


                <template x-if="show_addresses">
                    <input type="hidden" name="selected_billing_address_id" x-model="selected_billing_address_id">
                </template>


                <div class="flex-wrap mt-3" :class="{'flex':manual_mode_billing}" x-show="manual_mode_billing">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="order.billing_address" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                                {{ translate('Address') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input name="order.billing_address"
                                    id="order.billing_address"
                                    type="text"
                                    wire:model.defer="order.billing_address"
                                    class="form-standard @error('order.billing_address') is-invalid @enderror"
                            />

                            <x-system.invalid-msg field="order.billing_address" ></x-system.invalid-msg>
                        </div>

                        <div class="">
                            <label for="order.billing_country" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                                {{ translate('Country') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <x-dashboard.form.select field="billingCountry"
                                :search="true"
                                error-field="order.billing_country"
                                :items="\Countries::getAll()->keyBy('code')->map(fn($item) => $item->name)"
                                selected="billingCountry"
                                :nullable="false"></x-dashboard.form.select>

                            {{-- <input name="order.billing_country"
                                    id="order.billing_country"
                                    type="text"
                                    wire:model.defer="order.billing_country"
                                    class="form-standard @error('order.billing_country') is-invalid @enderror"
                            />--}}
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Col -->


                    <div class="grid grid-cols-3 gap-4 mt-3">
                        <div class="">
                            <label for="order.billing_state" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                                {{ translate('State') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input name="order.billing_state"
                                    id="order.billing_state"
                                    type="text"
                                    wire:model.defer="order.billing_state"
                                    class="form-standard @error('order.billing_state') is-invalid @enderror"
                            />

                            <x-system.invalid-msg field="order.billing_state" ></x-system.invalid-msg>
                        </div>
                        <!-- End Col -->

                        <div class="">
                            <label for="order.billing_city" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                                {{ translate('City') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input name="order.billing_city"
                                    id="order.billing_city"
                                    type="text"
                                    wire:model.defer="order.billing_city"
                                    class="form-standard @error('order.billing_city') is-invalid @enderror"
                            />

                            <x-system.invalid-msg field="order.billing_city" ></x-system.invalid-msg>
                        </div>
                        <!-- End Col -->

                        <div class="">
                            <label for="order.billing_zip" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                                {{ translate('ZIP') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input name="order.billing_zip"
                                    id="order.billing_zip"
                                    type="text"
                                    wire:model.defer="order.billing_zip"
                                    class="form-standard @error('order.billing_zip') is-invalid @enderror"
                            />

                            <x-system.invalid-msg field="order.billing_zip" ></x-system.invalid-msg>
                        </div>
                        <!-- End Col -->
                    </div>
                </div>
            </div>
            <!-- END Billing -->

            <hr class="mt-4" x-show="!same_billing_shipping"/>

            <!-- Shipping -->
            <div class="shipping-info-section flex flex-wrap mt-3" :class="{'hidden': same_billing_shipping}" x-data="{
                clearErrors() {
                    document.querySelectorAll('.shipping-info-section .error-msg').forEach(item => item.remove())
                    document.querySelectorAll('.shipping-info-section .is-invalid').forEach(item => item.classList.remove('is-invalid'));
                }
            }" @shipping-info-errors-clean.window="clearErrors()">
                <h4 class="text-14 font-semibold" >
                    {{ translate('Shipping address') }}
                </h4>

                <div class="w-full" wire:ignore>
                    <template x-if="show_addresses">
                        <fieldset>
                            <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4" >
                                <template x-for="address in addresses">
                                    <label class="relative bg-white border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none"
                                            :class="{'border-transparent ring-2 ring-primary':selected_shipping_address_id === address.id  , 'border-gray-300':selected_shipping_address_id !== address.id}"
                                            @click="selected_shipping_address_id = address.id; manual_mode_shipping = false;">
                                        <div class="flex-1 flex">
                                            <div class="flex flex-col">
                                                <span class="block text-sm font-medium text-gray-900" x-text="address.country"></span>
                                                <span class="mt-1 flex items-center text-sm text-gray-700" x-text="address.address+', '+address.city+', '+address.zip_code"></span>
                                            </div>
                                        </div>

                                        @svg('heroicon-s-check-circle', ['class' => 'h-5 w-5 text-primary', ':class' => '{\'hidden\': selected_shipping_address_id !== address.id}'])

                                        <div class="absolute -inset-px rounded-lg border-2 pointer-events-none" aria-hidden="true"
                                            :class="{ 'border border-primary': (selected_shipping_address_id === address.id), 'border-2 border-transparent': (selected_shipping_address_id !== address.id) }">
                                        </div>
                                    </label>

                                    {{-- <div class="col-12 col-md-6 col-lg-4 mb-3 px-2">
                                        <div class="card w-100 pointer h-100 position-relative"
                                                :class="{ 'border-primary shadow' : selected_billing_address_id === address.id }"
                                                @click="selected_billing_address_id = address.id; manual_mode_shipping = false;">
                                            <div class="card-body position-relative">

                                                <h6 class="card-subtitle" x-text="address.country"></h6>
                                                <h3 class="card-title text-18" x-text="address.address"></h3>
                                                <p class="card-text mb-2" x-text="address.city+', '+address.zip_code"></p>

                                                <template x-if="address.phones != null && address.phones.length > 0">
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <template x-for="phone in address.phones">
                                                            <span class="badge badge-info mr-2 mb-2" x-text="phone"></span>
                                                        </template>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div> --}}
                                </template>

                                <label class="relative bg-white border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none"
                                        :class="{'border-transparent ring-2 ring-primary':selected_shipping_address_id === -1, 'border-gray-300':selected_shipping_address_id !== -1}"
                                        @click="selected_shipping_address_id = -1; manual_mode_shipping = true;">
                                    <div class="flex-1 flex">
                                        <div class="flex flex-col justify-center items-center">
                                            <span class="text-left text-14">{{ translate('Add shipping address manually') }}</span>
                                        </div>
                                    </div>

                                    @svg('heroicon-s-check-circle', ['class' => 'h-5 w-5 text-primary', ':class' => '{\'hidden\': selected_shipping_address_id !== -1}'])

                                    <div class="absolute -inset-px rounded-lg border-2 pointer-events-none" aria-hidden="true"
                                        :class="{ 'border border-primary': (selected_shipping_address_id === -1), 'border-2 border-transparent': (selected_shipping_address_id !== -1) }">
                                    </div>
                                </label>
                            </div>
                        </fieldset>
                    </template>

                    <template x-if="show_addresses">
                        <input type="hidden" name="selected_shipping_address_id" x-model="selected_shipping_address_id">
                    </template>
                </div>


                <div class="flex-wrap mt-3" :class="{'flex':manual_mode_shipping}" x-show="manual_mode_shipping">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="order.shipping_address" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                                {{ translate('Address') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input name="order.shipping_address"
                                    id="order.shipping_address"
                                    type="text"
                                    wire:model.defer="order.shipping_address"
                                    class="form-standard @error('order.shipping_address') is-invalid @enderror"
                            />

                            <x-system.invalid-msg field="order.shipping_address" ></x-system.invalid-msg>
                        </div>

                        <div class="">
                            <label for="order.shipping_country" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                                {{ translate('Country') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <x-dashboard.form.select field="shippingCountry" error-field="order.shipping_country" :items="\Countries::getAll()->keyBy('code')->map(fn($item) => $item->name)" selected="shippingCountry" :nullable="true"></x-dashboard.form.select>
                            {{--
                            <input name="order.shipping_country"
                                    id="order.shipping_country"
                                    type="text"
                                    wire:model.defer="order.shipping_country"
                                    class="form-standard @error('order.shipping_country') is-invalid @enderror"
                            />

                            <x-system.invalid-msg field="order.shipping_country" ></x-system.invalid-msg> --}}
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Col -->


                    <div class="grid grid-cols-3 gap-4 mt-3">
                        <div class="">
                            <label for="order.shipping_state" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                                {{ translate('State') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input name="order.shipping_state"
                                    id="order.shipping_state"
                                    type="text"
                                    wire:model.defer="order.shipping_state"
                                    class="form-standard @error('order.shipping_state') is-invalid @enderror"
                            />

                            <x-system.invalid-msg field="order.shipping_state" ></x-system.invalid-msg>
                        </div>
                        <!-- End Col -->

                        <div class="">
                            <label for="order.shipping_city" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                                {{ translate('City') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input name="order.shipping_city"
                                    id="order.shipping_city"
                                    type="text"
                                    wire:model.defer="order.shipping_city"
                                    class="form-standard @error('order.shipping_city') is-invalid @enderror"
                            />

                            <x-system.invalid-msg field="order.shipping_city" ></x-system.invalid-msg>
                        </div>
                        <!-- End Col -->

                        <div class="">
                            <label for="order.shipping_zip" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                                {{ translate('ZIP') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input name="order.shipping_zip"
                                    id="order.shipping_zip"
                                    type="text"
                                    wire:model.defer="order.shipping_zip"
                                    class="form-standard @error('order.shipping_zip') is-invalid @enderror"
                            />

                            <x-system.invalid-msg field="order.shipping_zip" ></x-system.invalid-msg>
                        </div>
                        <!-- End Col -->
                    </div>
                </div>
            </div>
            <!-- END Shipping -->

            <hr class="mt-4" />

            <div class="flex flex-wrap mt-3" x-data="{
                    clearErrors() {
                        document.querySelectorAll('.payment-methods-details .error-msg').forEach(item => item.remove())
                        document.querySelectorAll('.payment-methods-details .is-invalid').forEach(item => item.classList.remove('is-invalid'));
                    }
                }">
                {{-- <h4 class="text-14 font-semibold" >
                    {{ translate('Shipping address') }}
                </h4> --}}
                <fieldset class="w-full mt-2 grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-2 md:grid-cols-3" >
                    <template x-for="(payment_method_name, payment_method_gateway) in available_payment_methods">
                        <label class="relative flex flex-col items-center bg-white rounded-lg border shadow-sm p-3 cursor-pointer focus:outline-none mb-0"
                            :class="{'!border-2 !border-primary ':payment_method_gateway === selected_payment_method  , 'border-gray-300':payment_method_gateway !== selected_payment_method}"
                            @click="clearErrors(); selected_payment_method = payment_method_gateway; ">

                            <template x-if="payment_method_gateway === 'wire_transfer'">
                                @svg('lineawesome-university-solid', ['class' => 'w-[60px] h-[60px]'])
                            </template>
                            <template x-if="payment_method_gateway === 'paypal'">
                                @svg('lineawesome-cc-paypal', ['class' => 'w-[60px] h-[60px]'])
                            </template>
                            <template x-if="payment_method_gateway === 'stripe'">
                                @svg('lineawesome-cc-stripe', ['class' => 'w-[60px] h-[60px]'])
                            </template>
                            <template x-if="payment_method_gateway === 'paysera'">
                                @svg('lineawesome-money-bill-wave-solid', ['class' => 'w-[60px] h-[60px]'])
                            </template>

                            {{-- <img class="img-fluid w-[60px]" x-bind:src="'{{ static_assets_root(path:'images', theme: true) }}/'+payment_method_gateway.replace('_','-')+'-logo-transparent.png'" alt="SVG" > --}}

                            {{-- @svg('heroicon-s-check-circle', ['class' => 'h-5 w-5 text-indigo-600 absolute top-[7px] right-[7px]', ':class' => '{\'hidden\': payment_method_name !== selected_payment_method}']) --}}

                            <p class="w-full text-center text-12" x-text="payment_method_name"></p>

                            <div class="absolute -inset-px rounded-lg border-2 pointer-events-none" aria-hidden="true"
                                :class="{ 'border border-primary': (payment_method_gateway === selected_payment_method), 'border-2 border-transparent': (payment_method_gateway !==selected_payment_method) }">
                            </div>
                        </label>
                    </template>
                </fieldset>

                <input type="hidden" name="selected_payment_method" x-model="selected_payment_method">

                <template x-if="selected_payment_method != ''">
                    <div class="payment-methods-details w-full mt-3">
                        @foreach(\Payments::getPaymentMethods() as $payment_method)
                        <div class="border border-gray-200 rounded-lg shadow text-12 p-3" :class="{'hidden': selected_payment_method !== '{{ $payment_method->gateway }}'}">
                            <div class="w-full">
                                {!! $payment_method->description !!}
                            </div>

                            @if($payment_method->gateway === 'stripe')
                                <div class="w-full">
                                    <div class="w-full mb-2">
                                        <label for="cc_name" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                                            {{ translate('Name on card') }}
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <input name="cc_name"
                                                id="cc_name"
                                                type="text"
                                                x-model="cc_name"
                                                class="form-standard @error('cc_name') is-invalid @enderror"
                                        />

                                        <x-system.invalid-msg field="cc_name" ></x-system.invalid-msg>
                                    </div>

                                    <div class="w-full mb-2">
                                        <label for="cc_number" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                                            {{ translate('Card number') }}
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <input name="cc_number"
                                                id="cc_number"
                                                type="number"
                                                x-model="cc_number"
                                                class="form-standard @error('cc_number') is-invalid @enderror"
                                        />

                                        <x-system.invalid-msg field="cc_number" ></x-system.invalid-msg>
                                    </div>

                                    <div class="w-full grid grid-cols-2 gap-4">
                                        <div x-data="{
                                            formatString(e) {
                                                var inputChar = String.fromCharCode(event.keyCode);
                                                var code = event.keyCode;
                                                var allowedKeys = [8];
                                                if (allowedKeys.indexOf(code) !== -1) {
                                                    return;
                                                }

                                                event.target.value = event.target.value.replace(
                                                    /^([1-9]\/|[2-9])$/g, '0$1/' // 3 > 03/
                                                ).replace(
                                                    /^(0[1-9]|1[0-2])$/g, '$1/' // 11 > 11/
                                                ).replace(
                                                    /^([0-1])([3-9])$/g, '0$1/$2' // 13 > 01/3
                                                ).replace(
                                                    /^(0?[1-9]|1[0-2])([0-9]{2})$/g, '$1/$2' // 141 > 01/41
                                                ).replace(
                                                    /^([0]+)\/|[0]+$/g, '0' // 0/ > 0 and 00 > 0
                                                ).replace(
                                                    /[^\d\/]|^[\/]*$/g, '' // To allow only digits and `/`
                                                ).replace(
                                                    /\/\//g, '/' // Prevent entering more than 1 `/`
                                                );
                                            }
                                        }"
                                        >
                                            <label for="cc_expiration_date" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                                                {{ translate('Expiration date') }}
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <input name="cc_expiration_date"
                                                    type="text"
                                                    id="cc_expiration_date"
                                                    x-model.defer="cc_expiration_date"
                                                    placeholder="MM/YY"
                                                    maxlength="5"
                                                    @keyup="formatString(event)"
                                                    class="form-standard @error('cc_expiration_date') is-invalid @enderror"
                                            />

                                            <x-system.invalid-msg field="cc_expiration_date" ></x-system.invalid-msg>
                                        </div>

                                        <div class="">
                                            <label for="cc_cvc" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                                                {{ translate('CVC') }}
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <input name="cc_cvc"
                                                    id="cc_cvc"
                                                    x-model="cc_cvc"
                                                    pattern="\d*"
                                                    maxlength="4"
                                                    type="number"
                                                    min="0"
                                                    class="form-standard @error('cc_cvc') is-invalid @enderror"
                                            />

                                            <x-system.invalid-msg field="cc_cvc" ></x-system.invalid-msg>
                                        </div>
                                        <!-- End Col -->
                                    </div>
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </template>
            </div>

            <hr class="mt-4" />

            <div class="flex flex-col mt-3">
                {{-- Newletter --}}
                <div class="flex items-center cursor-pointer">
                    <input type="checkbox" class="form-checkbox-standard" id="checkout_newsletter" name="checkout_newsletter"
                        wire:model.defer="checkout_newsletter">
                    <div class="ml-2">
                        <label for="checkout_newsletter" class="text-12 font-medium text-gray-500 mb-0 cursor-pointer">
                            {{ translate('Please send me emails with exclusive info') }}
                        </label>
                    </div>
                </div>
                {{-- END Newletter --}}

                <!-- Consent -->
                <div class="mb-2">
                    <div class="flex items-center cursor-pointer">
                        <input type="checkbox" class="form-checkbox-standard" id="buyers_consent" name="order.buyers_consent"
                                x-model="buyers_consent">
                        <div class="ml-2">
                            <label for="buyers_consent" class="text-12 font-medium mb-0 cursor-pointer underline decoration-solid decoration-red-500 decoration-1 underline-offset-2 @error('order.buyers_consent') text-red-600 @else text-gray-500 @enderror">
                                {{ translate('By placing an order, I agree to ') }}
                                {{ \TenantSettings::get('site_name') }}
                                <a href="#" target="_blank">{{ translate('terms of sale') }}</a>
                            </label>
                        </div>
                    </div>

                    <x-system.invalid-msg field="order.buyers_consent" ></x-system.invalid-msg>
                </div>
                <!-- End Consent -->
            </div>


            <div class="mt-4">
                <button class="btn-primary text-center justify-center w-full bg-red-500 text-white"
                        @click="save()"
                        wire:click="requestQuote()"
                        wire:loading.class="bg-gray-100 text-gray-900 pointer-events-none">
                    <span wire:loading.class="hidden">{{ translate('Request a quote') }}</span>
                    @svg('lineawesome-spinner-solid', ['class'=> 'hidden w-[20px] h-[20px] animate-spin text-gray-900', 'wire:loading.class.remove' => 'hidden', 'wire:loading.class' => 'inline'])
                </button>
            </div>
        </div>
    </div>
</div>
