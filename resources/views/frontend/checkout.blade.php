@extends('frontend.layouts.' . $globalLayout)

@section('meta_title'){{ translate('Checkout page').' '.\TenantSettings::get('site_name').' | '.\TenantSettings::get('site_motto') }}@stop

@section('meta_keywords'){{ translate('checkout, cart, purchase, ecommerce') }}@stop

@section('meta')

@endsection

@section('content')
    <section class="checkout position-relative my-5"
        x-data="{
            selected_shipping_method: 0,
            same_billing_shipping: {{ ((request()->old('same_billing_shipping') ?? 'on') === 'off') ? 'false' : 'true' }},
            create_account: {{ ((request()->old('create_account') ?? 'off') === 'off') ? 'false' : 'true' }},
            newsletter: {{ ((request()->old('newsletter') ?? 'off') === 'off') ? 'false' : 'true' }},
            available_payment_methods: @js(\PaymentMethodsUniversal::getPaymentMethodsGateway()),
            selected_payment_method: '{{ request()->old('payment_method') }}'
        }"
    >
        <form method="POST" action="" name="checkout-form" class="container">
            <div class="row">
                <div class="col-lg-8">

                    @error('general')
                        <div class="alert alert-danger media" role="alert">
                            <i class="tio-warning mt-1 mr-1"></i>
                            <div class="media-body" role="alert">
                                {{ $message }}
                            </div>
                        </div>
                    @enderror

                    <div class="bg-white rounded card">

                        <div class="card-body">
                            <div class="border-bottom pb-2 mb-3">
                                <h3 class="card-header-title">{{ translate('Billing and shipping information') }}</h3>
                            </div>

                            <!-- Content -->
                            <div class="container">

                                <!-- Form -->
                                <div>
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-12 ">
                                            <label for="checkout_email" class="form-label">{{ translate('Email') }}</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="checkout_email" value="{{ request()->old('email') }}" placeholder="you@example.com">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- End Col -->

                                        <!-- Billing info -->

                                        <div class="col-sm-6 mt-3">
                                            <label for="checkout_billing_first_name" class="form-label">{{ translate('First name') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('billing_first_name') is-invalid @enderror" name="billing_first_name" id="checkout_billing_first_name" value="{{ request()->old('billing_first_name') }}"  placeholder="" value="" required>
                                            @error('billing_first_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-sm-6 mt-3">
                                            <label for="checkout_billing_last_name" class="form-label">{{ translate('Last name') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('billing_last_name') is-invalid @enderror" name="billing_last_name" id="checkout_billing_last_name" value="{{ request()->old('billing_last_name') }}" placeholder="" required>
                                            @error('billing_last_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-12 mt-3">
                                            <label for="checkout_billing_company" class="form-label"> {{ translate('Company (optional)') }}</label>
                                            <input type="text" class="form-control @error('billing_company') is-invalid @enderror" name="billing_company" id="checkout_billing_company" value="{{ request()->old('billing_company') }}">
                                            @error('billing_company')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- End Col -->

                                        <!-- Billing Address -->
                                        @php
                                            $manual_mode_billing = !\Auth::check() || auth()->user()->addresses->isEmpty();
                                            $manual_mode_shipping = !\Auth::check() || auth()->user()->addresses->isEmpty();
                                            $show_addresses = \Auth::check() && auth()->user()->addresses->isNotEmpty();
                                            $addresses = \Auth::check()  ? auth()->user()->addresses->map(function($item) {
                                                $item->country = \Countries::get(code: $item->country)->name ?? translate('Unknown');
                                                return $item;
                                            }) : [];
                                            $selected_billing_address_id = \Auth::check() && empty(request()->old('selected_billing_address_id')) ?
                                                (auth()->user()->addresses->firstWhere('is_primary', true)->id ?? '') : request()->old('selected_billing_address_id');
                                            $selected_shipping_address_id = \Auth::check() && empty(request()->old('selected_shipping_address_id')) ?
                                                (auth()->user()->addresses->firstWhere('is_primary', true)->id ?? '') : request()->old('selected_shipping_address_id');

                                            if((int) $selected_billing_address_id === -1)
                                                $manual_mode_billing = true;

                                            if((int) $selected_shipping_address_id === -1)
                                                $manual_mode_shipping = true;
                                        @endphp

                                        <div class="d-flex flex-wrap mt-3" x-cloak x-data="{
                                            manual_mode: @js($manual_mode_billing),
                                            show_addresses: @js($show_addresses),
                                            addresses: @js($addresses),
                                            selected_billing_address_id: Number(@js($selected_billing_address_id))
                                        }">
                                            <h4 class="col-12" >
                                                {{ translate('Billing address:') }}
                                            </h4>

                                            <template x-if="show_addresses">
                                                <template x-for="address in addresses">
                                                    <div class="col-12 col-md-6 col-lg-4 mb-3 px-2">
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
                                                    </div>
                                                </template>
                                            </template>

                                            <template x-if="show_addresses">
                                                <input type="hidden" name="selected_billing_address_id" x-model="selected_billing_address_id">
                                            </template>

                                            <div class="col-12 col-md-6 col-lg-4 mb-3 px-2" x-show="show_addresses">
                                                <div class="card w-100 pointer h-100 position-relative"
                                                     :class="{ 'border-primary shadow' : selected_billing_address_id === -1 }"
                                                     @click="selected_billing_address_id = -1; manual_mode = true;">
                                                    <div class="card-body position-relative d-flex align-items-center justify-content-center">
                                                        <span class="text-center">{{ translate('Add billing address manually') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex-wrap mt-3" :class="{'d-flex':manual_mode}" x-show="manual_mode">
                                                <div class="col-12">
                                                    <label for="checkout_billing_address" class="form-label">{{ translate('Address') }} <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('billing_address') is-invalid @enderror" name="billing_address" id="checkout_billing_address"
                                                           value="{{ request()->old('billing_address') }}" placeholder="1234 Main St">
                                                    @error('billing_address')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-md-6 mt-3">
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

                                                <!-- END Billing info -->


                                                <!-- Add Phone number -->
                                                <!-- TODO: Add a proper phone validation rules and error msgs (has to be integrated with HSAddField) -->
                                                <div class="col-12 mt-3">
                                                    <!-- Form Group -->
                                                    @php
                                                        $phone_numbers = empty(request()->old('phone_numbers')) ? [''] : array_filter(request()->old('phone_numbers') ?? ['']);
                                                    @endphp
                                                    <div class="row form-group mb-2"
                                                         x-data="{
                                                            phones_limit: 3,
                                                            phoneNumbers: @js($phone_numbers),
                                                            addNewPhoneNumber() {
                                                                if(this.phoneNumbers.length < 3)
                                                                    this.phoneNumbers.push('');
                                                            },
                                                            removePhoneNumber(index) {
                                                                this.phoneNumbers.splice(index, 1);
                                                            },
                                                         }"
                                                    >
                                                        <label for="phoneFieldLabel" class="col-sm-12 col-form-label input-label">
                                                            {{ translate('Phones') }}
                                                        </label>

                                                        <div class="col-sm-12">
                                                            <template x-if="phoneNumbers.length <= 1">
                                                                <div class="d-flex">
                                                                    <input type="text" class="form-control"
                                                                           placeholder="{{ translate('Phone number 1') }}"
                                                                           x-model="phoneNumbers[0]">
                                                                </div>
                                                            </template>
                                                            <template x-if="phoneNumbers.length > 1">
                                                                <template x-for="[key, value] of Object.entries(phoneNumbers)">
                                                                    <div class="d-flex" :class="{'mt-2': key > 0}">
                                                                        <input type="text" class="form-control"
                                                                               x-bind:placeholder="'{{ translate('Phone number') }} '+(Number(key)+1)"
                                                                               x-model="phoneNumbers[key]">
                                                                        <template x-if="key > 0">
                                                                            <span class="ml-2 d-flex align-items-center pointer" @click="removePhoneNumber(key)">
                                                                                @svg('heroicon-o-trash', ['class' => 'square-22 text-danger'])
                                                                            </span>
                                                                        </template>
                                                                    </div>
                                                                </template>
                                                            </template>

                                                            <template x-if="phoneNumbers.length < phones_limit">
                                                                <a href="javascript:;"
                                                                   class="js-create-field form-link btn btn-xs btn-no-focus btn-ghost-primary"
                                                                   @click="addNewPhoneNumber()">
                                                                    <i class="tio-add"></i> {{ translate('Add phone') }}
                                                                </a>
                                                            </template>
                                                        </div>

                                                        <template x-for="[key, phone_number] of Object.entries(phoneNumbers)">
                                                            <input type="hidden" name="phone_numbers[]" class="" x-model="phoneNumbers[key]">
                                                        </template>

                                                    </div>
                                                    <!-- End Form Group -->

                                                    @error('phone_numbers')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Billing Address -->


                                    </div>

                                    <hr class="my-3">

                                    <div class="d-flex flex-column">
                                        <!-- Checkbox -->
                                        <div class="js-form-message mb-2">
                                            <div class="custom-control custom-checkbox d-flex align-items-center text-muted">
                                                <input type="checkbox" class="custom-control-input" id="same_billing_shipping" name="same_billing_shipping"
                                                       x-model="same_billing_shipping">
                                                <label class="custom-control-label" for="same_billing_shipping">
                                                    <small>{{ translate('My billing and delivery information are the same.') }}</small>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- End Checkbox -->

                                        <div class="js-form-message mb-2">
                                            <div class="custom-control custom-checkbox d-flex align-items-center text-muted">
                                                <input type="checkbox" class="custom-control-input" id="checkout_newsletter" name="newsletter"
                                                x-model="newsletter">
                                                <label class="custom-control-label" for="checkout_newsletter">
                                                    <small>{{ translate('Please send me emails with exclusive info') }}</small>
                                                </label>
                                                </div>
                                        </div>
                                        <!-- End Checkbox -->

                                        @guest
                                            <div class="js-form-message mb-2">
                                                <div class="custom-control custom-checkbox d-flex align-items-center text-muted">
                                                    <input type="checkbox" class="custom-control-input" id="checkout_create_account" name="create_account"
                                                           x-model="create_account">
                                                    <label class="custom-control-label" for="checkout_create_account">
                                                        <small>{{ translate('Create account for easier shopping in the future?') }}</small>
                                                    </label>
                                                </div>
                                            </div>
                                        <!-- End Checkbox -->
                                        @endguest
                                    </div>

                                    <hr class="my-3">

                                    <!-- Create account -->
                                    @guest
                                        <div class="row pb-3" x-show="create_account">
                                            <h5 class="col-12 ">{{ translate('Create account') }}</h5>

                                            <div class="col-sm-6 mt-3">
                                                <label for="checkout_account_password" class="form-label">{{ translate('Password') }} <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control @error('account_password') is-invalid @enderror" name="account_password" id="checkout_account_password" value="{{ request()->old('shipping_first_name') }}"  >

                                                @error('account_password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-sm-6 mt-3">
                                                <label for="checkout_account_password_confirmation" class="form-label">{{ translate('Confirm password') }} <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control @error('account_password_confirmation') is-invalid @enderror" name="account_password_confirmation" id="checkout_account_password_confirmation" value="{{ request()->old('shipping_first_name') }}"  >

                                                @error('account_password_confirmation')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr class="my-3" x-show="create_account">
                                    @endguest



                                    <!-- Shipping Address -->
                                    <template x-if="!same_billing_shipping">
                                        <div class="row mt-3" x-cloak x-data="{
                                            manual_mode: @js($manual_mode_shipping),
                                            show_addresses: @js($show_addresses),
                                            addresses: @js($addresses),
                                            selected_shipping_address_id: Number(@js($selected_shipping_address_id))
                                        }">
                                            <h4 class="col-12">
                                                {{ translate('Shipping address:') }}
                                            </h4>

                                            <template x-if="show_addresses">
                                                <template x-for="address in addresses">
                                                    <div class="col-12 col-md-6 col-lg-4 mb-3 px-2">
                                                        <div class="card w-100 pointer h-100 position-relative"
                                                             :class="{ 'border-primary shadow' : selected_shipping_address_id === address.id }"
                                                             @click="selected_shipping_address_id = address.id; manual_mode = false;">
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
                                                    </div>
                                                </template>
                                            </template>

                                            <template x-if="show_addresses">
                                                <input type="hidden" name="selected_shipping_address_id" x-model="selected_shipping_address_id">
                                            </template>

                                            <div class="col-12 col-md-6 col-lg-4 mb-3 px-2" x-show="show_addresses">
                                                <div class="card w-100 pointer h-100 position-relative"
                                                     :class="{ 'border-primary shadow' : selected_shipping_address_id === -1 }"
                                                     @click="selected_shipping_address_id = -1; manual_mode = true;">
                                                    <div class="card-body position-relative d-flex align-items-center justify-content-center">
                                                        <span class="text-center">{{ translate('Add shipping address manually') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex-wrap mt-3" :class="{'d-flex':manual_mode}" x-show="manual_mode">
                                                <div class="col-12">
                                                    <label for="checkout_shipping_address" class="form-label">{{ translate('Address') }} <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('shipping_address') is-invalid @enderror" name="shipping_address" id="checkout_shipping_address" value="{{ request()->old('shipping_address') }}" placeholder="1234 Main St" >
                                                    @error('shipping_address')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-md-6 mt-3">
                                                    <label for="checkout_shipping_country" class="form-label">{{ translate('Country') }} <span class="text-danger">*</span></label>

                                                    <!-- Select -->
                                                    <select class="form-control custom-select @error('shipping_country') is-invalid @enderror" name="shipping_country" id="checkout_shipping_country">
                                                        <option value="">{{ translate('Choose...') }}</option>
                                                        @foreach(\Countries::getAll() as $country)
                                                            <option value="{{ $country->code }}" {{ request()->old('shipping_country') === $country->code ? 'selected':'' }}>{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <!-- End Select -->

                                                    @error('shipping_country')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-md-6 mt-3">
                                                    <label for="checkout_shipping_state" class="form-label">{{ translate('State') }} <span class="text-danger">*</span></label>

                                                    <!-- Input -->
                                                    <input type="text" class="form-control @error('shipping_state') is-invalid @enderror" name="shipping_state" id="checkout_shipping_state"
                                                           value="{{ request()->old('shipping_state') }}" placeholder="(write country if there's no state)">
                                                    <!-- End Input -->

                                                    @error('shipping_state')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-md-6 mt-3">
                                                    <label for="checkout_shipping_city" class="form-label" >{{ translate('City') }}<span class="text-danger">*</span></label>

                                                    <!-- Input -->
                                                    <input type="text" class="form-control @error('shipping_city') is-invalid @enderror" name="shipping_city" id="checkout_shipping_city"
                                                           value="{{ request()->old('shipping_city') }}" placeholder="">
                                                    <!-- End Input -->

                                                    @error('shipping_city')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mt-3">
                                                    <label for="checkout_shipping_zip" class="form-label ">{{ translate('ZIP') }} <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('shipping_zip') is-invalid @enderror" name="shipping_zip" id="checkout_shipping_zip"
                                                           value="{{ request()->old('shipping_zip') }}" placeholder="">

                                                    @error('shipping_zip')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <!-- End Col -->

                                                <!-- END Billing info -->
                                            </div>
                                        </div>
                                    </template>

                                    <!-- End Shipping Address -->

{{--                                    <div class="row pb-3" x-show="!same_billing_shipping">--}}
{{--                                        <h5 class="col-12 ">{{ translate('Shipping address') }}</h5>--}}

{{--                                        <div class="col-sm-6 mt-3">--}}
{{--                                            <label for="checkout_shipping_first_name" class="form-label">{{ translate('First name') }} <span class="text-danger">*</span></label>--}}
{{--                                            <input type="text" class="form-control @error('shipping_first_name') is-invalid @enderror" name="shipping_first_name" id="checkout_shipping_first_name" value="{{ request()->old('shipping_first_name') }}"  placeholder="" >--}}

{{--                                            @error('shipping_first_name')--}}
{{--                                                <div class="invalid-feedback">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                        <!-- End Col -->--}}

{{--                                        <div class="col-sm-6 mt-3">--}}
{{--                                            <label for="checkout_shipping_last_name" class="form-label">{{ translate('Last name') }} <span class="text-danger">*</span></label>--}}
{{--                                            <input type="text" class="form-control @error('shipping_last_name') is-invalid @enderror" name="shipping_last_name" id="checkout_shipping_last_name" value="{{ request()->old('shipping_last_name') }}" placeholder="" >--}}
{{--                                            @error('shipping_last_name')--}}
{{--                                                <div class="invalid-feedback">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                        <!-- End Col -->--}}

{{--                                        <div class="col-12 mt-3">--}}
{{--                                            <label for="checkout_shipping_company" class="form-label"> {{ translate('Company (optional)') }}</label>--}}
{{--                                            <input type="text" class="form-control @error('shipping_company') is-invalid @enderror" name="shipping_company" id="checkout_shipping_company" value="{{ request()->old('shipping_company') }}">--}}
{{--                                            @error('shipping_company')--}}
{{--                                                <div class="invalid-feedback">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                        <!-- End Col -->--}}

{{--                                        <div class="col-12 mt-3">--}}
{{--                                            <label for="checkout_shipping_address" class="form-label">{{ translate('Address') }} <span class="text-danger">*</span></label>--}}
{{--                                            <input type="text" class="form-control @error('shipping_address') is-invalid @enderror" name="shipping_address" id="checkout_shipping_address" value="{{ request()->old('shipping_address') }}" placeholder="1234 Main St" >--}}
{{--                                            @error('shipping_address')--}}
{{--                                                <div class="invalid-feedback">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                        <!-- End Col -->--}}

{{--                                        <div class="col-md-6 mt-3">--}}
{{--                                            <label for="checkout_shipping_country" class="form-label">{{ translate('Country') }} <span class="text-danger">*</span></label>--}}

{{--                                            <!-- Select -->--}}
{{--                                            <select class="form-control custom-select" name="shipping_country" id="checkout_shipping_country">--}}
{{--                                                <option value="">{{ translate('Choose...') }}</option>--}}
{{--                                                @foreach(\Countries::getAll() as $country)--}}
{{--                                                    <option value="{{ $country->code }}" {{ request()->old('billing_country') === $country->code ? 'selected':'' }}>{{ $country->name }}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                            <!-- End Select -->--}}

{{--                                            @error('shipping_country')--}}
{{--                                                <div class="invalid-feedback d-block">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                        <!-- End Col -->--}}

{{--                                        <div class="col-md-6 mt-3">--}}
{{--                                            <label for="checkout_shipping_state" class="form-label">{{ translate('State') }} <span class="text-danger">*</span></label>--}}

{{--                                            <!-- Input -->--}}
{{--                                            <input type="text" class="form-control @error('shipping_state') is-invalid @enderror" name="shipping_state" id="checkout_shipping_state"--}}
{{--                                                   value="{{ request()->old('shipping_state') }}" placeholder="(write country if there's no state)" >--}}
{{--                                            <!-- End Input -->--}}

{{--                                            @error('shipping_state')--}}
{{--                                                <div class="invalid-feedback">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                        <!-- End Col -->--}}

{{--                                        <div class="col-md-6 mt-3">--}}
{{--                                            <label for="checkout_shipping_city" class="form-label">{{ translate('City') }}<span class="text-danger">*</span></label>--}}

{{--                                            <!-- Input -->--}}
{{--                                            <input type="text" class="form-control @error('shipping_city') is-invalid @enderror" name="shipping_city" id="checkout_shipping_city"--}}
{{--                                                   value="{{ request()->old('shipping_city') }}" placeholder="" >--}}
{{--                                            <!-- End Input -->--}}

{{--                                            @error('shipping_city')--}}
{{--                                                <div class="invalid-feedback">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}

{{--                                        <div class="col-md-6 mt-3">--}}
{{--                                            <label for="checkout_shipping_zip" class="form-label">{{ translate('ZIP') }} <span class="text-danger">*</span></label>--}}
{{--                                            <input type="text" class="form-control @error('shipping_zip') is-invalid @enderror" name="shipping_zip" id="checkout_shipping_zip"--}}
{{--                                                   value="{{ request()->old('shipping_zip') }}" placeholder="" >--}}

{{--                                            @error('shipping_zip')--}}
{{--                                                <div class="invalid-feedback">--}}
{{--                                                    {{ $message }}--}}
{{--                                                </div>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                        <!-- End Col -->--}}
{{--                                    </div>--}}
                                    <!-- END Shipping info -->

                                    <hr class="my-5 mb-4" x-show="!same_billing_shipping" x-cloak>


                                    <!-- Payment Methods -->
                                    <div class="mb-5" x-data="{}">
                                        <h4 class="mb-3">{{ translate('Payment methods') }}</h4>

                                        <!-- Radio Checkbox Group -->
                                        <div class="row mx-n2">
                                            <template x-for="payment_method_name in available_payment_methods">
                                                <div class="col-6 col-md-3 px-2 mb-3 mb-md-0" @click="selected_payment_method = payment_method_name; ">
                                                    <div class="custom-control custom-radio custom-control-inline checkbox-outline checkbox-icon text-center w-100 h-100">
                                                        <label class="checkbox-outline-label checkbox-icon-label w-100 rounded py-3 px-3 mb-0 d-flex flex-column justify-content-center align-items-center"
                                                            :class="{'border border-info':payment_method_name === selected_payment_method}">
                                                            <img class="img-fluid mb-3" style="height: 30px" x-bind:src="'{{ static_assets_root(path:'images', theme: true) }}/'+payment_method_name.replace('_','-')+'-logo-transparent.png'" alt="SVG" >
                                                            <span class="d-block" x-text="payment_method_name"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </template>
                                            
                                            {{-- <div class="col-6 col-md-3 px-2 mb-3 mb-md-0">
                                                <div class="custom-control custom-radio custom-control-inline checkbox-outline checkbox-icon text-center w-100 h-100">
                                                    <input type="radio" id="checkout_payment_stripe" name="payment_method" x-model="selected" value="stripe" class="custom-control-input checkbox-outline-input checkbox-icon-input" x-bind:checked="selected === 'stripe'">
                                                    <label class="checkbox-outline-label checkbox-icon-label w-100 rounded py-3 px-3 mb-0" for="checkout_payment_stripe">
                                                        <img class="img-fluid w-75 mb-3" src="{{ static_asset(path: 'images/stripe-logo-transparent-512.png', theme: true) }}" alt="SVG" >
                                                        <span class="d-block">{{ translate('Stripe') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 px-2">
                                                <div class="custom-control custom-radio custom-control-inline checkbox-outline checkbox-icon text-center w-100 h-100">
                                                    <input type="radio" id="checkout_payment_paypal" name="payment_method" x-model="selected" value="paypal" class="custom-control-input checkbox-outline-input checkbox-icon-input" x-bind:checked="selected === 'paypal'">
                                                    <label class="checkbox-outline-label checkbox-icon-label w-100 rounded py-3 px-3 mb-0" for="checkout_payment_paypal">
                                                        <img class="img-fluid w-75 mb-3" src="{{ static_asset(path: 'images/paypal-logo-transparent-512.png', theme: true) }}" alt="SVG" >
                                                        <span class="d-block">{{ translate('Paypal') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 px-2">
                                                <div class="custom-control custom-radio custom-control-inline checkbox-outline checkbox-icon text-center w-100 h-100">
                                                    <input type="radio" id="checkout_payment_paysera" name="payment_method" x-model="selected" value="paysera" class="custom-control-input checkbox-outline-input checkbox-icon-input" x-bind:checked="selected === 'paysera'">
                                                    <label class="checkbox-outline-label checkbox-icon-label w-100 rounded py-3 px-3 mb-0" for="checkout_payment_paysera">
                                                        <img class="img-fluid w-75 mb-3" src="{{ static_asset(path: 'images/paysera-logo-transparent-512.png', theme: true) }}" alt="SVG" >
                                                        <span class="d-block">{{ translate('Paysera') }}</span>
                                                    </label>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <!-- End Radio Checkbox Group -->

                                        <template x-if="selected_payment_method != ''">
                                            <div class="payment-methods-details w-full mt-3">
                                                @foreach(\PaymentMethodsUniversal::getPaymentMethods() as $payment_method)
                                                <div class="text-12" :class="{'d-none': selected_payment_method !== '{{ $payment_method->gateway }}'}">
                                                    <div class="w-100">
                                                        {!! $payment_method->description !!}
                                                    </div>
                                
                                                    @if($payment_method->gateway === 'stripe')
                                                        {{-- TODO: Add Stripe credit cards --}}
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>
                                        </template>


                                        @error('payment_method')
                                            <div class="invalid-feedback btn btn-danger btn-xs mt-3 w-100 text-center">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <input type="hidden" name="payment_method" id="checkout_payment_method" x-model="selected_payment_method">
                                    </div>
                                    <!-- End Payment Methods -->


{{--                                    <div class="row gy-3" x-show="">--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <label for="ccNameShopCheckout" class="form-label">Name on card</label>--}}
{{--                                            <input type="text" class="form-control " id="ccNameShopCheckout" placeholder="" required>--}}
{{--                                            <small class="text-muted">Full name as displayed on card</small>--}}
{{--                                            <div class="invalid-feedback">--}}
{{--                                                Name on card is required--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <!-- End Col -->--}}

{{--                                        <div class="col-md-6">--}}
{{--                                            <label for="ccNumberShopCheckout" class="form-label">Credit card number</label>--}}
{{--                                            <input type="text" class="form-control " id="ccNumberShopCheckout" placeholder="" required>--}}
{{--                                            <div class="invalid-feedback">--}}
{{--                                                Credit card number is required--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <!-- End Col -->--}}

{{--                                        <div class="col-md-3 mt-3">--}}
{{--                                            <label for="ccExpirationShopCheckout" class="form-label">Expiration</label>--}}
{{--                                            <input type="text" class="form-control " id="ccExpirationShopCheckout" placeholder="" required>--}}
{{--                                            <div class="invalid-feedback">--}}
{{--                                                Expiration date required--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <!-- End Col -->--}}

{{--                                        <div class="col-md-3 mt-3">--}}
{{--                                            <label for="ccCvvShopCheckout" class="form-label">CVV</label>--}}
{{--                                            <input type="text" class="form-control " id="ccCvvShopCheckout" placeholder="" required>--}}
{{--                                            <div class="invalid-feedback">--}}
{{--                                                Security code required--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <!-- End Col -->--}}
{{--                                    </div>--}}
                                    <!-- End Row -->

                                    <hr class="my-4">

                                    <div class="row pb-3">
                                        <div class="col-12">
                                            <label for="checkout_note" class="form-label">{{ translate('Additional information (for courier, for shop etc.)') }}</label>
                                            <textarea type="text" class="form-control @error('note') is-invalid @enderror" name="note" id="checkout_note">{{ request()->old('note') }}</textarea>
                                            @error('note')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <!-- End Col -->
                                    </div>

                                    <hr class="my-4">

                                    <!-- Placing order Actions -->
                                    <div class="row align-items-center">
                                        @if(\CartService::getTotalItemsCount() > 0)
                                            <div class="col-sm-6 order-sm-1 mb-3 mb-sm-0">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary">{{ translate('Place order') }}</button>
                                                    <input type="hidden" name="place_an_order" value="1" />
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-sm-6 order-sm-1 mb-3 mb-sm-0">
                                                <div class="d-grid">
                                                    <div class="btn btn-secondary">{{ translate('No items in cart...') }}</div>
                                                </div>
                                            </div>
                                        @endif
                                        <!-- End Col -->

                                        <div class="col-sm text-left d-flex">
                                            <a class="link d-flex align-items-center justify-content-left text-dark text-14 mr-auto" href="{{ route('cart') }}">
                                                @svg('heroicon-o-chevron-left', ['class' => 'square-16 mr-1'])
                                                <span>{{ translate('Go back to cart') }}</span>
                                            </a>
                                        </div>
                                        <!-- End Col -->
                                    </div>
                                    <!-- End Row -->
                                </div>
                                <!-- End Form -->
                            </div>
                            <!-- End Content -->
                        </div>

                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="bg-white rounded card">
                        <div class="card-body">
                            <div class="border-bottom pb-2 mb-3">
                                <h3 class="card-header-title">{{ translate('Order summary') }}</h3>
                            </div>

                            <div class="">
                                @if($cart_items->isNotEmpty())
                                    @foreach($cart_items as $item)
                                        @php
                                            $has_variations = ($item->hasMain()) ? $item->main->getTranslation('name') : $item->hasVariations();
                                            $name = ($item->hasMain()) ? $item->main->getTranslation('name') : $item->getTranslation('name');
                                            $excerpt = ($item->hasMain()) ? $item->main->getTranslation('excerpt') : $item->getTranslation('excerpt');
                                            $permalink = ($item->hasMain()) ? $item->main->getPermalink() : $item->getPermalink();
                                            $variant_name = ($item->hasMain()) ? $item->getVariantName(key_by: 'name') : null;
                                        @endphp

                                        <!-- Cart Item -->
                                            <div class="border-bottom pb-3 mb-3">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <div class="avatar avatar-lg mr-3">
                                                            <a href="{{ $permalink }}" target="_blank">
                                                                <img class="avatar-img border" src="{{ $item->getThumbnail(['w'=>100,'h'=>100]) }}" alt="{{ $name }}">
                                                                <sup class="avatar-status bg-primary text-white">{{ $item->purchase_quantity }}</sup>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="flex-grow-1">
                                                        <h6 class="clearfix mb-1">
                                                            <div class="badge badge-soft-info float-right">
                                                                {{ \FX::formatPrice($item->purchase_quantity * $item->total_price) }}
                                                            </div>

                                                            <a href="{{ $permalink }}" target="_blank">
                                                                {{ $name }}
                                                            </a>
                                                        </h6>

                                                        @if($has_variations)
                                                            <div class="d-grid">
                                                                @if($variant_name->isNotEmpty())
                                                                    @foreach($variant_name as $attribute_name => $attribute_value)
                                                                        <div class="text-body lh-13">
                                                                            <span class="small">{{ $attribute_name }}:</span>
                                                                            <span class="small">{{ $attribute_value }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        @else
                                                            <span class="clamp text-12 mb-2" data-clamp-lines="2">{{ $excerpt }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Cart Item -->
                                    @endforeach



                                        <!-- Subtotal Calculation -->
                                        <div class="border-bottom pb-2 mb-3">
                                            <div class="d-grid gap-3">
                                                <dl class="row mb-1">
                                                    <dt class="col-sm-6">{{ translate('Items') }} ({{ $total_items_count }})</dt>
                                                    <dd class="col-sm-6 text-right mb-0 "><strong>{{ $originalPrice['display'] }}</strong></dd>
                                                </dl>

                                                @isset($discountedAmount)
                                                <dl class="row mb-1">
                                                    <dt class="col-sm-6">{{ translate('Discount') }}</dt>
                                                    <dd class="col-sm-6 text-right text-success mb-0"><strong>-{{ $discountAmount['display'] }}</strong></dd>
                                                </dl>
                                                @endisset

                                                {{-- TODO: Add Shipping Cost (and shipping  and VAT cost. Is discount calculated when VAT is included in price or not? --}}

                                                <span class="divider divider-third-right py-2"></span>

                                                <dl class="row mb-1">
                                                    <dt class="col-sm-6">{{ translate('Subtotal') }}</dt>
                                                    <dd class="col-sm-6 text-right mb-0 "><strong>{{ $subtotalPrice['display'] }}</strong></dd>
                                                </dl>

                                            </div>
                                        </div>
                                        <!-- End Subtotal Calculation -->

                                        <!-- Shipping Method Selector -->
                                        <div class="border-bottom pb-3 mb-3">
                                            <div class="d-grid gap-3">
                                                <!-- Check -->
                                                <div class="form-check pointer">
                                                    <input class="form-check-input" type="radio" name="deliveryRadioName" id="deliveryRadio1Eg2"
                                                           x-bind:checked="selected_shipping_method === 0"
                                                           @click="selected_shipping_method=0">
                                                    <label class="form-check-label text-dark pointer" for="deliveryRadio1Eg2">
                                                        Free - Standard delivery
                                                        <span class="d-block text-muted small">Shipment may take 10+ business days</span>
                                                    </label>
                                                </div>
                                                <!-- End Check -->

                                                <!-- Check -->
                                                <div class="form-check pointer mt-3">
                                                    <input class="form-check-input" type="radio" name="deliveryRadioName" id="deliveryRadio2Eg2"
                                                           x-bind:checked="selected_shipping_method === 1"
                                                           @click="selected_shipping_method=1">
                                                    <label class="form-check-label text-dark pointer" for="deliveryRadio2Eg2">
                                                        $9.99 - Express delivery
                                                        <span class="d-block text-muted small">Shipment may take 2-3 business days</span>
                                                    </label>
                                                </div>
                                                <!-- End Check -->
                                            </div>
                                        </div>
                                        <!-- End Shipping Method Selector -->

                                        <!-- Total Calculation -->
                                        <div class="mb-3">
                                            <div class="d-grid gap-3">
                                                <dl class="row mb-1">
                                                    <dt class="col-sm-6">{{ translate('Delivery') }}</dt>
                                                    <dd class="col-sm-6 text-right mb-0">Free</dd>
                                                </dl>
                                                <dl class="row mb-0">
                                                    <dt class="col-sm-6 capitalize">{{ translate('Total') }}</dt>
                                                    <dd class="col-sm-6 text-right text-dark mb-0 "><strong>{{ $subtotalPrice['display'] }}</strong></dd>
                                                </dl>
                                            </div>
                                        </div>
                                        <!-- End Total Calculation -->

                                        <!-- Terms and Gateway terms consents -->
                                        <div class="form-group mb-2">
                                            <!-- Checkbox -->
                                            <div class="custom-control custom-checkbox d-flex align-items-center">
                                                <input type="checkbox" name="buyers_consent" id="checkout_buyers_consent" class="custom-control-input indeterminate-checkbox">
                                                <label class="custom-control-label text-14 lh-18" for="checkout_buyers_consent">
                                                    {{ translate('By placing an order, I agree to ') }}
                                                    {{ \TenantSettings::get('site_name') }}
                                                    <a href="#" target="_blank">{{ translate('terms of sale') }}</a>
                                                </label>
{{--                                                <div class="text-muted font-size-1">You will receive notifications about actions to your email.</div>--}}
                                            </div>

                                            @error('buyers_consent')
                                                <div class="invalid-feedback btn btn-danger btn-xs mt-3 w-100 text-center">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <!-- End Terms and Gateway terms consents -->
                                        </div>
                                        <!-- END Total Calculation -->

                                        <div class="d-flex flex-column">
                                            <button type="submit" class="btn btn-primary mt-3">
                                                {{ translate('Place order') }}
                                            </button>

                                            <a href="{{ route('cart') }}" class="d-none align-items-center w-100 justify-content-center text-dark text-12 mt-3">
                                                @svg('heroicon-o-chevron-left', ['class' => 'square-12 mr-1'])
                                                <span>{{ translate('or go back to cart') }}</span>
                                            </a>
                                        </div>
                                @else
                                    <!-- Empty Cart Section -->
                                    <div class="container-fluid space-2">
                                        <div class="text-center mx-md-auto">
                                            <figure class="max-w-10rem max-w-sm-15rem mx-auto mb-3">
                                                @svg('lineawesome-shopping-cart-solid', ['class' => 'text-dark', 'style' => 'width: 72px;'])
                                            </figure>
                                            <div class="mb-5">
                                                <h3 class="h3">{{ translate('Your cart is currently empty') }}</h3>
                                                <p>{{ translate('Before you can checkout you must add some products to your shopping cart.') }}</p>
                                            </div>
                                            <a class="btn btn-primary btn-pill transition-3d-hover px-5" href="{{ route('search') }}">
                                                {{ translate('Start Shopping') }}
                                            </a>
                                        </div>
                                    </div>
                                    <!-- End Empty Cart Section -->
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Order Summary -->
            </div>
        </form>
    </section>
@endsection

@section('modal')

@endsection

@push('footer_scripts')
    <script src="{{ static_asset('vendor/hs-add-field/dist/hs-add-field.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js', false, true) }}"></script>

    <script src="{{ static_asset('vendor/hs.select2.js', false, true) }}"></script>

    <script src="{{ static_asset('js/crud/checkout-form.js', false, true, true) }}"></script>
@endpush
