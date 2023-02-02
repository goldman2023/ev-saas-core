<div class="mt-4" x-data="{
    items: @js($items),
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
    cc_name: @js($cc_name),
    cc_number: @js($cc_number),
    cc_expiration_date: @js($cc_expiration_date),
    cc_cvc: @js($cc_cvc),
    core_meta: @js($core_meta),
    wef: @js($wef),

    setDefaults() {
        if(this.wef.billing_entity !== 'individual' && this.wef.billing_entity !== 'company') {
            this.wef.billing_entity = 'individual';
        }
    }
}" 
@validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
x-init="setDefaults();"
x-cloak
>
    <div class="w-full flex flex-col  mb-3 gap-y-2">
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

    <!-- Email -->
    <div class="w-full mb-3">
        <label for="order.email" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
            {{ translate('Email') }}
            <span class="text-red-700 ml-1">*</span>
        </label>

        <x-dashboard.form.input field="order.email" :disabled="\Auth::check()" />
    </div>
    <!-- END Email -->

    {{-- TODO: Create ghost user if user does not exist AND send email to activate account! --}}
    {{-- @guest
        <div class="w-full mb-3">
            <div class="w-full grid md:grid-cols-2 gap-4">
                <div class="">
                    <label for="account_password" class="w-full block mb-1 text-12 font-medium text-gray-900 dark:text-gray-300">
                        {{ translate('Password') }}
                        <span class="text-red-700 ml-1">*</span>
                    </label>
                    <input type="password" name="account_password" 
                            id="account_password"
                            wire:model.defer="account_password" 
                            class="form-standard @error('account_password') is-invalid @enderror"       
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
                            class="form-standard @error('account_password') is-invalid @enderror"       
                    />
                </div>
            </div>
            <x-system.invalid-msg field="account_password" ></x-system.invalid-msg>
        </div>
    @endguest --}}

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
    <div class="w-full mb-3 grid grid-cols-12 gap-x-3" x-show="wef.billing_entity === 'company'">
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
        {{-- Checkbox --}}
        <div class="flex items-center cursor-pointer">
            <input type="checkbox" class="form-checkbox-standard" id="checkout_newsletter" name="checkout_newsletter"
                   wire:model.defer="checkout_newsletter">
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
        <!-- End Checkbox -->
    </div>


    <div class="mt-4">
        <button class="btn-primary text-center justify-center w-full bg-red-500 text-white" 
                @click="
                    $wire.set('order.phone_numbers', phoneNumbers, true);
                    $wire.set('order.billing_country', billingCountry, true);
                    $wire.set('order.shipping_country', shippingCountry, true);
                    $wire.set('selected_payment_method', selected_payment_method, true);
                    $wire.set('cc_number', cc_number, true);
                    $wire.set('cc_name', cc_name, true);
                    $wire.set('cc_expiration_date', cc_expiration_date, true);
                    $wire.set('cc_cvc', cc_cvc, true);
                    $wire.set('order.same_billing_shipping', same_billing_shipping, true);
                    $wire.set('order.buyers_consent', buyers_consent, true);
                    $wire.set('selected_billing_address_id', selected_billing_address_id || -1, true);
                    $wire.set('selected_shipping_address_id', selected_shipping_address_id || -1, true);
                "
                wire:click="pay()"
                wire:loading.class="bg-gray-100 text-gray-900 pointer-events-none">
            <span wire:loading.class="hidden">{{ translate('Pay') }}</span>
            @svg('lineawesome-spinner-solid', ['class'=> 'hidden w-[20px] h-[20px] animate-spin text-gray-900', 'wire:loading.class.remove' => 'hidden', 'wire:loading.class' => 'inline'])
        </button>
    </div>
</div>