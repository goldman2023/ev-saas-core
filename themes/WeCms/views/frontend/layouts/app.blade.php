<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@yield('meta_title', get_site_name() .' | '.get_tenant_setting('site_motto'))</title>
    <meta name="description" content="@yield('meta_description', get_setting('meta_description') )" />
    {{--
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords') )"> --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <link rel='canonical' href='@yield(' canonical_link', url()->current() )' />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">

    @yield('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Favicon --}}
    <link rel="icon" href="{{ get_favicon() }}" sizes="32x32" />
    <link rel="icon" href="{{ get_favicon() }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ get_favicon() }}" />
    <meta name="msapplication-TileImage" content="{{ get_favicon() }}" />
    {{ seo()->render() }}

    {{--
    SITE NAME:
    To Use Site name globaly, use helper function get_site_name() - it's an alias fo get_setting('site_name')
    --}}


    <meta name="file-base-url" content="{{ getStorageBaseURL() }}">
    <meta name="file-bucket-url" content="{{ getStorageBaseURL() }}">
    <meta name="storage-base-url" content="{{ getStorageBaseURL() }}">


    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css', 'themes/WePixPro') }}">

    @include('frontend.layouts.global-partials.all')
    @livewireStyles

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-10808493729"></script>
    <script>
        window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-10808493729');
    </script>
    @stack('head_scripts')
</head>

<body class="antialiased {{ Route::currentRouteName() }}" x-data="{
}" @keydown.escape="$dispatch('main-navigation-dropdown-hide');">

    @include('frontend.layouts.global-partials.global-integrations-body')

    <div class="min-h-screen">
        {{-- <x-system.promo-banner></x-system.promo-banner> --}}
        {{-- <x-system.promo-banner-bottom></x-system.promo-banner-bottom> --}}

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
    <livewire:flyout.wishlist />


    @guest
    <x-panels.flyout-auth></x-panels.flyout-auth>
    @endguest

    @auth
    <x-panels.flyout-profile></x-panels.flyout-profile>
    <div>
        <livewire:we-media-library />
        <livewire:we-media-editor />
    </div>
    @endauth

    @if(get_tenant_setting('chat_feature', false))
    @auth
    <x-default.chat.widget-chat></x-default.chat.widget-chat>
    @endauth
    @endif


    <x-system.info-modal></x-system.info-modal>
    <x-system.validation-errors-toast timeout="5000"></x-system.validation-errors-toast>
    <x-ev.toast id="global-toast" position="bottom-center" class="text-white text-18" :timeout="4000"></x-ev.toast>


    <script src="{{ mix('js/app.min.js', 'themes/WePixPro') }}" defer></script>
    <script src="{{ mix('js/alpine.js', 'themes/WePixPro') }}" defer></script>

    <!-- Scripts -->
    @livewireScripts
    <!-- Scripts -->

    <script id="img-proxy-data" type="application/json">
        @json(\IMG::getIMGProxyData())
    </script>
    @yield('script')

    @stack('footer_scripts')

    {{-- <x-integrations.mix-panel></x-integrations.mix-panel> --}}
    {{-- <x-integrations.open-replay></x-integrations.open-replay> --}}
</body>

</html>
