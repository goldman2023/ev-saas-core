<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{ seo()->render() }}

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <script id="img-proxy-data" type="application/json">
        @json(\IMG::getIMGProxyData())
    </script>
    <meta name="storage-base-url" content="{{ getStorageBaseURL() }}">
    <meta name="file-bucket-url" content="{{ getStorageBaseURL() }}">

    <title>@yield('meta_title', get_setting('website_name').' | '.get_setting('site_motto'))</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="description" content="@yield('meta_description', get_setting('meta_description') )" />
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords') )">

    @yield('meta')

    @if (!isset($detailedProduct) && !isset($customer_product) && !isset($shop) && !isset($page) && !isset($blog))
    <x-default.system.og-meta>
    </x-default.system.og-meta>
    @endif

    <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">

    <script>
        var AIZ = AIZ || {};
        AIZ.local = {
            nothing_found: '{{ translate('Nothing found') }}',
            choose_file: '{{ translate('Choose file') }}',
            file_selected: '{{ translate('File selected') }}',
            files_selected: '{{ translate('Files selected') }}',
            add_more_files: '{{ translate('Add more files') }}',
            adding_more_files: '{{ translate('Adding more files') }}',
            drop_files_here_paste_or: '{{ translate('Drop files here, paste or') }}',
            browse: '{{ translate('Browse') }}',
            upload_complete: '{{ translate('Upload complete') }}',
            upload_paused: '{{ translate('Upload paused') }}',
            resume_upload: '{{ translate('Resume upload') }}',
            pause_upload: '{{ translate('Pause upload') }}',
            retry_upload: '{{ translate('Retry upload') }}',
            cancel_upload: '{{ translate('Cancel upload') }}',
            uploading: '{{ translate('Uploading') }}',
            processing: '{{ translate('Processing') }}',
            complete: '{{ translate('Complete') }}',
            file: '{{ translate('File') }}',
            files: '{{ translate('Files') }}',
        }
    </script>

    <!-- Vendor Styles -->
    {{--
    <link rel="stylesheet" href="{{ static_asset('vendor/hs-unfold/dist/hs-unfold.min.css', false, true) }}"> --}}

    @livewireStyles
    {{-- Include overides and custom css for child theme if needed --}}
    <link rel="stylesheet" href="{{ \EVS::getThemeStyling() }}">

    {{-- Global base css, with variables replaced and default set inside probably --}}
    <link rel="stylesheet" href="{{ global_asset('dynamic-colors/app-dynamic.css', false, true) }}">

    {{-- This component holds css variable per tenant --}}
    <x-default.system.tenant.custom-includes></x-default.system.tenant.custom-includes>

    @stack('pre_head_scripts')

    <script src="{{ static_asset('js/app.js', false, true, true) }}"></script>
    <!-- Vendor Scripts -->
    <script src="{{ static_asset('vendor/hs.core.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-unfold/dist/hs-unfold.min.js', false, true) }}"></script>

    <x-default.system.tracking-pixels>
    </x-default.system.tracking-pixels>

    @php
    echo get_setting('header_script');
    @endphp

    @stack('head_scripts')
</head>

{{-- TODO : Add a slug if page has a slug --}}

<body class="{{ Route::currentRouteName() }}">
    <!-- AlpineJS -->
    <script src="{{ static_asset('js/alpine.js', false, true, true) }}" defer></script>

    <div class="">

        {{-- @include('frontend.inc.nav') --}}
        <x-default.headers.header>
        </x-default.headers.header>

        {{-- <div class="space-top-lg-3 space-top-3"> --}}
            <div class="app-layout-container d-flex" style="flex-basis: 100%; flex-direction: column;">
                {{-- <x-default.system.promo-alert></x-default.system.promo-alert> --}}
                @yield('content')
            </div>

            {{-- @include('frontend.inc.footer') --}}

            <x-default.footers.footer>
            </x-default.footers.footer>
        </div>
        <x-default.footers.app-bar>
        </x-default.footers.app-bar>

        {{-- <x-default.chat.widget-chat></x-default.chat.widget-chat> --}}

        <x-default.system.cookies-agreement></x-default.system.cookies-agreement>

        @include('frontend.partials.modal')

        <!-- Print SignUp Modal Component -->
        <x-default.modals.signup-modal style="signup-modal" id="signupModal"></x-default.modals.signup-modal>

        <!-- Carts -->
        <livewire:cart.cart template="flyout-cart" />

        <!-- Wishlist -->
        {{-- TODO: Refactor this for unified structure, preffered in separate folder --}}
        <x-panels.flyout-wishlist></x-panels.flyout-wishlist>
        <x-panels.flyout-categories></x-panels.flyout-categories>

        @auth
            <x-panels.flyout-profile></x-panels.flyout-profile>
        @endauth

        @guest
            <x-panels.flyout-auth></x-panels.flyout-auth>
        @endguest

        <x-ev.toast id="global-toast" position="bottom-center" class="bg-success border-success text-white h3"
            :is_x="true" :timeout="4000">
        </x-ev.toast>

        @yield('modal')

        @yield('script')

        @livewireScripts

        @stack('footer_scripts')

        @include('frontend.layouts.partials.app-js')

        {{-- TODO: Move this to some logical place --}}
        <script src="{{ static_asset('front/js/hs.leaflet.js') }}"></script>

        <!-- JS Plugins Init. -->

        <script>
            $(function() {
                // TODO: Move this to some logical place
                // =======================================================
                $('.js-hs-unfold-invoker').each(function () {
                    var unfold = new HSUnfold($(this)).init();
                });
            });
        </script>

        @php
        echo get_setting('footer_script');
        @endphp
</body>

</html>
