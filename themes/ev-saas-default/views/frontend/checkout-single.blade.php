@extends('frontend.layouts.blank') 

@section('meta_title'){{ translate('Checkout page').' '.\TenantSettings::get('site_name').' | '.\TenantSettings::get('site_motto') }}@stop

@section('meta_keywords'){{ translate('checkout, cart, purchase, ecommerce') }}@stop

@section('meta')

@endsection

@push('head_scripts')
    <link rel="stylesheet" href="{{ static_asset('css/tailwind.css', false, true, true) }}" />
@endpush

@section('content')
    <div class="h-screen flex justify-center after:content-[''] after:fixed after:w-1/2 after:right-0 after:bg-white after:z-[1] after:h-full after:shadow-xl
                before:content-[''] before:fixed before:w-1/2 before:left-0 before:bg-white before:z-0 before:h-full">
        
            {{-- <div class="w-1/2 flex flex-col justify-center items-end pl-3 md:pl-0 bg-white">
                
            </div>
            <div class="w-1/2 shadow flex flex-col justify-center items-start pr-3 md:pr-0 bg-white">
                
            </div> --}}

        <div class="relative w-full md:max-w-[920px] flex flex-wrap justify-between items-start self-center z-10">
            <div class="w-full md:max-w-[400px]">
                <x-default.system.tenant.logo style="max-width: 120px;"></x-default.system.tenant.logo>

                <div class="item-summary w-full flex-col">
                    <div class="pb-3">
                        <strong class="flex">{{ translate('Checkout summary') }}</strong>
                        <span class="text-36 tracking-[-0.03]">{{ $model->getTotalPrice('display') }}</span>
                    </div>

                    <ul class="flex flex-col list-none">
                        <li class="w-full flex justify-left">
                            <div class="w-[50px] h-[50px] shrink-0">
                                <img class="w-[50px] h-[50px] object-cover rounded border" src="{{ $model->getThumbnail() }}" />
                            </div>
                            <div class="w-full flex justify-between pl-4">
                                <strong>{{ $model->getTranslation('title') ?: $model->getTranslation('name') }}</strong>
                                <strong>{{ $model->getBasePrice('display') }}</strong>
                            </div>
                            <div class="w-full pt-2">
                                <small>{{ $model->getTranslation('excerpt') }}</small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="w-full md:max-w-[400px] ">
                asd
            </div>
        </div>
        

    </div>
@endsection

@section('modal')

@endsection

@push('footer_scripts')
    <script src="{{ static_asset('vendor/hs-add-field/dist/hs-add-field.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js', false, true) }}"></script>

    <script src="{{ static_asset('vendor/hs.select2.js', false, true) }}"></script>

    <script src="{{ static_asset('js/crud/checkout-form.js', false, true, true) }}"></script>
@endpush
