<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">

<head>
    <meta charset="utf-8">
    @yield('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('meta_title', get_setting('website_name').' | '.get_setting('site_motto'))
    </title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css', 'themes/ev-tailwind') }}">

    {{ seo()->render() }}

    <!-- Favicon -->
    <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">
    @livewireStyles
    {{-- <script src="{{ static_asset('js/alpine.js', false, true, true) }}" defer></script> --}}

</head>

<body class="font-sans antialiased h-full overflow-hidden {{ Route::currentRouteName() }}" x-data="{}"
    @keydown.escape="$dispatch('main-navigation-dropdown-hide');">
    <!-- Page Content -->
    <main class="h-full flex">
        @yield('content')
    </main>

    <!-- Scripts -->
    {{-- <script src="{{ mix('js/app.js', 'themes/ev-tailwind') }}" defer></script> --}}
    @livewireScripts
    @yield('script')
</body>

</html>
