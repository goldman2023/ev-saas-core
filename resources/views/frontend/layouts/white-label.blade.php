<!DOCTYPE html>
@if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
    <html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endif
<head>
    {{ seo()->render() }}

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <meta name="file-base-url" content="{{ getFileBaseURL() }}">
    <meta name="file-bucket-url" content="{{ getBucketBaseURL() }}">

    <title>@yield('meta_title', get_setting('website_name').' | '.get_setting('site_motto'))</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="description" content="@yield('meta_description', get_setting('meta_description') )"/>
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords') )">

    @yield('meta')

    @if(!isset($detailedProduct) && !isset($customer_product) && !isset($shop) && !isset($page) && !isset($blog))
        <x-default.system.og-meta>
        </x-default.system.og-meta>
    @endif

    <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">

    <!-- Vendor Styles -->
    <link rel="stylesheet" href="{{ static_asset('vendor/hs-unfold/dist/hs-unfold.min.css', false, true) }}">

    <style>
        :root {
            --primary: yellow;
            --secondary: green;
            --soft-primary: {{ hex2rgba(get_setting('base_color','#e62d04'),.15) }};
        }
    </style>
    <link rel="stylesheet" href="{{ mix('css/app.css', 'themes/ev-saas-default') }}">


    <x-default.system.tracking-pixels>
    </x-default.system.tracking-pixels>

    @php
        echo get_setting('header_script');
    @endphp

    @stack('head_scripts')
</head>
<body>
<!-- aiz-main-wrapper -->
<div class="">

    {{-- @include('frontend.inc.nav') --}}
        <x-default.merchant.header :shop="$shop"></x-default.merchant.header>


    @yield('content')

    {{-- @include('frontend.inc.footer') --}}

    <x-default.merchant.footer></x-default.merchant.footer>

</div>

<x-default.system.cookies-agreement></x-default.system.cookies-agreement>

@include('frontend.partials.modal')

<div class="modal fade" id="addToCart">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size"
         role="document">
        <div class="modal-content position-relative">
            <div class="c-preloader text-center p-3">
                <i class="las la-spinner la-spin la-3x"></i>
            </div>
            <button type="button" class="close absolute-top-right btn-icon close z-1" data-dismiss="modal"
                    aria-label="Close">
                <span aria-hidden="true" class="la-2x">&times;</span>
            </button>
            <div id="addToCart-modal-body">

            </div>
        </div>
    </div>
</div>

<x-default.footer.mobile-footer></x-default.footer.mobile-footer>


<!-- Print SignUp Modal Component -->
<x-default.modals.signup-modal style="signup-modal" id="signupModal"></x-default.modals.signup-modal>

@yield('modal')

<script src="{{ mix('js/app.js', 'themes/'.Theme::parent()) }}"></script>

    <!-- Vendor Scripts -->
    <script src="{{ static_asset('vendor/hs.core.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-unfold/dist/hs-unfold.min.js', false, true) }}"></script>



@yield('script')

{{-- TODO: Include this propertly --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" rel="stylesheet">

@stack('footer_scripts')

@include('frontend.layouts.partials.app-js')

<script src="{{ static_asset('front/js/hs.slick-carousel.js') }}"></script>

<!-- JS Plugins Init. -->
<script>
    $(function() {
        // INITIALIZATION OF SLICK CAROUSEL
        // =======================================================
        $('.js-slick-carousel').each(function() {
            var slickCarousel = $.HSCore.components.HSSlickCarousel.init($(this));
        });
    });
</script>



@php
    echo get_setting('footer_script');
@endphp

    @livewireStyles
    @livewireScripts
</body>
</html>
