<div class="w-full" x-data="{
    type: @js($order->type ?? \App\Enums\OrderTypeEnum::standard()->value),
    payment_status: @js($order->payment_status ?? \App\Enums\PaymentStatusEnum::unpaid()->value),
    shipping_status: @js($order->shipping_status ?? \App\Enums\ShippingStatusEnum::not_sent()->value),
    shop_id: @js($order->shop_id),
    user_id: @js($order->user_id),
    billing_country: @js($order->billing_country),
    shipping_country: @js($order->shipping_country),
    same_billing_shipping: @js($order->same_billing_shipping),
    save() {
        $wire.set('order.type', type, true);
        $wire.set('order.payment_status', payment_status, true);
        $wire.set('order.shipping_status', shipping_status, true);

        @do_action('view.order-form.wire_set');
    }
}"
@validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
@init-form.window="features = features.filter(x => x).filter(x => true);"
x-cloak>
    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                              wire:target="savePlan"
                              wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full"
             wire:loading.class="opacity-30 pointer-events-none"
             wire:target="saveOrder"
        >

            <div class="grid grid-cols-12 gap-8 mb-10">
                {{-- Left side --}}
                <div class="col-span-12 sm:col-span-8">
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
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
                                            image_src: '{{ \IMG::getPlaceholder(proxify: false)['url'] ?? '' }}',
                                            shop_title: @js(translate('Vendor not selected')),
                                            subtitle: @js(translate('Please select vendor by clicking this button')),
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
                                            image_src: '{{ \IMG::getPlaceholder(proxify: false)['url'] ?? '' }}',
                                            customer_title: @js(translate('Customer not selected')),
                                            subtitle: @js(translate('Please select customer by clicking this button')),
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

                            <!-- Payment Status -->
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
                            <!-- END Payment Status -->

                            <div class="w-full flex justify-between sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                                <button type="button" class="btn btn-primary ml-auto btn-sm" @click="save()" wire:click="saveOrder()" >
                                    {{ translate('Save') }}
                                </button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>