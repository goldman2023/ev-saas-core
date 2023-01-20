<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">

    @yield('meta')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--
    SITE NAME:
    To Use Site name globaly, use helper function get_site_name() - it's an alias fo get_setting('site_name')
    --}}
    <title>@yield('meta_title', get_site_name() .' | '.get_tenant_setting('site_motto'))</title>
    <meta name="file-base-url" content="{{ getStorageBaseURL() }}">
    <meta name="file-bucket-url" content="{{ getStorageBaseURL() }}">
    <meta name="storage-base-url" content="{{ getStorageBaseURL() }}">

    <script id="img-proxy-data" type="application/json">
        @json(\IMG::getIMGProxyData())
    </script>


    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css', 'themes/weShip') }}">
    <style>
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        h1 {
            color: #383D43;
        }

        .main-bg-wrapper {
            background-color: #b8c6db;
            background-image: linear-gradient(315deg, #b8c6db 0%, #f5f7fa 74%);
        }

        .numbers-grid {
        }

        .numbers-grid .number-col {
            font-size: 24px;
            text-align: center;
            padding-top: 20px;
            padding-bottom: 20px;
            font-weight: 500;
        }

        .numbers-grid .number-col span {
            display: block;
            font-size: 14px;
        }

        .numbers-grid .number-col .stat:nth-child(1) {
            margin-bottom: 15px;
        }
    </style>


    @include('frontend.layouts.global-partials.all')

    {{ seo()->render() }}


    @livewireStyles


    {{-- <script src="{{ static_asset('js/alpine.js', false, true, true) }}" defer></script> --}}

    @stack('head_scripts')
</head>

<body class="font-sans antialiased {{ Route::currentRouteName() }}" x-data="{}"
    @keydown.escape="$dispatch('main-navigation-dropdown-hide');">

    @include('frontend.layouts.global-partials.global-integrations-body')

    <div class="min-h-screen">
        <x-tailwind-ui.headers.header></x-tailwind-ui.headers.header>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <x-tailwind-ui.footers.footer template="footer_02">
        </x-tailwind-ui.footers.footer>
    </div>




    <!-- Carts -->
    <livewire:cart.cart template="flyout-cart" />
    <!-- Wishlist -->
    {{-- TODO: Refactor this for unified structure, preffered in separate folder --}}
    {{-- <x-panels.flyout-wishlist></x-panels.flyout-wishlist> --}}
    <livewire:flyout.wishlist />

    {{-- <x-panels.flyout-categories></x-panels.flyout-categories> --}}

    @guest
    <x-panels.flyout-auth></x-panels.flyout-auth>
    @endguest

    @auth
    <x-panels.flyout-profile></x-panels.flyout-profile>
    <livewire:we-media-library />
    <livewire:we-media-editor />

    @endauth




    <x-system.info-modal></x-system.info-modal>
    <x-system.validation-errors-toast timeout="5000"></x-system.validation-errors-toast>

    <x-ev.toast id="global-toast" position="bottom-center" class="text-white text-18" :timeout="4000"></x-ev.toast>


    <script src="{{ mix('js/app.js', 'themes/weShip') }}" defer></script>
    <script src="{{ mix('js/alpine.js', 'themes/weShip') }}" defer></script>

    <!-- Scripts -->
    @livewireScripts
    <!-- Scripts -->

    @yield('script')

    @stack('footer_scripts')

</body>

</html>
