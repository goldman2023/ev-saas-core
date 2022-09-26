<div class="w-full" x-data="{
    use_serial: {{ $product->use_serial === true ? 'true' : 'false' }},
    allow_out_of_stock_purchases: {{ $product->allow_out_of_stock_purchases === true ? 'true' : 'false' }},
    stock_visibility_state: @js($product->stock_visibility_state ?? 'quantity'),
}">

    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                            wire:target="updateMainStock"
                            wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full"
            wire:loading.class="opacity-30 pointer-events-none"
            wire:target="updateMainStock"
        >

            <div class="grid grid-cols-12 gap-8 mb-10">

                {{-- Left panel --}}
                <div class="col-span-12 md:col-span-8  ">
                    {{-- Main Stock Management--}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div class="w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-1">{{ translate('Main Stock Management') }}</h3>
                            <p class="flex items-center-1 max-w-2xl text-sm text-gray-500">
                                {{ translate('You are currently editing').' ' }}
                                <a href="{{ route('product.details', ['id' => $product->id]) }}" target="_blank" class="badge-info mx-1">{{ $product->name }}</a>
                                {{ translate('main stock options') }}
                            </p>
                        </div>

                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">
                            {{-- SKU --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('SKU') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" class="form-standard @error('product.sku') is-invalid @enderror"
                                            placeholder="{{ translate('Product SKU') }}"
                                            wire:model.defer="product.sku" />

                                    <small class="text-muted">{{ translate('Leave empty if you want to add only SKU of the variations.') }}</small>

                                    <x-system.invalid-msg field="product.sku"></x-system.invalid-msg>
                                </div>
                            </div>
                            {{-- END SKU --}}

                            {{-- Barcode --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Barcode') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" class="form-standard @error('product.barcode') is-invalid @enderror"
                                            placeholder="{{ translate('Product barcode') }}"
                                            wire:model.defer="product.barcode" />

                                    <small class="text-muted">{{ translate('Leave empty if you want to add only Barcode of the variations.') }}</small>

                                    <x-system.invalid-msg field="product.barcode"></x-system.invalid-msg>
                                </div>
                            </div>
                            {{-- END Barcode --}}

                            {{-- Use serial numbers --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 " x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Uses serial numbers?') }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="use_serial = !use_serial"
                                                :class="{'bg-primary':use_serial, 'bg-gray-200':!use_serial}"
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                            <span :class="{'translate-x-5':use_serial, 'translate-x-0':!use_serial}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>
                            {{-- END Use serial numbers --}}

                            {{-- Allow out of stock purchases --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 " x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Allow selling even when out of stock?') }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="allow_out_of_stock_purchases = !allow_out_of_stock_purchases"
                                                :class="{'bg-primary':allow_out_of_stock_purchases, 'bg-gray-200':!allow_out_of_stock_purchases}"
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                            <span :class="{'translate-x-5':allow_out_of_stock_purchases, 'translate-x-0':!allow_out_of_stock_purchases}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>
                            {{-- END Allow out of stock purchases --}}

                            <div class="w-full" x-show="!use_serial">
                                <!-- Minimum quantity user can purchase -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Minimum quantity user can purchase') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <div class="grid grid-cols-10 gap-3">
                                            <div class="col-span-6">
                                                <input type="number"
                                                        step="0.01"
                                                        class="form-standard @error('product.min_qty') is-invalid @enderror"
                                                        placeholder="{{ translate('0.00') }}"
                                                        wire:model.defer="product.min_qty" />
                                            </div>

                                            <x-system.invalid-msg class="col-span-10" field="product.min_qty"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Minimum quantity user can purchase -->

                                <!-- Stock quantity -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4">
                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Stock quantity') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <div class="grid grid-cols-10 gap-3">
                                            <div class="col-span-6">
                                                <input type="number"
                                                        step="0.01"
                                                        class="form-standard @error('product.current_stock') is-invalid @enderror"
                                                        placeholder="{{ translate('0.00') }}"
                                                        wire:model.defer="product.current_stock" />
                                            </div>

                                            <x-system.invalid-msg class="col-span-10" field="product.current_stock"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Stock quantity -->
                            </div>

                            {{-- Unit --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Unit') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="grid grid-cols-10 gap-3">
                                        <div class="col-span-6">
                                            <input type="text" class="form-standard @error('product.unit') is-invalid @enderror"
                                            placeholder="{{ translate('Product unit') }}"
                                            wire:model.defer="product.unit" />
                                        </div>

                                        <x-system.invalid-msg class="col-span-10"  field="product.unit"></x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                            {{-- END Unit --}}

                            {{-- Stock Visibility State (Should override value from shop_settings, otherwise it should be the same) --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Stock visibility state') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2 flex flex-col rounded-md shadow-sm ">
                                    <template x-for="(value, key) in @js(\App\Enums\StockVisibilityStateEnum::labels())">
                                        <div class="relative flex items-center mb-3">
                                            <div class="flex items-center h-6">
                                              <input
                                                    type="radio"
                                                    x-model="stock_visibility_state"
                                                    :value="value"
                                                    :id="'stock_visibility_state_'+key"
                                                    class="form-radio-standard">
                                            </div>
                                            <div class="ml-3 text-sm">
                                              <label class="font-medium text-gray-700 cursor-pointer" x-text="value" :for="'stock_visibility_state_'+key"></label>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            {{-- END Stock Visibility State --}}

                        </div>

                    </div>
                    {{-- END Main Stock Management --}}

                    {{-- Main stock Serial Numbers --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5" x-show="use_serial" x-cloak>
                        <div class="w-full flex justify-between items-center">
                            <div class="shrink-0">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-1">{{ translate('Serial numbers') }}</h3>
                                <p class="flex items-center-1 max-w-2xl text-sm text-gray-500">
                                    {{ translate('You are currently editing').' ' }}
                                    <a href="{{ route('product.details', ['id' => $product->id]) }}" target="_blank" class="badge-info mx-1">{{ $product->name }}</a>
                                    {{ translate('main product serial numbers') }}
                                </p>
                            </div>
                            <div class="grow-0">
                                <button type="button" class="btn-primary" @click="$dispatch('modal-show', {'id': 'serial-number-form-modal', 'serial_number_id': null})">
                                    {{-- @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2']) --}}
                                    <span>{{ translate('Add new') }}</span>
                                </button>
                            </div>
                        </div>

                        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                            {{-- Serial Numbers Table --}}
                            <livewire:dashboard.tables.product-serial-numbers-table :product="$product"></livewire:dashboard.tables.product-serial-numbers-table>
                            {{-- END Serial Numbers Table --}}

                            <div class="w-full mt-4">
                                {{-- Serial Numbers Stats --}}
                                <div class="flex items-center border border-gray-200 rounded px-3 py-2 mt-3">
                                    @php
                                        $serial_stats = $this->product->getSerialNumbersStockStats();
                                    @endphp
                                    <div class="flex items-center mr-2 text-14">
                                        <span class="mr-2 flex items-center ">
                                            <svg class="mr-2 h-2 w-2 text-success" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            {{ translate('In stock:') }}
                                        </span>
                                        <span>{{ $serial_stats['in_stock'] }}</span>
                                    </div>

                                    <div class=" flex items-center pl-2 mr-2 text-14">
                                        <span class="mr-2 flex items-center ">
                                            <svg class="mr-2 h-2 w-2 text-danger" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            {{ translate('Out of stock:') }}
                                        </span>
                                        <span>{{ $serial_stats['out_of_stock'] }}</span>
                                    </div>

                                    <div class=" flex items-center pl-2 mr-2 text-14">
                                        <span class="mr-2 flex items-center ">
                                            <svg class="mr-2 h-2 w-2 text-warning" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            {{ translate('Reserved:') }}
                                        </span>
                                        <span>{{ $serial_stats['reserved'] }}</span>
                                    </div>

                                    <div class=" flex items-center pl-2 mr-2 text-14">
                                        <span class="mr-2 flex items-center ">
                                            <svg class="mr-2 h-2 w-2 text-gray-900" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            {{ translate('Total:') }}
                                        </span>
                                        <span>{{ $serial_stats['total'] }}</span>
                                    </div>

                                    <div class=" flex items-center pl-2 ml-auto text-14">
                                        <span class="mr-2 flex items-center ">
                                            @svg('heroicon-s-trash', ['class' => 'mr-2 w-[14px] h-[14px]'])
                                            {{ translate('Trashed:') }}
                                        </span>
                                        <span>{{ $serial_stats['trashed'] }}</span>
                                    </div>
                                </div>
                                {{-- END Serial Numbers Stats --}}
                            </div>
                        </div>
                    </div>
                    {{-- END Main stock Serial Numbers --}}
                </div>
                {{-- END Left panel --}}


            </div>
        </div>
    </div>

    <livewire:dashboard.forms.serial-numbers.serial-number-form-modal :product="$product"></livewire:dashboard.forms.serial-numbers.serial-number-form-modal>


    <!-- Product Variations CARD -->
    @if($product->useVariations() && $product->hasVariations())
    <div class="card container-fluid py-3 mt-3">
        <div class="card-header pl-2">
            <h5 class="card-header-title">{{ translate('Product Variations Stocks') }}</h5>
        </div>

        <div class="card-body px-0">
            <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                                  wire:target="status"
                                  wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

            <div class="container-fluid" wire:loading.class="opacity-3">
                <div id="serialNumbersDatatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <div class="row border-bottom mb-4 py-3" style="background-color: #f8fafd;">
                        <div class="col-3 table-th-cell">{{ translate('Name') }}</div>
                        <div class="col-2 table-th-cell">{{ translate('Current Qty') }}</div>
                        <div class="col-2 table-th-cell">{{ translate('Low stock qty') }}</div>
                        <div class="col-5 table-th-cell">{{ translate('SKU') }}</div>
                    </div>

                    @if($variations)
                        @foreach($variations as $key => $variation)
                            <div class="row mb-3">
                                <div class="col-3 d-flex align-items-center">
                                    <strong style="max-width: 150px; overflow: hidden; whitespace:nowrap;">{{ $variation->getVariantName(attributes: $attributes, slugified: false, value_separator: ' | ') }}</strong>
                                </div>
                                <div class="col-2 d-flex align-items-center">
                                    <x-ev.form.input groupclass="mb-0" name="variations.{{ $key }}.current_stock" :quantity_counter="true" type="number" :required="true" min="0" step="1">
                                    </x-ev.form.input>
                                </div>
                                <div class="col-2 d-flex align-items-center">
                                    <x-ev.form.input groupclass="mb-0" name="variations.{{ $key }}.low_stock_qty" :quantity_counter="true" type="number" :required="true"  min="0" step="1">
                                    </x-ev.form.input>
                                </div>
                                <div class="col-5 d-flex align-items-center">
                                    <x-ev.form.input groupclass="w-100 mb-0" name="variations.{{ $key }}.sku" type="text" :required="true"> </x-ev.form.input>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="d-flex flex-row align-items-center">
                    <a href="javascript:;" class="btn btn-sm btn-no-focus btn-primary align-items-center ml-auto mt-0 save-btn"
                       wire:click="updateVariationsStocks()">
                        <span>{{ translate('Save') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
