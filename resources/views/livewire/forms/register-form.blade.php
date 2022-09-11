@php
    $form_id = \Uuid::generate(4)->string;
@endphp
<form class="w-full relative" wire:submit.prevent="register()" x-data="{
        entity: @js($entity),
        @if(collect(get_tenant_setting('user_meta_fields_in_use'))->where('registration', true)->count() > 0)
            user_meta: {
                @foreach(collect(get_tenant_setting('user_meta_fields_in_use'))->where('registration', true) as $key => $options)
                    @if(($options['type']??'string') == 'select' || ($options['type']??'string') == 'date' || $key == 'company_vat')
                        {{ $key }}: @js($user_meta[$key]),
                    @endif
                @endforeach
            }
        @endif
    }">
    <x-ev.loaders.spinner class="absolute-center z-10 hidden" wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

    <div class="w-full" wire:loading.class="opacity-30 pointer-events-none">
        <div class="w-full ">
            <x-system.social-login-buttons class="mb-5">
                <div class="w-full relative mb-3">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-2 bg-white text-sm text-gray-500"> {{ translate('OR') }} </span>
                    </div>
                </div>
            </x-system.social-login-buttons>
        </div>

        @if(get_tenant_setting('user_entity_choice'))
            <div class="mb-3">
                <fieldset class="mt-4">
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        <div class="flex items-center">
                            <input id="entity_individual" name="entity_field" selected type="radio" x-model="entity"  value="individual" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="entity_individual" class="ml-3 block text-sm font-medium text-gray-700">
                                {{ translate('Individual') }}
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input id="entity_company" name="entity_field" type="radio" x-model="entity"  value="company" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="entity_company" class="ml-3 block text-sm font-medium text-gray-700"> {{ translate('Company') }} </label>
                        </div>
                    </div>
                </fieldset>
            </div>
        @endif

        {{-- First Name --}}
        <div class="sm:grid-cols-2 grid gap-3">
        <div class="mb-3">
            <label class="block text-16 font-medium text-gray-700">{{ translate('First name') }}</label>

            <div class="mt-1 relative rounded-md shadow-sm">
                <input type="text" class="form-standard @error('name') is-invalid @enderror" placeholder="John"
                    wire:model.defer="name" data-test="we-register-name">

                <x-system.invalid-icon field="name" />
            </div>

            <x-system.invalid-msg field="name" />
        </div>
        {{-- END First Name --}}

        {{-- Last Name --}}
        <div class="mb-3">
            <label class="block text-16 font-medium text-gray-700">{{ translate('Last name') }}</label>

            <div class="mt-1 relative rounded-md shadow-sm">
                <input type="text" class="form-standard @error('surname') is-invalid @enderror" placeholder="Smith"
                    wire:model.defer="surname" data-test="we-register-surname">

                <x-system.invalid-icon field="surname" />
            </div>

            <x-system.invalid-msg field="surname" />
        </div>
        {{-- END Last Name --}}
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="block text-16 font-medium text-gray-700">{{ translate('Email') }}</label>

            <div class="mt-1 relative rounded-md shadow-sm">
                <input type="email" name="email" class="form-standard @if($is_ghost) form-standard opacity-50 pointer-events-none @endif @error('email') is-invalid @enderror"
                    placeholder="you@example.com" wire:model.defer="email" data-test="we-register-email" @if($is_ghost) readonly @endif>

                <x-system.invalid-icon field="email" />
            </div>

            <x-system.invalid-msg field="email" />
        </div>
        {{-- END Email --}}


        
        @if(collect(get_tenant_setting('user_meta_fields_in_use'))->where('registration', true)->count() > 0)
            @foreach(collect(get_tenant_setting('user_meta_fields_in_use'))->where('registration', true)->sortByOrderProperty() as $key => $options)
                <div class="mb-4" @if(in_array($key, \App\Models\UserMeta::metaForCompanyEntity())) x-show="entity === 'company'" @endif >
                    <label class="block text-16 font-medium text-gray-700" 
                        @if($key === 'address_state') 
                            x-show="{{ json_encode(\Countries::getCountriesWithStates()) }}.includes(user_meta.address_country)" 
                        @endif >

                        @if($key === 'company_vat')
                            {{ translate('Company VAT') }}
                        @elseif($key === 'address_country')
                            {{ translate('Country') }}
                        @else
                            {{  Str::title(str_replace('_', ' ', $key)) }}
                        @endif

                        @if($options['required'])
                            <small class="text-danger">*</small>
                        @endif
                    </label>

                    <div class="mt-1 relative rounded-md shadow-sm" x-data="{
                        valid_vat: @error('user_meta.company_vat') false @else null @enderror,
                        get isValidVAT() {
                            return this.valid_vat;
                        }
                    }">
                        @if($key === 'company_vat')
                            @php
                                $company_vat_field_key = \Uuid::generate(4)->string;
                            @endphp
                            <div x-data="{
                                {{-- valid_vat: @error('user_meta.company_vat') false @else null @enderror, --}}
                                checkVATvalidity() {
                                    wetch.get('{{ route('api.validate.vat') }}?vat='+user_meta.company_vat+'&country='+user_meta.address_country)
                                    .then(data => {
                                        if(data.status === 'success') {
                                            if(data.is_country_eu && user_meta.company_vat !== undefined && user_meta.company_vat !== '' && user_meta.company_vat !== null) {
                                                valid_vat = data.is_vat_valid;
                                            } else {
                                                valid_vat = null;
                                            }

                                            console.log(valid_vat);
                                        }
                                    })
                                    .catch(error => {
                                        valid_vat = null;
                                    });
                                }
                            }"
                            x-effect="@error('user_meta.company_vat') false @else null @enderror"
                            wire:ignore.self
                            {{-- wire:key="{{ $form_id }}" 
                            key="{{ $form_id }}" --}}
                            x-init="$watch('user_meta.address_country', (country) => { if(entity === 'company') checkVATvalidity() })">
                            
                                <div class="mt-1 flex" :class="{'opacity-50 pointer-events-none': !user_meta.address_country}">
                                    
                                    <div class="relative grow">
                                        <input type="text" x-model="user_meta.{{ $key }}"
                                        :class="{'is-valid':isValidVAT === true, 'is-invalid':isValidVAT === false}"
                                        class="form-standard pr-10" :disabled="user_meta.address_country ? false : true">

                                        <div x-show="isValidVAT === false" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            @svg('heroicon-s-exclamation-circle', ['class' => 'h-5 w-5 text-red-500'])
                                        </div>

                                        <div x-show="isValidVAT === true" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            @svg('heroicon-s-check-circle', ['class' => 'h-5 w-5 text-green-500'])
                                        </div>
                                    </div>

                                    <button type="button" @click="checkVATvalidity()" :disabled="user_meta.address_country ? false : true" class="relative -ml-px inline-flex items-center space-x-2 rounded-r-md border border-gray-300 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                        <span>{{ translate('Verify') }}</span>
                                    </button>
                                </div>

                                @error('user_meta.company_vat')
                                    <div class="w-full" x-show="isValidVAT === true">
                                        <x-system.invalid-msg field="user_meta.company_vat"></x-system.invalid-msg>
                                    </div>
                                @enderror
                                {{-- <p class="mt-2 text-sm text-red-600" id="email-error">Your password must be less than 4 characters.</p> --}}
                            </div>
                        @elseif($key === 'address_state')
                            <x-dashboard.form.select field="user_meta.{{ $key }}" 
                                selected="user_meta.{{ $key }}" 
                                :items="[]" 
                                :search="true" 
                                :nullable="false"
                                x-show-if="{{ json_encode(\Countries::getCountriesWithStates()) }}.includes(user_meta.address_country)" 
                                x-append-to-init="
                                    $nextTick(() => {
                                        let us_states = {{ json_encode(\Countries::getStatesOfUS()) }};
                                        let ca_states = {{ json_encode(\Countries::getStatesOfCA()) }};
                                        let au_states = {{ json_encode(\Countries::getStatesOfAU()) }};

                                        if(user_meta.address_country === 'US') {
                                            items = us_states;
                                            displayed_items = us_states;
                                        } else if(user_meta.address_country === 'CA') {
                                            items = ca_states;
                                            displayed_items = ca_states;
                                        } else if(user_meta.address_country === 'AU') {
                                            items = au_states;
                                            displayed_items = au_states;
                                        }

                                        $watch('user_meta.address_country', (value) => {
                                            user_meta.{{ $key }} = '';

                                            if(value === 'US') {
                                                items = us_states;
                                                displayed_items = us_states;
                                            } else if(value === 'CA') {
                                                items = ca_states;
                                                displayed_items = ca_states;
                                            } else if(value === 'AU') {
                                                items = au_states;
                                                displayed_items = au_states;
                                            }
                                        });
                                    });
                                " />
                        @elseif(($options['type']??'string') == 'string')
                            <x-dashboard.form.input field="user_meta.{{ $key }}" />
                        @elseif(($options['type']??'string') == 'date')
                            <x-dashboard.form.date field="user_meta.{{ $key }}" />
                        @elseif(($options['type']??'string') == 'select' && $key === 'address_country')
                            <x-dashboard.form.select field="user_meta.{{ $key }}" selected="user_meta.{{ $key }}" :items="\Countries::getCodesForSelect(as_array: true)" :search="true" :nullable="false" />
                        @elseif(($options['type']??'string') == 'select')
                            <x-dashboard.form.select field="user_meta.{{ $key }}" selected="user_meta.{{ $key }}" :items="\App\Models\UserMeta::metaSelectValues($key)" />
                        @endif
                    </div>
                </div>
            @endforeach
        @endif

        {{-- Password --}}
        <div class="mb-3">
            <label class="block text-16 font-medium text-gray-700">{{ translate('Password') }}</label>

            <div class="mt-1 relative rounded-md shadow-sm">
                <input type="password" class="form-standard @error('password') is-invalid @enderror"
                    wire:model.defer="password" data-test="we-register-password">

                <x-system.invalid-icon field="password" />
            </div>

            <x-system.invalid-msg field="password" />
        </div>
        {{-- END Password --}}

        {{-- Password Confirmation --}}
        <div class="mb-4">
            <label class="block text-16 font-medium text-gray-700">{{ translate('Password confirmation') }}</label>

            <div class="mt-1 relative rounded-md shadow-sm">
                <input type="password" class="form-standard @error('password_confirmation') is-invalid @enderror"
                    wire:model.defer="password_confirmation" data-test="we-register-password-confirmation">

                <x-system.invalid-icon field="password_confirmation" />
            </div>

            <x-system.invalid-msg field="password_confirmation" />
        </div>
        {{-- END Password Confirmation --}}

        {{-- Consent Terms and Conditions --}}
        <div class="mb-2 flex items-center justify-between">
            <div class="w-full relative flex items-start ml-1">
                <div class="flex items-center h-5">
                    <input id="register-form-terms-consent" type="checkbox" wire:model.defer="terms_consent"
                        data-test="we-register-terms-consent" class="form-checkbox-standard">
                </div>
                <div class="ml-3 text-sm">
                    <label for="register-form-terms-consent"
                        class=font-medium text-gray-700 inline @error('terms_consent') text-danger @enderror">
                        <span>
                            {{ translate('By Registering I agree to ') }} {{ get_site_name() }}
                        </span>
                        <a href="{{ get_tenant_setting('tos_url', '#')  }}" target="_blank" class="text-primary">
                            {{ translate('Terms of Service') }}
                        </a>
                    </label>

                    <x-system.invalid-msg field="terms_consent" />
                </div>
            </div>
        </div>
        {{-- END Consent Terms and Conditions --}}

        {{-- Register Action --}}
        <div class="mb-3">
            <button type="submit" class="btn bg-primary text-white w-full mt-2"
                @click="
                    $wire.set('entity', entity, true);
                    @if(collect(get_tenant_setting('user_meta_fields_in_use'))->where('registration', true)->count() > 0)
                        @foreach(collect(get_tenant_setting('user_meta_fields_in_use'))->where('registration', true) as $key => $options)
                            @if(($options['type']??'string') == 'select' || ($options['type']??'string') == 'date' || $key == 'company_vat')
                                $wire.set('user_meta.{{ $key }}', user_meta.{{ $key }}, true);
                            @endif
                        @endforeach
                    @endif

                    console.log(user_meta);
                "
                data-test="we-register-submit">
                {{ translate('Register')}}
            </button>
        </div>
        {{-- END Register Action --}}

        <div class="text-center" @click="console.log(user_meta);">
            <span class="text-12 w-full text-muted">{{ translate('Already have an account?') }}</span>
            <a class="text-12 font-semibold" href="{{ route('user.login') }}">
                {{ translate('Sign In') }}
            </a>

            {{-- <a class="text-12 font-semibold" href="{{ route('business.register') }}">
                {{ translate('Business Sign Up') }}
            </a> --}}
        </div>
    </div>
</form>

@push('head_scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.11/themes/airbnb.min.css">
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
