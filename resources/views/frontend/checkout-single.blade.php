@extends('frontend.layouts.blank') 

@section('meta_title'){{ translate('Checkout page').' '.\TenantSettings::get('site_name').' | '.\TenantSettings::get('site_motto') }}@stop

@section('meta_keywords'){{ translate('checkout, cart, purchase, ecommerce') }}@stop

@section('meta')

@endsection

@push('head_scripts')
    <link rel="stylesheet" href="{{ static_asset('css/tailwind.css', false, true, true) }}" />
@endpush

@section('content')
    <div class="flex justify-center after:content-[''] after:fixed after:w-1/2 after:right-0 after:bg-white after:z-[1] after:h-full after:shadow-xl
                before:content-[''] before:fixed before:w-1/2 before:left-0 before:bg-white before:z-0 before:h-full">
        
            {{-- <div class="w-1/2 flex flex-col justify-center items-end pl-3 md:pl-0 bg-white">
                
            </div>
            <div class="w-1/2 shadow flex flex-col justify-center items-start pr-3 md:pr-0 bg-white">
                
            </div> --}}

        <div class="relative w-full md:max-w-[920px] flex flex-wrap justify-between items-start self-center z-10 py-[60px]">
            <div class="w-full md:max-w-[400px]">
                <x-default.system.tenant.logo class="block p-0 max-w-[120px]" ></x-default.system.tenant.logo>

                @if($models->isNotEmpty())
                    
                        <div class="item-summary w-full flex-col">
                            <div class="pb-1 mb-3 border-b border-gray-200">
                                <strong class="flex">{{ translate('Checkout summary') }}</strong>
                                <span class="text-36 tracking-[-0.03rem]">{{ $from_cart ? (CartService::getSubtotalPrice()['display'] ?? '') : $model->getTotalPrice('display') }}</span>
                            </div>

                            <ul class="flex flex-col list-none space-y-4">
                                @foreach($models as $model)
                                <li class="w-full flex flex-col justify-left">
                                    <div class="w-full flex justify-left">
                                        <div class="w-[50px] h-[50px] shrink-0">
                                            <img class="w-[50px] h-[50px] object-cover rounded border" src="{{ $model->getThumbnail() }}" />
                                        </div>
                                        <div class="w-full flex flex-col">
                                            <div class="w-full flex justify-between pl-4">
                                                <strong class="line-clamp-1">{{ $model->getTranslation('title') ?: $model->getTranslation('name') }}</strong>
                                                <strong>{{ FX::formatPrice($model->base_price * $model->purchase_quantity)  }}</strong>
                                            </div>
                                            <div class="w-full leading-4 pl-4">
                                                <small class="line-clamp-1">{{ $model->getTranslation('excerpt') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>

                            <ul class="flex flex-col list-none border-t border-gray-200 mt-3 pl-[74px]">
                                <li class="flex justify-between border-b border-gray-200 pt-[16px] pb-[12px]">
                                    <span class="text-14">{{ translate('Subtotal') }}</span>
                                    <strong class="tracking-[-0.03rem] text-14">{{ $from_cart ? (CartService::getSubtotalPrice()['display'] ?? '') : $model->getDiscountedPrice('display') }}</strong>
                                </li>
                                <li class="flex justify-between border-b border-gray-200 pt-[16px] pb-[12px]">
                                    <span class="text-14">{{ translate('Discount') }}</span>
                                    <strong class="tracking-[-0.03rem] text-14">-{{ $from_cart ? (CartService::getDiscountAmount()['display'] ?? '') : FX::formatPrice($model->total_price - $model->discounted_price) }}</strong>
                                </li>
                                <li class="flex justify-between border-b border-gray-200 pt-[16px] pb-[12px]">
                                    <span class="text-14">{{ translate('Taxation') }}</span>
                                    <strong class="tracking-[-0.03rem] text-14">{{ FX::formatPrice($model->tax) }}</strong>
                                </li>
                                <li class="flex justify-between border-b border-gray-200 py-[16px]">
                                    <button type="button" class="btn-success !py-1 !px-3">{{ translate('Add promo code') }}</button>
                                </li>
                                <li class="flex justify-between pt-[16px] pb-[12px]">
                                    <span class="text-14">{{ translate('Total due') }}</span>
                                    <strong class="tracking-[-0.03rem] text-14">{{ $from_cart ? (CartService::getSubtotalPrice()['display'] ?? '') : $model->getTotalPrice('display') }}</strong>
                                </li>
                            </ul>

                            <div class="mt-1 pt-2 flex justify-start border-t border-gray-200">
                                <div class="flex flex-row items-center pr-4 relative after:content-[''] after:absolute after:right-0 after:bg-gray-300 after:h-[15px] after:top-[8px] after:w-[1px]">
                                    <span class="text-12 mr-1 pt-1">{{ translate('Powered by') }}</span>

                                    <a style="max-width: 120px !important;" class="navbar-brand p-0 mw-100" href="https://we-saas.com/" aria-label="Gunob">
                                        <img src="https://images.ev-saas.com/insecure/fill/0/0/ce/0/plain/https://we-saas.com/wp-content/uploads/2021/12/cropped-Screenshot_2021-12-22_at_15.12.45-removebg-preview.png" style="max-width: 100%;" height="auto" alt="">
                                    </a>
                                    {{-- <x-default.system.tenant.logo style="max-width: 50px !important;"></x-default.system.tenant.logo> --}}
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
                            </div>
                        </div>
                    
                @endif
                

            </div>
            <div class="w-full md:max-w-[400px] ">
                <h1 class="font-semibold text-20 ">{{ translate('Payment information') }}</h1>
                <livewire:forms.checkout-single-form :items="$models" :from-cart="$from_cart"></livewire:forms.checkout-single-form>
            </div>
        </div>
        

    </div>
@endsection

@section('modal')

@endsection

@push('footer_scripts')
    {{-- <script src="{{ static_asset('vendor/hs-add-field/dist/hs-add-field.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js', false, true) }}"></script>

    <script src="{{ static_asset('vendor/hs.select2.js', false, true) }}"></script>

    <script src="{{ static_asset('js/crud/checkout-form.js', false, true, true) }}"></script> --}}
@endpush
