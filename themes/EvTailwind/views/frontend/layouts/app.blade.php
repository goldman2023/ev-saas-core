<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">

    @yield('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{ seo()->render() }}

    {{--
    SITE NAME:
    To Use Site name globaly, use helper function get_site_name() - it's an alias fo get_setting('site_name')
    --}}
    <title>@yield('meta_title', get_site_name() .' | '.get_tenant_setting('site_motto'))</title>
    <meta name="file-base-url" content="{{ getStorageBaseURL() }}">
    <meta name="file-bucket-url" content="{{ getStorageBaseURL() }}">
    <meta name="storage-base-url" content="{{ getStorageBaseURL() }}">

    <script id="img-proxy-data" type="application/json">@json(\IMG::getIMGProxyData())</script>

    {{-- TailwindCSS --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css', 'themes/EvTailwind') }}">


    @include('frontend.layouts.global-partials.all')




    @livewireStyles


    {{-- <script src="{{ static_asset('js/alpine.js', false, true, true) }}" defer></script> --}}

    @stack('head_scripts')
</head>

<body class="font-sans antialiased {{ Route::currentRouteName() }}" x-data="{
    all_categories: @js(Categories::getAllFormatted(true)),
    all_categories_flat: @js(Categories::getAllFormatted(true, true)),
}"
    @keydown.escape="$dispatch('main-navigation-dropdown-hide');">

    @include('frontend.layouts.global-partials.global-integrations-body')

    <div class="min-h-screen">
        <x-tailwind-ui.headers.header></x-tailwind-ui.headers.header>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <x-tailwind-ui.footers.footer>
        </x-tailwind-ui.footers.footer>
    </div>

    <x-default.footers.app-bar>
    </x-default.footers.app-bar>


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
    @endauth

    @if(get_tenant_setting('chat_feature', false))
    @auth
    <x-default.chat.widget-chat></x-default.chat.widget-chat>
    @endauth
    @endif


    <x-system.info-modal></x-system.info-modal>
    <x-system.validation-errors-toast timeout="5000"></x-system.validation-errors-toast>

    <x-ev.toast id="global-toast" position="bottom-center" class="text-white text-18" :timeout="4000"></x-ev.toast>


    <script src="{{ mix('js/app.min.js', 'themes/EvTailwind') }}" defer></script>
    <script src="{{ mix('js/alpine.js', 'themes/EvTailwind') }}" defer></script>

    <!-- Scripts -->
    @livewireScripts
    <!-- Scripts -->

    @yield('script')

    @stack('footer_scripts')

    <x-integrations.open-replay></x-integrations.open-replay>

    {{-- TODO: Global Plausible Script --}}

    @auth
    @endauth

</body>

</html>
