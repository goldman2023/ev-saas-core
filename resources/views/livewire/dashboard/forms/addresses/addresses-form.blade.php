<div @if(!empty($componentId)) id="{{ $componentId }}" @endif class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5" x-data="{
        currentAddressCountry: @entangle('currentAddress.country').defer,
        currentAddressPhones: @entangle('currentAddress.phones').defer,
        currentAddress_is_primary: @entangle('currentAddress.is_primary').defer,
        currentAddress_is_billing: @entangle('currentAddress.is_billing').defer,
        addresses: @entangle('addresses'),
        available_features: @js(\App\Models\ShopAddress::getAvailableFeatures()),
    }" @display-address-panel.window="$dispatch('display-flyout-panel', {'id': 'address-panel'});">
    <div class="w-full flex justify-between items-center border-b border-gray-200 mb-3 pb-3">
        <div class="shrink-0">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-1">{{ translate('Addresses') }}</h3>
            <p class="flex items-center-1 max-w-2xl text-sm text-gray-500"> {{ translate('Add one or multiple addresses to your account') }}</p>
        </div>
        <div class="grow-0">
            <button type="button" class="btn-primary" wire:click="initNewAddress()" @click="$dispatch('display-flyout-panel', {'id': 'address-panel'});">
                {{-- @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2']) --}}
                <span>{{ translate('Add new') }}</span>
            </button>
        </div>
    </div>

    <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5 pb-2">
        @if($addresses->isNotEmpty())
            <ul role="list" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($addresses as $key => $address)
                    <li class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200  border border-gray-200">
                        <div class="w-full flex items-center justify-between p-6 space-x-6">
                            <div class="flex-1 truncate">
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-gray-900 text-sm font-medium truncate">{{ $address->address }}, {{ $address->city }}</h3>
                                    @if($address->is_primary)
                                        <span class="badge-success !text-green-800 !bg-green-100">
                                            {{ translate('Primary') }}
                                        </span>
                                    @endif
                                    @if($address->is_billing)
                                        <span class="badge-info !text-sky-800 !bg-sky-100">
                                            {{ translate('Billing') }}
                                        </span>
                                    @endif
                                </div>
                                <p class="mt-1 text-gray-500 text-sm truncate">{{ \Countries::get(code: $address->country)->name ?? translate('Unknown') }}, {{ $address->zip_code }}</p>
                            </div>
                        </div>
                        <div>
                            <div class="-mt-px flex divide-x divide-gray-200">
                                <div class="w-0 flex-1 flex">
                                    <button wire:click="removeAddress({{ $address->id }})" class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm bg-danger text-white font-medium border border-transparent rounded-bl-lg">
                                        @svg('heroicon-o-trash', ['class' => 'w-5 h-5 text-white'])
                                        <span class="ml-3">{{ translate('Remove') }}</span>
                                    </button>
                                </div>
                                <div class="-ml-px w-0 flex-1 flex">
                                    <button wire:click="changeCurrentAddress({{ $key }})" class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                                        @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
                                        <span class="ml-3">{{ translate('Edit') }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <x-dashboard.empty-states.no-items-in-collection 
                icon="heroicon-o-home" 
                title="{{ translate('No addresses yet') }}" 
                text="{{ translate('Add address(es) for easier checkout!') }}"
                {{-- link-href-route="plan.create" --}}
                link-text="{{ translate('Add new Address') }}"
                on-click="$dispatch('display-flyout-panel', {'id': 'address-panel'})">
            </x-dashboard.empty-states.no-items-in-collection>
        @endif
    </div>

    {{-- Address Flyout --}}
    <x-panels.flyout-panel id="address-panel">
        <h3 class="text-18 mb-3 pb-2 border-b flex items-center" x-data="{}">
            @svg('heroicon-o-home', ['class' => 'w-[18px] h-[18px] mr-2'])
            <span>{{ translate('Address') }}</span>
        </h3>
    
        <div class="flex flex-col mb-1 grow">
            {{-- Address --}}
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">{{ translate('Address') }}</label>
                <div class="mt-1">
                  <input type="text" class="form-standard @error('currentAddress.address') is-invalid @enderror" wire:model.defer="currentAddress.address">
                  <x-system.invalid-msg field="currentAddress.address"></x-system.invalid-msg>
                </div>
            </div>
            {{-- END Address --}}

            <div class="grid grid-cols-4 gap-3 mt-3">
                {{-- Country --}}
                <div class="col-span-4 sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 @error('currentAddress.country') is-invalid @enderror">
                        {{ translate('Country') }}
                    </label>
                    <div class="mt-1">
                        <x-dashboard.form.select field="currentAddress.country" :items="\Countries::getAll()->keyBy('code')->map(fn($item) => $item->name)" selected="currentAddressCountry" :nullable="false"></x-dashboard.form.select>
                        <x-system.invalid-msg field="currentAddress.country"></x-system.invalid-msg>
                    </div>
                </div>
                {{-- END Country --}}

                {{-- State --}}
                <div class="col-span-4 sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">{{ translate('State') }}</label>
                    <div class="mt-1">
                        <input type="text" class="form-standard @error('currentAddress.state') is-invalid @enderror" wire:model.defer="currentAddress.state">
                        <x-system.invalid-msg field="currentAddress.state"></x-system.invalid-msg>
                    </div>
                </div>
                {{-- END State --}}
            </div>
            
            <div class="grid grid-cols-4 gap-3 mt-3">
                {{-- City --}}
                <div class="col-span-4 sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        {{ translate('City') }}
                    </label>
                    <div class="mt-1">
                        <input type="text" class="form-standard @error('currentAddress.city') is-invalid @enderror" wire:model.defer="currentAddress.city">
                        <x-system.invalid-msg field="currentAddress.city"></x-system.invalid-msg>
                    </div>
                </div>
                {{-- END City --}}

                {{-- ZIP Code --}}
                <div class="col-span-4 sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 ">{{ translate('ZIP code') }}</label>
                    <div class="mt-1">
                        <input type="text" class="form-standard @error('currentAddress.zip_code') is-invalid @enderror" wire:model.defer="currentAddress.zip_code">
                        <x-system.invalid-msg field="currentAddress.zip_code"></x-system.invalid-msg>
                    </div>
                </div>
                {{-- END ZIP Code --}}
            </div>
            
            {{-- Phones --}}
            <div class="w-full mt-4">
                <label class="block text-sm font-medium text-gray-700 ">{{ translate('Phones') }}</label>
                <div class="mt-1">
                    <x-dashboard.form.text-repeater field="currentAddressPhones" limit="3" placeholder="{{ translate('Phone') }}"></x-dashboard.form.text-repeater>
                    <x-system.invalid-msg field="currentAddress.phones"></x-system.invalid-msg>
                </div>
            </div>
            {{-- END Phones --}}

            {{-- Is primary? --}}
            <div class="flex items-center mt-5">
                <button type="button" @click="currentAddress_is_primary = !currentAddress_is_primary" 
                            :class="{'bg-primary':currentAddress_is_primary, 'bg-gray-200':!currentAddress_is_primary}" 
                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                    <span :class="{'translate-x-5':currentAddress_is_primary, 'translate-x-0':!currentAddress_is_primary}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                </button>
                <span class="ml-3" @click="currentAddress_is_primary = !currentAddress_is_primary">
                  <span class="text-sm font-medium text-gray-900 cursor-pointer">{{ translate('Is this your primary address?') }}</span>
                  {{-- <span class="text-sm text-gray-500">(Save 10%)</span> --}}
                </span>
            </div>
            {{-- END Is primary? --}}

            {{-- Is billing? --}}
            <div class="flex items-center mt-3">
                <button type="button" @click="currentAddress_is_billing = !currentAddress_is_billing" 
                            :class="{'bg-primary':currentAddress_is_billing, 'bg-gray-200':!currentAddress_is_billing}" 
                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                        <span :class="{'translate-x-5':currentAddress_is_billing, 'translate-x-0':!currentAddress_is_billing}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                </button>
                <span class="ml-3" @click="currentAddress_is_billing = !currentAddress_is_billing">
                  <span class="text-sm font-medium text-gray-900 cursor-pointer">{{ translate('Is this your billing address?') }}</span>
                  {{-- <span class="text-sm text-gray-500">(Save 10%)</span> --}}
                </span>
            </div>
            {{-- END Is billing? --}}

            <button type="button" class="w-full btn btn-primary ml-auto btn-sm mt-6" @click="
                    $wire.set('currentAddress.country', currentAddressCountry, true);
                    $wire.set('currentAddress.phones', currentAddressPhones, true);
                    $wire.set('currentAddress.is_primary', currentAddress_is_primary, true);
                    $wire.set('currentAddress.is_billing', currentAddress_is_billing, true);
                " wire:click="saveAddress()">
                {{ translate('Save') }}
            </button>
        </div>
    </x-panels.flyout-panel>
    {{-- END Address Flyout --}}
    
</div>