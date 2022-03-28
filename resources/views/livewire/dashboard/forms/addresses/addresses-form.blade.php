<div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5" x-data="{
        currentAddressCountry: @js($currentAddress->country ?? ''),
        currentAddressPhones: @js($currentAddress->phones ?? ''),
        currentAddress_is_primary: @js($currentAddress->is_primary ?? false),
        currentAddress_is_billing: @js($currentAddress->is_billing ?? false),
        addresses: @entangle('addresses'),
        available_features: @js(\App\Models\ShopAddress::getAvailableFeatures()),
    }">
    <div class="border-b border-gray-200 mb-3 pb-3">
        <div class="shrink-0">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-1">{{ translate('Addresses') }}</h3>
            <p class="flex items-center-1 max-w-2xl text-sm text-gray-500"> {{ translate('Add one or multiple addresses to your account') }}</p>
        </div>
        <div class="grow-0">
            <button type="button" class="btn-primary" @click="$dispatch('display-flyout-panel', {'id': 'address-panel'})">
                {{-- @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2']) --}}
                <span>{{ translate('Add new') }}</span>
            </button>
        </div> 
        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Addresses') }}</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Add one or multiple addresses to your account') }}</p>
    </div>

    <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5 pb-2">

        @if($addresses->isNotEmpty())
            <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
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
                                    <a href="#" class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm bg-danger text-white font-medium border border-transparent rounded-bl-lg">
                                        @svg('heroicon-o-trash', ['class' => 'w-5 h-5 text-white'])
                                        <span class="ml-3">{{ translate('Remove') }}</span>
                                    </a>
                                </div>
                                <div class="-ml-px w-0 flex-1 flex">
                                    <a href="tel:+1-202-555-0170" class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                                        @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
                                        <span class="ml-3">{{ translate('Edit') }}</span>
                                    </a>
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

<div class="card mb-3 mb-lg-5 mt-5 position-relative"
     id="addressesSection"
     x-data="{
        currentAddress: @entangle('currentAddress').defer,
        addresses: @entangle('addresses'),
        available_features: @js(\App\Models\ShopAddress::getAvailableFeatures()),
        map: null,
        marker_layer_group: L.layerGroup(),
        async showModal() {
            $('#updateAddressModal').modal('toggle');
        },
        initToggleSwitch() {
            $('#updateAddressModal').find('.js-toggle-switch').each(function () {
                var addressToggleSwitch = new HSToggleSwitch($(this)).init();
            });
        },
        async initLocationMap() {
            if(this.currentAddress.hasOwnProperty('location')) {
                this.map = L.map('modal_address_map', {
                    'scrollWheelZoom': false
                }).setView([0, 0], 17);

                L.tileLayer.provider('OpenStreetMap.Mapnik', {
                    attribution: '&copy; <a href=\'https://www.openstreetmap.org/copyright\'>OpenStreetMap</a> contributors'
                }).addTo(this.map);

                this.marker_layer_group.addTo(this.map); // add marker layer group to map

                this.setAddressMarker(this.currentAddress.location);

                setTimeout(() => {
                    //this.map.invalidateSize();
                }, 500);

                // Locate
                if(this.currentAddress.hasOwnProperty('location') && this.currentAddress.location == null) {
                    this.locateAddressByText();
                }

                this.map.on('click', (e) => {
                    this.setAddressMarker(e.latlng);
                });
            }
        },
        async locateAddressByText() {
            if(this.currentAddress.hasOwnProperty('location')) {
                let result = await window.EV.leaflet.geosearch.getResults(this.currentAddress.address+' '+this.currentAddress.city+' '+this.currentAddress.country);
                if(result[0] !== undefined) {
                    this.currentAddress.location = {
                        lat: result[0]['y'],
                        lng: result[0]['x']
                    };
                }
            }
        },
        setAddressMarker(location) {
            if(location !== null && location.hasOwnProperty('lat') && location.hasOwnProperty('lng')) {
                try {
                    this.map.setView(L.latLng(location));
                    this.marker_layer_group.clearLayers();
                    L.marker(L.latLng(location)).addTo(this.marker_layer_group);
                } catch(error) {}
            }
        }
     }"
     x-init="
        $($el).on('shown.bs.modal', async function(event) {
            initToggleSwitch();
            await initLocationMap();
        });
        $($el).on('hidden.bs.modal', function (e) {
          map.remove();
        });
        $watch('currentAddress.location', function(value) {
            setAddressMarker(value);
        });"
    @display-address-modal.window="showModal()">
    <!-- Addresses -->

    <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                          wire:target="saveAddresses"
                          wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

    <div class="card-header">
        <h2 class="card-title h4">{{ translate('Addresses') }}</h2>
    </div>

    <div class="card-body">
        <div class="row"
             wire:loading.class="opacity-3 prevent-pointer-events"
             wire:target="saveAddresses"
        >
            @if(!empty($addresses))
                @foreach($addresses as $key => $address)
                    <div class="col-4 px-2 mb-3">
                        <div class="card w-100 pointer h-100 position-relative"
                             x-data="{
                                address: @js($address)
                             }"
{{--                             currentAddress = address; showModal();--}}
                             wire:click="changeCurrentAddress({{ $key }})"
                             wire:target="changeCurrentAddress({{ $key }})"
                             wire:loading.class="prevent-pointer-events opacity-4">

                            <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                                                  wire:target="changeCurrentAddress({{ $key }})"
                                                  wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

                            <div class="card-body position-relative">
                                @if($address->is_primary)
                                    <span class="position-absolute badge badge-primary text-10" style="right: 10px; top: 10px;">
                                        {{ translate('Primary') }}
                                    </span>
                                @endif
                                <h6 class="card-subtitle">{{ \Countries::get(code: $address->country)->name ?? translate('Unknown') }}</h6>
                                <h3 class="card-title text-18">{{ $address->address }}</h3>
                                <p class="card-text mb-2">{{ $address->city }}, {{ $address->zip_code }}</p>

                                @if(!empty($address->phones))
                                    <div class="d-flex align-items-center flex-wrap">
                                        @foreach($address->phones as $address_phone)
                                            <span class="badge badge-info mr-2 mb-2">{{ $address_phone }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>


{{--    <div class="card-footer">--}}
{{--        <div class="col-12 d-flex">--}}
{{--            <button type="button" class="btn btn-primary ml-auto btn-sm" wire:click="saveEmail()">--}}
{{--                {{ translate('Save') }}--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Address change Modal -->
    <div id="updateAddressModal" wire:ignore class="modal fade" tabindex="-1" role="dialog"
         x-data="{
            errors: {}
         }"
        @validation-errors.window="errors = getSafe(() => $event.detail.errors);"
         @display-address-modal.window="errors = {}">
        <div class="modal-dialog modal-dialog-centered" role="document"
             wire:target="saveAddress()"
             wire:loading.class="prevent-pointer-events opacity-4"
        >
            <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                                  wire:target="saveAddress()"
                                  wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

            <div class="modal-content">
                <!-- Header -->
                <div class="modal-top-cover bg-dark text-center">
                    <figure class="position-absolute right-0 bottom-0 left-0" style="margin-bottom: -1px;">
                        <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1920 100.1"
                             style="vertical-align: middle;">
                            <path fill="#fff" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z"/>
                        </svg>
                    </figure>

                    <div class="modal-close">
                        <button type="button" class="btn btn-icon btn-sm btn-ghost-light" data-dismiss="modal" aria-label="Close">
                            <svg width="16" height="16" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor" d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- End Header -->

                <div class="modal-top-cover-icon">
                    <span class="icon icon-md icon-light icon-circle d-flex mx-auto shadow-soft">
                      @svg('heroicon-o-home', ['class' => 'square-24'])
                    </span>
                </div>

                <div class="modal-body row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="input-label " for="modal_address_address">{{ translate('Address') }}</label>
                            <input type="text"
                                   id="modal_address_address"
                                   name="modal_address_address"
                                   x-model="currentAddress.address"
                                   class="form-control"
                                   placeholder="Your address...">

                            <template x-if="errors.hasOwnProperty('currentAddress.address')">
                                <div class="invalid-feedback d-block mt-2" x-text="getSafe(() => errors['currentAddress.address'][0])"></div>
                            </template>
                        </div>
                    </div>

                    <div class="col-6"
                         x-init="
                            $('#modal_address_country').on('select2:select', (event) => {
                              currentAddress.country = event.target.value;
                            });
                            $watch('currentAddress.country', (value) => {
                              $('#modal_address_country').val(value).trigger('change');
                            });
                        "
                    >
                        <label class="input-label " for="modal_address_country">{{ translate('Country') }}</label>
                        <select class="form-control custom-select" name="modal_address_country" id="modal_address_country"
                                data-hs-select2-options='{
                              "minimumResultsForSearch": -1,
                              "placeholder": "Select country..."
                            }'>
                            <option label="empty"></option>
                            @foreach(\Countries::getAll() as $country)
                                <option value="{{ $country->code }}" x-bind:selected="'{{ $country->code }}' === currentAddress.country">
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label class="input-label" for="modal_address_city">{{ translate('City') }}</label>
                            <input type="text"
                                   id="modal_address_city"
                                   name="modal_address_city"
                                   x-model="currentAddress.city"
                                   class="form-control"
                                   placeholder="City...">

                            <template x-if="errors.hasOwnProperty('currentAddress.city')">
                                <div class="invalid-feedback d-block mt-2" x-text="getSafe(() => errors['currentAddress.city'][0])"></div>
                            </template>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label class="input-label" for="modal_address_state">{{ translate('State') }}</label>
                            <input type="text"
                                   id="modal_address_state"
                                   name="modal_address_state"
                                   x-model="currentAddress.state"
                                   class="form-control"
                                   placeholder="State...">

                            <template x-if="errors.hasOwnProperty('currentAddress.state')">
                                <div class="invalid-feedback d-block mt-2" x-text="getSafe(() => errors['currentAddress.state'][0])"></div>
                            </template>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label class="input-label" for="modal_address_zip_code">{{ translate('Zip Code') }}</label>
                            <input type="text"
                                   id="modal_address_zip_code"
                                   name="modal_address_zip_code"
                                   x-model="currentAddress.zip_code"
                                   class="form-control"
                                   placeholder="Zip code...">

                            <template x-if="errors.hasOwnProperty('currentAddress.zip_code')">
                                <div class="invalid-feedback d-block mt-2" x-text="getSafe(() => errors['currentAddress.zip_code'][0])"></div>
                            </template>
                        </div>
                    </div>

                    <div class="col-12">
                        <!-- Form Group -->
                        <div class="js-add-field row form-group"
                             x-data="{
                                phones_limit: 3,
                                addNewPhoneNumber() {
                                    if(currentAddress.phones.length < 3)
                                        currentAddress.phones.push('');
                                },
                                removePhoneNumber(index) {
                                    currentAddress.phones.splice(index, 1);
                                },
                             }"
                            >
                            <label for="phoneFieldLabel" class="col-sm-3 col-form-label input-label">
                                {{ translate('Phones') }}
                            </label>

                            <div class="col-sm-9">
                                <template x-if="currentAddress.phones.length <= 1">
                                    <div class="d-flex">
                                        <input type="text" class="form-control" name="phoneNumberField"
                                               placeholder="{{ translate('Phone number 1') }}"
                                               x-model="currentAddress.phones[0]">
                                    </div>
                                </template>
                                <template x-if="currentAddress.phones.length > 1">
                                    <template x-for="[key, value] of Object.entries(currentAddress.phones)">
                                        <div class="d-flex" :class="{'mt-2': key > 0}">
                                            <input type="text" class="form-control" name="phoneNumberField"
                                                   x-bind:placeholder="'{{ translate('Phone number') }} '+(Number(key)+1)"
                                                   x-model="currentAddress.phones[key]">
                                            <template x-if="key > 0">
                                                <span class="ml-2 d-flex align-items-center pointer" @click="removePhoneNumber(key)">
                                                    @svg('heroicon-o-trash', ['class' => 'square-22 text-danger'])
                                                </span>
                                            </template>
                                        </div>
                                    </template>
                                </template>

                                <template x-if="currentAddress.phones.length < phones_limit">
                                    <a href="javascript:;"
                                       class="js-create-field form-link btn btn-xs btn-no-focus btn-ghost-primary"
                                       @click="addNewPhoneNumber()">
                                        <i class="tio-add"></i> {{ translate('Add phone') }}
                                    </a>
                                </template>

                                <template x-if="errors.hasOwnProperty('currentAddress.phones')">
                                    <div class="invalid-feedback d-block mt-3" x-text="getSafe(() => errors['currentAddress.phones'][0])"></div>
                                </template>
                            </div>
                        </div>
                        <!-- End Form Group -->
                    </div>

                    <!-- Features -->
                    <template x-if="currentAddress.features">
                        <div class="col-12"
                             x-data="{
                                toggleFeature(key) {
                                    if(currentAddress.features.indexOf(key) === -1) {
                                        currentAddress.features.push(key);
                                    } else {
                                        currentAddress.features.splice(currentAddress.features.indexOf(key), 1);
                                    }
                                }
                             }">
                            <!-- Form Group -->
                            <div class="row form-group">
                                <label class="col-sm-3 col-form-label input-label">
                                    {{ translate('Features') }}
                                </label>

                                <div class="col-sm-9">
                                    <template x-if="available_features">
                                        <template x-for="[key, value] of Object.entries(available_features)">
                                            <span class="badge mr-2 mb-1 pointer noselect" x-text="value"
                                                :class="{'badge-success': currentAddress.features.indexOf(key) !== -1, 'badge-dark': currentAddress.features.indexOf(key) === -1}"
                                                @click="toggleFeature(key)"
                                            ></span>
                                        </template>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- END Features -->


                    <!-- Location -->
                    <template x-if="currentAddress.hasOwnProperty('location')">
                        <div class="col-12"
                             x-data="{

                             }">
                            <!-- Form Group -->
                            <div class="row form-group">
                                <label class="col-sm-12 col-form-label input-label">
                                    {{ translate('Set location marker') }}
                                </label>

                                <div class="col-sm-12">
                                    <div class="map-container" >
                                        <div class="map-frame w-100 h-100" >
                                            <div id="modal_address_map" class="leaflet-custom rounded w-100" style="height: 300px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="col-12">
                        <label class="toggle-switch mx-2" for="customSwitchIsPrimary">
                            <input type="checkbox" x-model="currentAddress.is_primary" class="js-toggle-switch toggle-switch-input" id="customSwitchIsPrimary">
                            <span class="toggle-switch-label">
                                <span class="toggle-switch-indicator"></span>
                            </span>

                            <span class="ml-3">{{ translate('Use as primary address') }}</span>
                        </label>
                    </div>

                    <div class="col-12 mt-3">
                        <label class="toggle-switch mx-2" for="customSwitchIsBilling">
                            <input type="checkbox" x-model="currentAddress.is_billing" class="js-toggle-switch toggle-switch-input" id="customSwitchIsBilling">
                            <span class="toggle-switch-label">
                                <span class="toggle-switch-indicator"></span>
                            </span>

                            <span class="ml-3">{{ translate('Use as default billing address') }}</span>
                        </label>
                    </div>

                    <template x-if="errors.hasOwnProperty('general')">
                        <div class="col-12 mt-4">
                            <div class="d-block py-2 px-2 bg-danger rounded text-white text-14" x-text="getSafe(() => errors['general'][0])"></div>
                        </div>
                    </template>
                </div>
                <div class="modal-footer">
{{--                    <template x-if="1=1">--}}
                        <button type="button"
                                class="btn btn-primary mr-auto d-flex align-items-center justify-content-center"
                                @click="$wire.removeAddress()">
                            @svg('heroicon-o-trash', ['class' => 'square-22'])
                        </button>
{{--                    </template>--}}

                    <button type="button" class="btn btn-white" data-dismiss="modal">{{ translate('Close') }}</button>
                    <button type="button" class="btn btn-primary" @click="$wire.saveAddress()">{{ translate('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- END Addresses -->
</div>
