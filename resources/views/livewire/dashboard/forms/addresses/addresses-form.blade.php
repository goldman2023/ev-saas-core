<div class="card mb-3 mb-lg-5 position-relative"
     id="addressesSection"
     x-data="{
        currentAddress: @entangle('currentAddress').defer,
        addresses: @entangle('addresses'),
        showModal() {
            $('#updateAddressModal').modal('toggle');
            this.initToggleSwitch();

            console.log();
        },
        initToggleSwitch() {
            $('#updateAddressModal').find('.js-toggle-switch').each(function () {
                var addressToggleSwitch = new HSToggleSwitch($(this)).init();
            });
        }
     }"
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
                                @if($address->set_default)
                                    <span class="position-absolute badge badge-primary text-10" style="right: 10px; top: 10px;">
                                        {{ translate('Default') }}
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


    <div class="card-footer">
        <div class="col-12 d-flex">
            <button type="button" class="btn btn-primary ml-auto btn-sm" wire:click="saveEmail()">
                {{ translate('Save') }}
            </button>
        </div>
    </div>

    <!-- Address change Modal -->
    <div id="updateAddressModal" class="modal fade" tabindex="-1" role="dialog"
         x-data="{

         }">
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
                                   name="model_address_address"
                                   x-model="currentAddress.address"
                                   class="form-control"
                                   placeholder="Your address...">
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
                                   name="model_address_city"
                                   x-model="currentAddress.city"
                                   class="form-control"
                                   placeholder="City...">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label class="input-label" for="modal_address_state">{{ translate('State') }}</label>
                            <input type="text"
                                   id="modal_address_state"
                                   name="model_address_state"
                                   x-model="currentAddress.state"
                                   class="form-control"
                                   placeholder="State...">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label class="input-label" for="modal_address_zip_code">{{ translate('Zip Code') }}</label>
                            <input type="text"
                                   id="modal_address_zip_code"
                                   name="model_address_zip_code"
                                   x-model="currentAddress.zip_code"
                                   class="form-control"
                                   placeholder="Zip code...">
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
                            </div>
                        </div>
                        <!-- End Form Group -->
                    </div>

                    <div class="col-12">
                        <label class="toggle-switch mx-2" for="customSwitchModalEg">
                            <input type="checkbox" x-model="currentAddress.set_default" class="js-toggle-switch toggle-switch-input" id="customSwitchModalEg">
                            <span class="toggle-switch-label">
                                <span class="toggle-switch-indicator"></span>
                            </span>

                            <span class="ml-3">{{ translate('Use as default address') }}</span>
                        </label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">{{ translate('Close') }}</button>
                    <button type="button" class="btn btn-primary" wire:click="saveAddress()">{{ translate('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- END Addresses -->
</div>
