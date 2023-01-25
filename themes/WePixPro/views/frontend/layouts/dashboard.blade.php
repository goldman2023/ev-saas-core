<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <meta name="description" content="@yield('meta_description', get_setting('meta_description') )" />
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords') )">

    <meta name="file-base-url" content="{{ getStorageBaseURL() }}">
    <meta name="file-bucket-url" content="{{ getStorageBaseURL() }}">
    <meta name="storage-base-url" content="{{ getStorageBaseURL() }}">

    {{-- EditorJS images routes --}}
    <meta name="editorjs-image-upload" content="{{ route('api.dashboard.images.upload') }}">
    <meta name="editorjs-image-fetch" content="{{ route('api.dashboard.images.fetch') }}">

    @yield('meta')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title', get_site_name() .' | '.get_setting('site_motto'))</title>

    <script id="img-proxy-data" type="application/json">
        @json(\IMG::getIMGProxyData())
    </script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css', 'themes/WePixPro') }}">

    <script defer async src="{{ static_asset('/bp-assets/vendor/flowbite/flowbite.js') }}"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css', 'themes/WePixPro') }}">
    @include('frontend.layouts.global-partials.all')

    {{ seo()->render() }}
    @livewireStyles

    <link rel="stylesheet" href="{{ static_asset('/bp-assets/vendor/flatpickr/flatpickr-airbnb.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @stack('head_scripts')
</head>

<body class="font-sans antialiased bg-gray-100 {{ Route::currentRouteName() }}" x-data="{
    all_categories: @js(Categories::getAllFormatted(true)),
    all_categories_flat: @js(Categories::getAllFormatted(true, true)),
}" @keydown.escape="$dispatch('main-navigation-dropdown-hide');">
    <div class="min-h-screen">

        {{-- <x-tailwind-ui.headers.header></x-tailwind-ui.headers.header> --}}

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        {{-- <x-tailwind-ui.footers.footer>
            </x-tailwind-ui.headers.header> --}}
    </div>

    <!-- Carts -->
    <livewire:cart.cart template="flyout-cart" />
    <livewire:we-media-library />
    <livewire:we-media-editor />
    <livewire:wef-editor-modal />

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

    {{-- App bar --}}
    <x-default.footers.app-bar></x-default.footers.app-bar>

    <x-system.info-modal></x-system.info-modal>
    <livewire:modals.delete-modal />
    <x-system.validation-errors-toast timeout="5000"></x-system.validation-errors-toast>

    @stack('modal')

    <x-ev.toast id="global-toast" position="bottom-center" class="text-white text-18" :timeout="4000"></x-ev.toast>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js', 'themes/WePixPro') }}" defer></script>
    <script src="{{ static_asset('js/alpine.js', false, true, true) }}" defer></script>
    @livewireScripts
    @yield('script')

    @stack('footer_scripts')

    {{-- <x-integrations.open-replay></x-integrations.open-replay> --}}

</body>

</html>
