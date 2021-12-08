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
    <link rel="stylesheet" href="{{ static_asset('vendor/hs-unfold/dist/hs-unfold.min.css', false, true) }}">

    <!-- Theme styles -->
    <link rel="stylesheet" href="{{ \EVS::getThemeStyling() }}">


    @livewireStyles
    <link rel="stylesheet" href="{{ static_asset('/front/icon-set/style.css') }}">

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

<body>
    <!-- AlpineJS -->
    <script src="{{ static_asset('js/alpine.js', false, true, true) }}" defer></script>

    <div class="">

        {{-- @include('frontend.inc.nav') --}}
        <x-default.headers.header>
        </x-default.headers.header>

        <div class="space-top-lg-4 space-top-3">
            <x-default.system.promo-alert></x-default.system.promo-alert>

            @yield('content')
        </div>

        {{-- @include('frontend.inc.footer') --}}

        <x-default.footers.footer>
        </x-default.footers.footer>

    </div>

    <x-default.system.cookies-agreement></x-default.system.cookies-agreement>

    @include('frontend.partials.modal')

    <!-- Print SignUp Modal Component -->
    <x-default.modals.signup-modal style="signup-modal" id="signupModal"></x-default.modals.signup-modal>

    <!-- Carts -->
    <livewire:cart.cart template="flyout-cart" />

    @yield('modal')

    @yield('script')

    @livewireScripts

    {{-- TODO: Include this properly --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" rel="stylesheet">

    @stack('footer_scripts')

    @include('frontend.layouts.partials.app-js')

    {{-- TODO: Move this to some logical place --}}
    <script src="{{ static_asset('front/js/hs.slick-carousel.js') }}"></script>
    <script src="{{ static_asset('front/js/hs.leaflet.js') }}"></script>

    <!-- JS Plugins Init. -->
    <script>
        $(function() {
            // INITIALIZATION OF SLICK CAROUSEL
            // =======================================================
            $('.js-slick-carousel').each(function() {
                var slickCarousel = $.HSCore.components.HSSlickCarousel.init($(this));
            });
            var unfold = new HSUnfold('.js-hs-unfold-invoker').init();
            console.log($.HSCore.components);
            $(document).on('ready', function () {
    // INITIALIZATION OF LEAFLET
    // =======================================================
    $('#map').each(function () {
      var leaflet = $.HSCore.components.HSLeaflet.init($(this)[0]);

      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        id: 'mapbox/light-v9'
      }).addTo(leaflet);
    });
  });
        });
    </script>

    @php
    echo get_setting('footer_script');
    @endphp
</body>

</html>
