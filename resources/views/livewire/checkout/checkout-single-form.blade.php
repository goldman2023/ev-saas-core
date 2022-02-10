<div class="mt-4" x-data="{
    manual_mode: @js($manual_mode_billing),
    show_addresses: @js($show_addresses),
    addresses: @js($addresses),
    selected_billing_address_id: Number(@js($selected_billing_address_id)),
    selected_shipping_address_id: Number(@js($selected_shipping_address_id)),
    same_billing_shipping: @js($form->same_billing_shipping ? true : false),

}">

    <!-- Email -->
    <div class="w-full mb-3">
        <label for="form.email" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
            {{ translate('Email') }}
            <span class="text-red-700 ml-1">*</span>
        </label>
        <input name="form.email"
                id="form.email"
                wire:model.defer="form.email" 
                class="tw-input-main @error('form.email') is-invalid @enderror"       
        />

        <x-default.system.invalid-msg field="form.email"></x-default.system.invalid-msg>
    </div>
    <!-- END Email -->

    @guest
    <div class="w-full grid md:grid-cols-2 gap-4 mb-3">
        <div class="">
            <label for="account_password" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                {{ translate('Password') }}
                <span class="text-red-700 ml-1">*</span>
            </label>
            <input type="password" name="account_password" 
                    id="account_password"
                    wire:model.defer="account_password" 
                    class="tw-input-main @error('account_password') is-invalid @enderror"       
            />
        </div>
        <div class="">
            <label for="account_password_confirmation" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                {{ translate('Confirm password') }}
                <span class="text-red-700 ml-1">*</span>
            </label>
            <input type="password" name="account_password_confirmation" 
                    id="account_password_confirmation"
                    wire:model.defer="account_password_confirmation" 
                    class="tw-input-main @error('account_password') is-invalid @enderror"       
            />
        </div>

        <x-default.system.invalid-msg field="account_password"></x-default.system.invalid-msg>
    </div>
    @endguest

    <!-- First & Last name -->
    <div class="w-full grid md:grid-cols-2 gap-4 mb-3">
        <div class="">
            <label for="form.billing_first_name" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                {{ translate('First name') }}
                <span class="text-red-700 ml-1">*</span>
            </label>
            <input name="form.billing_first_name" 
                    id="form.billing_first_name"
                    wire:model.defer="form.billing_first_name" 
                    class="tw-input-main @error('form.billing_first_name') is-invalid @enderror"       
            />

            <x-default.system.invalid-msg field="form.billing_first_name"></x-default.system.invalid-msg>
        </div>
        <div class="">
            <label for="form.billing_last_name" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                {{ translate('Last name') }}
                <span class="text-red-700 ml-1">*</span>
            </label>
            <input name="form.billing_last_name" 
                    id="form.billing_last_name"
                    wire:model.defer="form.billing_last_name" 
                    class="tw-input-main @error('form.billing_first_name') is-invalid @enderror"       
            />

            <x-default.system.invalid-msg field="form.billing_last_name"></x-default.system.invalid-msg>
        </div>
    </div>
    <!-- END First & Last name -->

    <!-- Company -->
    <div class="w-full mb-3">
        <label for="form.billing_company" class="w-full block mb-2 text-12 font-medium text-gray-900 dark:text-gray-300">
            {{ translate('Company') }}
            <span class="text-orange-300 ml-1">{{ translate('(optional)') }}</span>
        </label>
        <input name="form.billing_company"
                id="form.billing_company"
                wire:model.defer="form.billing_company" 
                class="tw-input-main @error('form.billing_company') is-invalid @enderror"       
        />

        <x-default.system.invalid-msg field="form.billing_company"></x-default.system.invalid-msg>
    </div>
    <!-- END Company -->

    <!-- Phones -->
    <div class="w-full mt-3" x-data="{
        limit: 3,
        items: @js($form->phone_numbers),
        count() {
            if(this.items === undefined || this.items === null) {
                this.items = [''];
            }

            return this.items.length;
        },
        add() {
            if(this.count() < this.limit)
                this.items.push('');
        },
        remove(index) {
            this.items.splice(index, 1);
        },
     }">
        <label class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
            {{ translate('Phones') }}
        </label>

        <div class="w-full @error('form.phone_numbers') mb-2 @enderror">
            <template x-if="count() <= 1">
                <div class="flex">
                    <input type="text" class="tw-input-main"
                           placeholder="{{ translate('Phone number 1') }}"
                           x-model="items[0]">
                </div>
            </template>
            <template x-if="count() > 1">
                <template x-for="[key, value] of Object.entries(items)">
                    <div class="flex" :class="{'mt-2': key > 0}">
                        <input type="text" class="tw-input-main"
                               x-bind:placeholder="'{{ translate('Phone number') }} '+(Number(key)+1)"
                               x-model="items[key]">
                        <template x-if="key > 0">
                            <span class="ml-2 flex items-center cursor-pointer" @click="remove(key)">
                                @svg('heroicon-o-trash', ['class' => 'w-[22px] aspect-square text-danger'])
                            </span>
                        </template>
                    </div>
                </template>
            </template>

            <template x-if="count() < limit">
                <button 
                    type="button"
                    href="javascript:;"
                    class="tw-btn-sm mt-2"
                    @click="add()">
                    {{ translate('Add phone') }}
                </button>
            </template>
        </div>

        <template x-for="[key, phone_number] of Object.entries(items)">
            <input type="hidden" name="phone_numbers[]" class="" x-model="items[key]">
        </template>


        <x-default.system.invalid-msg field="form.phone_numbers"></x-default.system.invalid-msg>
    </div>
    <!-- END Phones -->

    <hr class="mt-4" />

    <!-- Billing -->
    <div class="d-flex flex-wrap mt-3" x-cloak>
        <h4 class="text-14 font-semibold" >
            {{ translate('Billing address') }}
        </h4>

        <template x-if="show_addresses">
            <fieldset>
                <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4" >
                    <template x-for="address in addresses">
                        <label class="relative bg-white border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none" 
                                :class="{'border-transparent ring-2 ring-indigo-500':selected_billing_address_id === address.id  , 'border-gray-300':selected_billing_address_id !== address.id}"
                                @click="selected_billing_address_id = address.id; manual_mode = false;">
                            <div class="flex-1 flex">
                                <div class="flex flex-col">
                                    <span class="block text-sm font-medium text-gray-900" x-text="address.country"></span>
                                    <span class="mt-1 flex items-center text-sm text-gray-500" x-text="address.address"></span>
                                    <span  class="mt-6 text-sm font-medium text-gray-900" x-text="address.city+', '+address.zip_code"></span>
                                </div>
                            </div>

                            @svg('heroicon-s-check-circle', ['class' => 'h-5 w-5 text-indigo-600', ':class' => '{\'hidden\': selected_billing_address_id !== address.id}'])
                            {{-- <svg class=" text-indigo-600" :class="{ 'hidden ' : selected_billing_address_id === address.id }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg> --}}
    
                            <div class="absolute -inset-px rounded-lg border-2 pointer-events-none" aria-hidden="true"
                                :class="{ 'border border-indigo-500': (selected_billing_address_id === address.id), 'border-2 border-transparent': (selected_billing_address_id !== address.id) }">
                            </div>
                        </label>
                    
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-3 px-2">
                            <div class="card w-100 pointer h-100 position-relative"
                                    :class="{ 'border-primary shadow' : selected_billing_address_id === address.id }"
                                    @click="selected_billing_address_id = address.id; manual_mode = false;">
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
                            :class="{'border-transparent ring-2 ring-indigo-500':selected_billing_address_id === address.id  , 'border-gray-300':selected_billing_address_id !== address.id}"
                            @click="selected_billing_address_id = -1; manual_mode = true;">
                        <div class="flex-1 flex">
                            <div class="flex flex-col justify-center items-center">
                                <span class="text-center">{{ translate('Add billing address manually') }}</span>
                            </div>
                        </div>

                        @svg('heroicon-s-check-circle', ['class' => 'h-5 w-5 text-indigo-600', ':class' => '{\'hidden\': selected_billing_address_id !== -1}'])

                        <div class="absolute -inset-px rounded-lg border-2 pointer-events-none" aria-hidden="true"
                            :class="{ 'border border-indigo-500': (selected_billing_address_id === -1), 'border-2 border-transparent': (selected_billing_address_id !== -1) }">
                        </div>
                    </label>
                </div>
            </fieldset>
        </template>

        <template x-if="show_addresses">
            <input type="hidden" name="selected_billing_address_id" x-model="selected_billing_address_id">
        </template>


        <div class="flex-wrap mt-3" :class="{'flex':manual_mode}" x-show="manual_mode">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="form.checkout_billing_address" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                        {{ translate('Address') }}
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input name="form.checkout_billing_address"
                            id="form.checkout_billing_address"
                            wire:model.defer="form.checkout_billing_address" 
                            class="tw-input-main @error('form.checkout_billing_address') is-invalid @enderror"       
                    />

                    <x-default.system.invalid-msg field="form.checkout_billing_address"></x-default.system.invalid-msg>
                </div>

                <div class="">
                    <label for="form.checkout_billing_country" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                        {{ translate('Country') }}
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input name="form.checkout_billing_country"
                            id="form.checkout_billing_country"
                            wire:model.defer="form.checkout_billing_country" 
                            class="tw-input-main @error('form.checkout_billing_country') is-invalid @enderror"       
                    />
    
                    <x-default.system.invalid-msg field="form.checkout_billing_country"></x-default.system.invalid-msg>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Col -->

            
            <div class="grid grid-cols-3 gap-4 mt-3">
                <div class="">
                    <label for="form.checkout_billing_state" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                        {{ translate('State') }}
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input name="form.checkout_billing_state"
                            id="form.checkout_billing_state"
                            wire:model.defer="form.checkout_billing_state" 
                            class="tw-input-main @error('form.checkout_billing_state') is-invalid @enderror"       
                    />
    
                    <x-default.system.invalid-msg field="form.checkout_billing_state"></x-default.system.invalid-msg>
                </div>
                <!-- End Col -->

                <div class="">
                    <label for="form.checkout_billing_city" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                        {{ translate('City') }}
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input name="form.checkout_billing_city"
                            id="form.checkout_billing_city"
                            wire:model.defer="form.checkout_billing_city" 
                            class="tw-input-main @error('form.checkout_billing_city') is-invalid @enderror"       
                    />
    
                    <x-default.system.invalid-msg field="form.checkout_billing_city"></x-default.system.invalid-msg>
                </div>
                <!-- End Col -->

                <div class="">
                    <label for="form.checkout_billing_zip" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                        {{ translate('ZIP') }}
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input name="form.checkout_billing_zip"
                            id="form.checkout_billing_zip"
                            wire:model.defer="form.checkout_billing_zip" 
                            class="tw-input-main @error('form.checkout_billing_zip') is-invalid @enderror"       
                    />
    
                    <x-default.system.invalid-msg field="form.checkout_billing_zip"></x-default.system.invalid-msg>
                </div>
                <!-- End Col -->
            </div>

            {{-- <div class="col-md-6 mt-3">
                <label for="checkout_billing_country" class="form-label">{{ translate('Country') }} <span class="text-danger">*</span></label>

                <!-- Select -->
                <select class="form-control custom-select @error('billing_country') is-invalid @enderror" name="billing_country" id="checkout_billing_country"
                        >
                    <option value="">{{ translate('Choose...') }}</option>
                    @foreach(\Countries::getAll() as $country)
                        <option value="{{ $country->code }}" {{ request()->old('billing_country') === $country->code ? 'selected':'' }}>{{ $country->name }}</option>
                    @endforeach
                </select>
                <!-- End Select -->

                @error('billing_country')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <!-- End Col -->

            

            <div class="col-md-6 mt-3">
                <label for="checkout_billing_state" class="form-label">{{ translate('State') }} <span class="text-danger">*</span></label>

                <!-- Input -->
                <input type="text" class="form-control @error('billing_state') is-invalid @enderror" name="billing_state" id="checkout_billing_state"
                        value="{{ request()->old('billing_state') }}" placeholder="(write country if there's no state)" >
                <!-- End Input -->

                @error('billing_state')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <!-- End Col -->

            <div class="col-md-6 mt-3">
                <label for="checkout_billing_city" class="form-label" >{{ translate('City') }}<span class="text-danger">*</span></label>

                <!-- Input -->
                <input type="text" class="form-control @error('billing_city') is-invalid @enderror" name="billing_city" id="checkout_billing_city"
                        value="{{ request()->old('billing_city') }}" placeholder="" >
                <!-- End Input -->

                @error('billing_city')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label for="checkout_billing_zip" class="form-label ">{{ translate('ZIP') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('billing_zip') is-invalid @enderror" name="billing_zip" id="checkout_billing_zip"
                        value="{{ request()->old('billing_zip') }}" placeholder="" >

                @error('billing_zip')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <!-- End Col -->

          --}}
        </div>
    </div>
    <!-- END Billing -->

    <!-- Shipping -->
    <div class="d-flex flex-wrap mt-3" x-cloak>
        <h4 class="text-14 font-semibold" >
            {{ translate('Shipping address') }}
        </h4>

        <template x-if="show_addresses">
            <fieldset>
                <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4" >
                    <template x-for="address in addresses">
                        <label class="relative bg-white border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none" 
                                :class="{'border-transparent ring-2 ring-indigo-500':selected_billing_address_id === address.id  , 'border-gray-300':selected_billing_address_id !== address.id}"
                                @click="selected_billing_address_id = address.id; manual_mode = false;">
                            <div class="flex-1 flex">
                                <div class="flex flex-col">
                                    <span class="block text-sm font-medium text-gray-900" x-text="address.country"></span>
                                    <span class="mt-1 flex items-center text-sm text-gray-500" x-text="address.address"></span>
                                    <span  class="mt-6 text-sm font-medium text-gray-900" x-text="address.city+', '+address.zip_code"></span>
                                </div>
                            </div>

                            @svg('heroicon-s-check-circle', ['class' => 'h-5 w-5 text-indigo-600', ':class' => '{\'hidden\': selected_billing_address_id !== address.id}'])
                            {{-- <svg class=" text-indigo-600" :class="{ 'hidden ' : selected_billing_address_id === address.id }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg> --}}
    
                            <div class="absolute -inset-px rounded-lg border-2 pointer-events-none" aria-hidden="true"
                                :class="{ 'border border-indigo-500': (selected_billing_address_id === address.id), 'border-2 border-transparent': (selected_billing_address_id !== address.id) }">
                            </div>
                        </label>
                    
                        {{-- <div class="col-12 col-md-6 col-lg-4 mb-3 px-2">
                            <div class="card w-100 pointer h-100 position-relative"
                                    :class="{ 'border-primary shadow' : selected_billing_address_id === address.id }"
                                    @click="selected_billing_address_id = address.id; manual_mode = false;">
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
                            :class="{'border-transparent ring-2 ring-indigo-500':selected_billing_address_id === address.id  , 'border-gray-300':selected_billing_address_id !== address.id}"
                            @click="selected_billing_address_id = -1; manual_mode = true;">
                        <div class="flex-1 flex">
                            <div class="flex flex-col justify-center items-center">
                                <span class="text-center">{{ translate('Add billing address manually') }}</span>
                            </div>
                        </div>

                        @svg('heroicon-s-check-circle', ['class' => 'h-5 w-5 text-indigo-600', ':class' => '{\'hidden\': selected_billing_address_id !== -1}'])

                        <div class="absolute -inset-px rounded-lg border-2 pointer-events-none" aria-hidden="true"
                            :class="{ 'border border-indigo-500': (selected_billing_address_id === -1), 'border-2 border-transparent': (selected_billing_address_id !== -1) }">
                        </div>
                    </label>
                </div>
            </fieldset>
        </template>

        <template x-if="show_addresses">
            <input type="hidden" name="selected_billing_address_id" x-model="selected_billing_address_id">
        </template>


        <div class="flex-wrap mt-3" :class="{'flex':manual_mode}" x-show="manual_mode">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="form.checkout_billing_address" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                        {{ translate('Address') }}
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input name="form.checkout_billing_address"
                            id="form.checkout_billing_address"
                            wire:model.defer="form.checkout_billing_address" 
                            class="tw-input-main @error('form.checkout_billing_address') is-invalid @enderror"       
                    />

                    <x-default.system.invalid-msg field="form.checkout_billing_address"></x-default.system.invalid-msg>
                </div>

                <div class="">
                    <label for="form.checkout_billing_country" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                        {{ translate('Country') }}
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input name="form.checkout_billing_country"
                            id="form.checkout_billing_country"
                            wire:model.defer="form.checkout_billing_country" 
                            class="tw-input-main @error('form.checkout_billing_country') is-invalid @enderror"       
                    />
    
                    <x-default.system.invalid-msg field="form.checkout_billing_country"></x-default.system.invalid-msg>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Col -->

            
            <div class="grid grid-cols-3 gap-4 mt-3">
                <div class="">
                    <label for="form.checkout_billing_state" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                        {{ translate('State') }}
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input name="form.checkout_billing_state"
                            id="form.checkout_billing_state"
                            wire:model.defer="form.checkout_billing_state" 
                            class="tw-input-main @error('form.checkout_billing_state') is-invalid @enderror"       
                    />
    
                    <x-default.system.invalid-msg field="form.checkout_billing_state"></x-default.system.invalid-msg>
                </div>
                <!-- End Col -->

                <div class="">
                    <label for="form.checkout_billing_city" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                        {{ translate('City') }}
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input name="form.checkout_billing_city"
                            id="form.checkout_billing_city"
                            wire:model.defer="form.checkout_billing_city" 
                            class="tw-input-main @error('form.checkout_billing_city') is-invalid @enderror"       
                    />
    
                    <x-default.system.invalid-msg field="form.checkout_billing_city"></x-default.system.invalid-msg>
                </div>
                <!-- End Col -->

                <div class="">
                    <label for="form.checkout_billing_zip" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                        {{ translate('ZIP') }}
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input name="form.checkout_billing_zip"
                            id="form.checkout_billing_zip"
                            wire:model.defer="form.checkout_billing_zip" 
                            class="tw-input-main @error('form.checkout_billing_zip') is-invalid @enderror"       
                    />
    
                    <x-default.system.invalid-msg field="form.checkout_billing_zip"></x-default.system.invalid-msg>
                </div>
                <!-- End Col -->
            </div>
        </div>
    </div>
    <!-- END Shipping -->

    <hr class="mt-4" />

    <div class="flex flex-col mt-3">
        <!-- Checkbox -->
        <div class="flex items-center cursor-pointer">
            <input type="checkbox" class="tw-input-checkbox" id="form-same_billing_shipping" name="form.same_billing_shipping"
                    x-model="same_billing_shipping">
            <div class="ml-2">
                <label for="form-same_billing_shipping" class="text-12 font-medium text-gray-500 mb-0 cursor-pointer">
                    {{ translate('My billing and delivery information are the same') }}
                </label>
            </div>
        </div>
        <!-- End Checkbox -->

        <div class="flex items-center cursor-pointer">
            <input type="checkbox" class="tw-input-checkbox" id="checkout_newsletter" name="checkout_newsletter"
                   wire:model.defer="newsletter">
            <div class="ml-2">
                <label for="checkout_newsletter" class="text-12 font-medium text-gray-500 mb-0 cursor-pointer">
                    {{ translate('Please send me emails with exclusive info') }}
                </label>
            </div>
        </div>
        <!-- End Checkbox -->

        <!-- Checkbox -->
        <div class="mb-2">
            <div class="flex items-center cursor-pointer">
                <input type="checkbox" class="tw-input-checkbox" id="buyers_consent" name="form.buyers_consent"
                       x-model="buyers_consent">
                <div class="ml-2">
                    <label for="buyers_consent" class="text-12 font-medium text-gray-500 mb-0 cursor-pointer">
                        {{ translate('By placing an order, I agree to ') }}
                        {{ \TenantSettings::get('site_name') }}
                        <a href="#" target="_blank">{{ translate('terms of sale') }}</a>
                    </label>
                </div>
            </div>
        </div>
        <!-- End Checkbox -->
    </div>

</div>