<div class="card mb-3 mb-lg-5 position-relative"
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
        @validation-errors.window="errors = $event.detail.errors;"
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

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">{{ translate('Close') }}</button>
                    <button type="button" class="btn btn-primary" @click="$wire.saveAddress().then(result => console.log(result))">{{ translate('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- END Addresses -->
</div>
