<div class="w-full" x-data="{
    type: @js($order->type ?? \App\Enums\OrderTypeEnum::standard()->value),
    payment_status: @js($order->payment_status ?? \App\Enums\PaymentStatusEnum::unpaid()->value),
    shipping_status: @js($order->shipping_status ?? \App\Enums\ShippingStatusEnum::not_sent()->value),
    shop_id: @js($order->shop_id),
    user_id: @js($order->user_id),
    billing_country: @js($order->billing_country),
    shipping_country: @js($order->shipping_country),
    same_billing_shipping: @js($order->same_billing_shipping === true ? true : false),
    order_items: @js($order_items ?? []),
    tax: @js($order->tax ?? 0),
    shipping_cost: @js($hideShipping ? 0 : ($order->shipping_cost ?? 0)),
    email: @js($order->email),
    core_meta: @js($core_meta),

    subtotal: 0,
    total: 0,
    calculateTotals() {
        this.tax = Number(this.tax);

        if(this.order_items) {
            this.subtotal = 0;

            this.order_items.forEach((item, index) => {
                this.subtotal += item.total_price;
            });
        } else {
            this.subtotal = 0;
        }

        if(this.tax < 0 || this.tax > 100) {
            this.tax = 0;
        }

        this.total = Number(this.subtotal) + Number(this.shipping_cost);
        this.total += this.total * this.tax / 100;
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
        $wire.set('order_items', this.order_items, true);
        $wire.set('core_meta', this.core_meta, true);

        @do_action('view.order-form.wire_set');
    },
}"
@validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
@init-form.window=""
x-init="$watch('order_items', order_items => {
    order_items.forEach((item, index) => {
        order_items[index].base_price = Number(order_items[index].unit_price);
        order_items[index].subtotal_price = Number(order_items[index].qty) * order_items[index].unit_price;
        order_items[index].total_price = Number(order_items[index].qty) * order_items[index].unit_price;
    });
    calculateTotals();
});
$watch('tax', order_items => calculateTotals());
$watch('shipping_cost', order_items => calculateTotals());
calculateTotals();
"
x-cloak>
    <div class="w-full relative">
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
                                <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Vendor') }}
                                    </label>

                                    <div class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400"
                                        x-data="{
                                            image_src: '{{ $order->shop?->getThumbnail() ?? \IMG::getPlaceholder(proxify: false)['url'] ?? '' }}',
                                            shop_title: @js($order->shop?->name ?? translate('Vendor not selected')),
                                            subtitle: @js($order->shop?->excerpt ?? translate('Please select vendor by clicking this button')),
                                        }"
                                        @click="$dispatch('display-modal', {'id': 'vendor-selector-modal' })">
                                        <div class="flex-shrink-0">
                                          <img class="h-10 w-10 rounded-full" :src="image_src" alt="">
                                        </div>
                                        <div class="min-w-0 flex-1">
                                          <div class="focus:outline-none cursor-pointer">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            <p class="text-sm font-medium text-gray-900" x-text="shop_title"></p>
                                            <p class="truncate text-sm text-gray-500" x-text="subtitle"></p>
                                          </div>
                                        </div>

                                        <x-system.form-modal id="vendor-selector-modal" title="Select Vendor" class="!max-w-lg">
                                            <div class="w-full flex flex-col" x-data="{
                                                q: '',
                                                results: [],
                                                search() {
                                                    wetch.get('{{ route('api.dashboard.shops.search') }}?q='+this.q)
                                                    .then(data => {
                                                        if(data.status === 'success' && data.results) {
                                                            this.results = data.results;
                                                        }
                                                    })
                                                    .catch(error => {
                                                        alert(error);
                                                    });
                                                },
                                                reset() {
                                                    this.q = '';
                                                    this.results = null;
                                                },
                                                select(item) {
                                                    try {
                                                        shop_id = item?.id;
                                                        shop_title = item?.name;
                                                        subtitle = item?.slug;
                                                        image_src = window.WE.IMG.url(item.thumbnail?.file_name);
                                                    } catch(error) {
                                                        console.log(error);
                                                    }
                                                }
                                            }">
                                                <div class="w-full pb-3 mb-3">
                                                    <label for="search" class="block text-sm font-medium text-gray-700">{{ translate('Search vendors') }}</label>
                                                    <div class="relative mt-1 flex items-center">
                                                        <input type="text"class="form-standard pr-12" x-model="q">
                                                        <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5" >
                                                            <kbd class="inline-flex items-center rounded border border-gray-200 px-2 font-sans text-sm font-medium text-gray-400 cursor-pointer"
                                                                @click="search()">
                                                                {{ translate('Search') }}
                                                            </kbd>
                                                        </div>
                                                    </div>
                                                </div>

                                                <template x-if="results">
                                                    <div class="w-full mt-3">
                                                        <ul role="list" class="-my-5 divide-y divide-gray-200">
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
                                        </x-system.form-modal>
                                    </div>
                                </div>
                                {{-- END Vendor/Shop --}}

                                {{-- Customer --}}
                                <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Customer') }}
                                    </label>

                                    <div class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400"
                                        x-data="{
                                            image_src: '{{ $order->user?->getThumbnail() ?? \IMG::getPlaceholder(proxify: false)['url'] ?? '' }}',
                                            customer_title: @js($order->user?->name ?? translate('Customer not selected')),
                                            subtitle: @js($order->user?->email ?? translate('Please select customer by clicking this button')),
                                        }"
                                        @click="$dispatch('display-modal', {'id': 'customer-selector-modal' })">
                                        <div class="flex-shrink-0">
                                          <img class="h-10 w-10 rounded-full" :src="image_src" alt="">
                                        </div>
                                        <div class="min-w-0 flex-1">
                                          <div href="#" class="focus:outline-none cursor-pointer">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            <p class="text-sm font-medium text-gray-900" x-text="customer_title"></p>
                                            <p class="truncate text-sm text-gray-500" x-text="subtitle"></p>
                                          </div>
                                        </div>

                                        <x-system.form-modal id="customer-selector-modal" title="Select Customer" class="!max-w-lg">
                                            <div class="w-full flex flex-col" x-data="{
                                                q: '',
                                                results: [],
                                                search() {
                                                    wetch.get('{{ route('api.dashboard.users.search') }}?q='+this.q)
                                                    .then(data => {
                                                        if(data.status === 'success' && data.results) {
                                                            this.results = data.results;
                                                        }
                                                    })
                                                    .catch(error => {
                                                        alert(error);
                                                    });
                                                },
                                                reset() {
                                                    this.q = '';
                                                    this.results = null;
                                                },
                                                select(item) {
                                                    try {
                                                        user_id = item?.id;
                                                        email = item?.email;
                                                        customer_title = item?.name;
                                                        subtitle = item?.email;
                                                        image_src = window.WE.IMG.url(item.thumbnail?.file_name);
                                                    } catch(error) {
                                                        console.log(error);
                                                    }
                                                }
                                            }">
                                                <div class="w-full pb-3 mb-3">
                                                    <label for="search" class="block text-sm font-medium text-gray-700">{{ translate('Search customers') }}</label>
                                                    <div class="relative mt-1 flex items-center">
                                                        <input type="text"class="form-standard pr-12" x-model="q">
                                                        <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5" >
                                                            <kbd class="inline-flex items-center rounded border border-gray-200 px-2 font-sans text-sm font-medium text-gray-400 cursor-pointer"
                                                                @click="search()">
                                                                {{ translate('Search') }}
                                                            </kbd>
                                                        </div>
                                                    </div>
                                                </div>

                                                <template x-if="results">
                                                    <div class="w-full mt-3">
                                                        <ul role="list" class="-my-5 divide-y divide-gray-200">
                                                            <template x-for="item in results">
                                                                <li class="py-4">
                                                                    <div class="flex items-center space-x-4">
                                                                      <div class="flex-shrink-0">
                                                                        <img class="h-8 w-8 rounded-full" :src="window.WE.IMG.url(item.thumbnail?.file_name)" alt="">
                                                                      </div>
                                                                      <div class="min-w-0 flex-1">
                                                                        <p class="truncate text-sm font-medium text-gray-900" x-text="item.name"></p>
                                                                        <p class="truncate text-sm text-gray-500" x-text="item.email"></p>
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
                                        </x-system.form-modal>
                                    </div>
                                </div>
                                {{-- END Customer --}}

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

                                    <div class="grid grid-cols-12 gap-x-3">
                                        <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                {{ translate('Billing First Name') }}
                                            </label>

                                            <x-dashboard.form.input field="order.billing_first_name" />
                                        </div>

                                        <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                {{ translate('Billing Last Name') }}
                                            </label>

                                            <x-dashboard.form.input field="order.billing_last_name" />
                                        </div>
                                    </div>

                                    <div class="w-full flex flex-col gap-y-2">
                                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            {{ translate('Billing Address') }}
                                        </label>

                                        <x-dashboard.form.input field="order.billing_address" />
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

                                            <x-dashboard.form.input field="order.billing_state" />
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-12 gap-x-3">
                                        <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                {{ translate('Billing City') }}
                                            </label>

                                            <x-dashboard.form.input field="order.billing_city" />
                                        </div>

                                        <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                {{ translate('Billing ZIP') }}
                                            </label>

                                            <x-dashboard.form.input field="order.billing_zip" />
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

                                                <x-dashboard.form.input field="order.shipping_first_name" />
                                            </div>

                                            <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    {{ translate('Shipping Last Name') }}
                                                </label>

                                                <x-dashboard.form.input field="order.shipping_last_name" />
                                            </div>
                                        </div>

                                        <div class="w-full flex flex-col gap-y-2">
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                {{ translate('Shipping Address') }}
                                            </label>

                                            <x-dashboard.form.input field="order.shipping_address" />
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

                                                <x-dashboard.form.input field="order.shipping_state" />
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-12 gap-x-3">
                                            <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    {{ translate('Shipping City') }}
                                                </label>

                                                <x-dashboard.form.input field="order.shipping_city" />
                                            </div>

                                            <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    {{ translate('Shipping ZIP') }}
                                                </label>

                                                <x-dashboard.form.input field="order.shipping_zip" />
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

                    {{-- Order Items --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div class="w-full pb-4 mb-4 border-b ">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ translate('Order Items') }}
                                <span x-text="'('+_.get(order_items, 'length', 0)+')'"></span>
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Here you can specify all items included in the order') }}</p>
                        </div>

                        <div class="w-full flex flex-col">
                            <template x-if="_.get(order_items, 'length', 0) > 0">
                                <ul class="w-full flex flex-col gap-y-4">
                                    <template x-for="item,index in order_items">
                                        <li class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm "
                                            x-data="{}">
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
                                            <div class="flex-shrink-0 flex items-center " @click="order_items.splice(index, 1);">
                                                @svg('heroicon-s-x', ['class' => 'w-5 h-5 text-danger cursor-pointer'])
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </template>

                            <template x-if="_.get(order_items, 'length', 0) <= 0">
                                <div class="text-center py-2 cursor-pointer" @click="$dispatch('display-modal', {'id': 'order-item-selector-modal' })">
                                    @svg('heroicon-o-plus-circle', ['class' => 'mx-auto h-12 w-12 text-gray-400'])
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">{{ translate('No order items') }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ translate('Start by adding new item to the order') }}</p>
                                </div>
                            </template>

                            <div class="w-full flex pt-4 mt-4 border-t">
                                <button type="button" class="btn btn-primary btn-sm" @click="$dispatch('display-modal', {'id': 'order-item-selector-modal' })" >
                                    {{ translate('Add new item') }}
                                </button>
                            </div>

                            <x-system.form-modal id="order-item-selector-modal" title="Add New Order Item" class="!max-w-xl">
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
                                    custom_order_item: {
                                        name: '',
                                        excerpt: '',
                                        qty: 1,
                                        unit_price: 0,
                                        base_price: 0,
                                        subtotal_price: 0,
                                        total_price: 0,
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
                                        this.custom_order_item = {
                                            name: '',
                                            excerpt: '',
                                            qty: 1,
                                            unit_price: 0,
                                            base_price: 0,
                                            subtotal_price: 0,
                                            total_price: 0,
                                        };
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
                                            });
                                        }
                                    },
                                    selectContentType(content_type) {
                                        this.content_type = content_type;
                                    },
                                    insertCustomOrderItem() {
                                        this.custom_order_item.base_price = Number(this.custom_order_item.unit_price);
                                        this.custom_order_item.subtotal_price = Number(this.custom_order_item.qty) * this.custom_order_item.unit_price;
                                        this.custom_order_item.total_price = Number(this.custom_order_item.qty) * this.custom_order_item.unit_price;

                                        order_items.push(this.custom_order_item);
                                        this.reset();
                                    }
                                }">
                                    <div class="w-full">
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
                                        <div class="w-full pt-3 mt-5 border-t">
                                            <div class="w-full pb-3 mb-3">
                                                <label for="search" class="block text-sm font-medium text-gray-700">{{ translate('Search') }}</label>
                                                <div class="relative mt-1 flex items-center">
                                                    <input type="text"class="form-standard pr-12" x-model="q">
                                                    <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5" >
                                                        <kbd class="inline-flex items-center rounded border border-gray-200 px-2 font-sans text-sm font-medium text-gray-400 cursor-pointer"
                                                            @click="search()">
                                                            {{ translate('Search') }}
                                                        </kbd>
                                                    </div>
                                                </div>
                                            </div>

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

                                            {{-- <template x-if="!results">

                                            </template> --}}
                                        </div>
                                    </template>

                                    <template x-if="content_type == 'custom'">
                                        <div class="w-full pt-3 mt-5 border-t">
                                            <div class="grid grid-cols-12 gap-x-3">
                                                <div class="col-span-12 flex-col gap-y-2">
                                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                        {{ translate('Name') }}
                                                    </label>

                                                    <div class="w-full ">
                                                        <input type="text" class="form-standard  " x-model="custom_order_item.name">
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

                                                <div class="col-span-12 flex justify-between sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                                                    <button type="button" class="btn btn-primary ml-auto btn-sm" @click="insertCustomOrderItem()" >
                                                        {{ translate('Add Custom Item') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                </div>
                            </x-system.form-modal>
                        </div>
                    </div>
                    {{-- END Order Items --}}
                </div>

                {{-- Right side --}}
                <div class="col-span-12 sm:col-span-4">
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div class="w-full flex items-center justify-between border-b border-gray-200 pb-3 mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Actions') }}</h3>
                        </div>

                        <div class="w-full">
                            <!-- Type -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
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
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                                <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
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
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                                    <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
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
                            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:pt-5">
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
                                    <button type="button" class="btn btn-warning btn-sm" wire:click="generateOrder()" >
                                        {{ translate('Generate Invoice') }}
                                    </button>
                                @endif

                                <button type="button" class="btn btn-primary ml-auto btn-sm" @click="save()" wire:click="saveOrder()" >
                                    {{ translate('Save') }}
                                </button>
                            </div>
                        </div>

                    <x-dashboard.form.blocks.core-meta-form></x-dashboard.form.blocks.core-meta-form>


                    </div>

                    {{-- Order Summary --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-7">
                        <div class="w-full flex items-center justify-between border-b border-gray-200 pb-3 mb-3">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Order Summary') }}</h3>
                        </div>

                        <div class="w-full flex flex-col">
                            <template x-if="order_items">
                                <ul class="w-full flex flex-col gap-y-2">
                                    <template x-for="item in order_items">
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
                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 pt-2">
                                    <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">{{ translate('Tax(percent)') }}</label>
                                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                                        {{ get_tenant_setting('company_tax_rate') }}
                                        <x-dashboard.form.input type="number" value="21" field="tax" :x="get_tenant_setting('company_tax_rate')" min="0" max="100" />
                                    </div>
                                </div>
                                {{-- END TAX --}}
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
                                      <dd class="text-gray-900" x-text="FX.formatPrice((subtotal + shipping_cost) * tax / 100)"></dd>
                                    </div>

                                    <div class="flex items-center justify-between border-t border-gray-200 pt-4 text-gray-900">
                                      <dt class="text-base">{{ translate('Total') }}</dt>
                                      <dd class="text-base" x-text="FX.formatPrice(total)"></dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                    {{-- END Order Summary --}}

                </div>
            </div>

        </div>
    </div>
</div>
