<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <meta name="description" content="@yield('meta_description', get_setting('meta_description') )" />
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords') )">
    @yield('meta')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title', get_setting('website_name').' | '.get_setting('site_motto'))</title>

    <script id="img-proxy-data" type="application/json">
        @json(\IMG::getIMGProxyData())
    </script>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css', 'themes/ev-tailwind') }}">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js', 'themes/ev-tailwind') }}" defer></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    @include('frontend.layouts.global-partials.all')

    {{ seo()->render() }}

    @livewireScripts
    @livewireStyles

    <script src="{{ static_asset('js/alpine.js', false, true, true) }}" defer></script>

    @stack('head_scripts')
</head>
<body class="font-sans antialiased {{ Route::currentRouteName() }}" x-data="{}" @keydown.escape="$dispatch('main-navigation-dropdown-hide');">
    <div class="min-h-screen">
        @yield('content')
    </div>

    <x-default.footers.app-bar>
    </x-default.footers.app-bar>

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

    @yield('script')

    @auth
        <x-default.chat.widget-chat></x-default.chat.widget-chat>
    @endauth
    @stack('footer_scripts')


</body>

</html>
