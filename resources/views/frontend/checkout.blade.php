@extends('frontend.layouts.blank')

@section('meta_title'){{ translate('Checkout page').' '.\TenantSettings::get('site_name').' |
'.\TenantSettings::get('site_motto') }}@stop

@section('meta_keywords'){{ translate('checkout, cart, purchase, ecommerce') }}@stop

@section('meta')

@endsection

@push('head_scripts')

@endpush

@section('content')
<div class="mb-6 px-4 md:px-0 flex justify-center after:content-[''] after:fixed md:after:w-1/2 after:right-0 after:bg-white after:z-[1] after:h-full after:shadow-xl
                before:content-[''] md:before:fixed md:before:w-1/2 md:before:left-0 before:bg-white before:z-0 before:h-full">

    {{-- <div class="w-1/2 flex flex-col justify-center items-end pl-3 md:pl-0 bg-white">

    </div>
    <div class="w-1/2 shadow flex flex-col justify-center items-start pr-3 md:pr-0 bg-white">

    </div> --}}

    <div class="relative w-full md:max-w-[920px] flex flex-wrap justify-between items-start self-center z-10 py-[60px]" x-data="{
        totalPrice: @js(CartService::getTotalPrice()['raw'] ?? 0),
        depositInstallmentPercentage: @js(get_setting('installments_deposit_amount')),
        show_installments_totals: @js(get_setting('allow_installments_in_checkout_flow') && get_setting('are_installments_default_in_checkout_flow')),
    }"
    @display-installments-totals.window="show_installments_totals = true;"
    @hide-installments-totals.window="show_installments_totals = false;"
    >
        <div class="w-full md:max-w-[400px]">
            <x-tenant.system.image alt="{{ get_site_name() }} logo"
            class="block p-0 mb-6 max-w-[160px]" :image="get_site_logo()">
            </x-tenant.system.image>

            @if($models->isNotEmpty())

                <div class="item-summary w-full flex-col mb">
                    <div class="pb-1 mb-3 border-b border-gray-200">
                        <strong class="flex">{{ translate('Checkout summary') }}</strong>
                        <span class="text-36 tracking-[-0.03rem]">
                            {{ CartService::getTotalPrice()['display'] ?? '' }}
                        </span>
                    </div>

                    <ul class="flex flex-col list-none space-y-3">
                        @foreach($models as $model)
                            <li class="w-full flex flex-col justify-left p-3 border rounded border-gray-200">
                                <div class="w-full flex justify-left">
                                    <div class="w-[60px] h-[60px] shrink-0">
                                        <img class="w-[60px] h-[60px] object-cover rounded border"
                                            src="{{ $model->getThumbnail() }}" />
                                    </div>
                                    <div class="w-full flex flex-col">
                                        <div class="w-full flex justify-between items-center pl-4">
                                            <strong class="line-clamp-1 pr-2">{{ $model->name }}</strong>
                                            <x-system.we-price :model="$model" :with-qty="true" class="text-14"></x-system.we-price>
                                        </div>
                                        <div class="w-full leading-4 pl-4">
                                            <small class="line-clamp-1">{{ $model->excerpt }}</small>
                                        </div>
                                        <div class="w-full leading-4 pl-4 mt-1">
                                            <small class="line-clamp-1">{{ translate('Quantity') }}: {{ $model->purchase_quantity }}</small>
                                        </div>
                                    </div>
                                </div>

                                @if(isset($model['purchased_addons']) && $model?->purchased_addons?->isNotEmpty() ?? [])
                                    <ul class="w-full flex flex-col gap-y-2 mt-2">
                                        @foreach($model->purchased_addons as $addon)
                                            <li class="w-full flex items-center border border-gray-200 rounded px-2 py-1">
                                                <div class="flex items-center ">
                                                    <span class="pr-2">+</span>
                                                    <strong class="text-12 line-clamp-1 pr-2">{{ $addon->name }}</strong>
                                                    <span class="text-12 line-clamp-1">{{ translate('Quantity') }}: {{ $addon->purchase_quantity }}</span>
                                                </div>

                                                <x-system.we-price :model="$addon" :with-qty="true" class="ml-auto"></x-system.we-price>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <ul class="flex flex-col list-none border-t border-gray-200 mt-3 pl-[74px]">
                        {{-- Original Price --}}
                        <li class="flex justify-between border-b border-gray-200 pt-[16px] pb-[12px]">
                            <span class="text-14">{{ translate('Items') }}</span>
                            <span class="tracking-[-0.03rem] text-14">{{ CartService::getOriginalPrice()['display'] ?? '' }}</span>
                        </li>

                        {{-- Discount Amount --}}
                        @if(CartService::getDiscountAmount()['raw'] > 0)
                            <li class="flex justify-between border-b border-gray-200 pt-[16px] pb-[12px]">
                                <span class="text-14">{{ translate('Discount') }}</span>
                                <span class="tracking-[-0.03rem] text-14">-{{ CartService::getDiscountAmount()['display'] ?? '' }}</span>
                            </li>
                        @endif

                        {{-- Subtotal --}}
                        <li class="flex justify-between border-b border-gray-200 pt-[16px] pb-[12px]">
                            <span class="text-14">{{ translate('Subtotal') }}</span>
                            <span class="tracking-[-0.03rem] text-14">{{ CartService::getSubtotalPrice()['display'] ?? '' }}</span>
                        </li>

                        {{-- Tax --}}
                        @if(CartService::getTaxAmount()['raw'] > 0)
                            <li class="flex justify-between border-b border-gray-500 pt-[16px] pb-[12px]">
                                <span class="{{ TaxService::isTaxIncluded() ? 'text-12' : 'text-14' }}">{{ translate('Tax') }} {{ TaxService::isTaxIncluded() ? '('.translate('included').')' : '' }}</span>
                                <span class="tracking-[-0.03rem] {{ TaxService::isTaxIncluded() ? 'text-12' : 'text-14' }}">
                                    {{ TaxService::isTaxIncluded() ? '('.(CartService::getTaxAmount()['display'] ?? '').')' : (CartService::getTaxAmount()['display'] ?? '') }}
                                </span>
                            </li>
                        @endif
                        {{-- <li class="flex justify-between border-b border-gray-200 py-[16px]">
                            <button type="button" class="btn-success !py-1 !px-3">{{ translate('Add promo code') }}</button>
                        </li> --}}

                        {{-- Total --}}
                        <li class="flex justify-between pt-[16px] pb-[12px]">
                            <span class="text-14">{{ translate('Total due') }}</span>
                            <strong class="tracking-[-0.03rem] text-14">{{ CartService::getTotalPrice()['display'] ?? '' }}</strong>
                        </li>

                        @if(get_setting('allow_installments_in_checkout_flow'))
                            <div class="w-full border-t border-gray-200 pl-5" x-show="show_installments_totals">
                                <div class="flex justify-between border-b border-gray-200 pt-[16px] pb-[12px]">
                                    <span class="text-14">- {{ translate('Deposit:') }}</span>
                                    <strong class="tracking-[-0.03rem] text-14" x-text="window.FX.formatPrice(totalPrice * depositInstallmentPercentage / 100, 2)"></strong>
                                </div>
                                <div class="flex justify-between border-b border-gray-200 pt-[16px] pb-[12px]">
                                    <span class="text-14">- {{ translate('Main:') }}</span>
                                    <strong class="tracking-[-0.03rem] text-14" x-text="window.FX.formatPrice(totalPrice - (totalPrice * depositInstallmentPercentage / 100), 2)"></strong>
                                </div>
                            </div>
                        @endif
                    </ul>

                    {{-- <div class="mt-1 pt-2 flex justify-start border-t border-gray-200">
                        <div
                            class="flex flex-row items-center pr-4 relative after:content-[''] after:absolute after:right-0 after:bg-gray-300 after:h-[15px] after:top-[8px] after:w-[1px]">
                            <span class="text-12 mr-1 pt-1">{{ translate('Powered by') }}</span>

                            <a style="max-width: 120px !important;" class="navbar-brand p-0 mw-100"
                                href="https://we-saas.com/" aria-label="">
                                <img src="https://images.we-saas.com/insecure/fill/0/0/ce/0/plain/https://we-saas.com/wp-content/uploads/2021/12/cropped-Screenshot_2021-12-22_at_15.12.45-removebg-preview.png"
                                    style="max-width: 100%;" height="auto" alt="">
                            </a>
                            <x-default.system.tenant.logo style="max-width: 50px !important;">
                            </x-default.system.tenant.logo>
                        </div>
                        <ul class="flex flex-row list-none pl-5">
                            <li class="flex pt-1 px-1 mr-1 items-center">
                                <a href="#" class="text-12 text-gray-500">{{ translate('Terms') }}</a>
                            </li>
                            <li class="flex pt-1 px-1 mr-1 items-center">
                                <a href="#" class="text-12 text-gray-500">{{ translate('Privacy') }}</a>
                            </li>
                            <li class="flex pt-1 px-1 mr-1 items-center">
                                <a href="#" class="text-12 text-gray-500">{{ translate('Contact') }}</a>
                            </li>
                        </ul>
                    </div> --}}

                </div>

            @endif


        </div>
        <div class="w-full md:max-w-[400px] ">
            <h1 class="font-semibold text-20 ">{{ translate('Payment information') }}</h1>
            <livewire:forms.checkout-form />
        </div>
    </div>


</div>
@endsection

@section('modal')

@endsection

@push('footer_scripts')

@endpush
