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
    @themefilexists('css/app.css')
        <link rel="stylesheet" href="{{ mix('css/app.css', 'themes/'.\WeTheme::getThemeName()) }}">
    @else
        <link rel="stylesheet" href="{{ mix('css/app.css', 'themes/WeTailwind') }}">
    @endthemefilexists
    {{ seo()->render() }}

    @livewireStyles

</head>

<body class="font-sans antialiased h-full overflow-hidden {{ Route::currentRouteName() }}" x-data="{}"
    @keydown.escape="$dispatch('main-navigation-dropdown-hide');">
    <!-- Page Content -->
    <main class="h-full flex">
        @yield('content')
    </main>

    {{-- <x-tailwind.system.countdown></x-tailwind.system.countdown> --}}

    {{-- Scripts --}}
    @themefilexists('js/app.min.js')
        <script src="{{ mix('js/app.min.js', 'themes/'.\WeTheme::getThemeName()) }}" defer></script>
    @else
        <script src="{{ mix('js/app.min.js', 'themes/WeTailwind') }}" defer></script>
    @endthemefilexists

    @themefilexists('js/alpine.js')
        <script src="{{ mix('js/alpine.js', 'themes/'.\WeTheme::getThemeName()) }}" defer></script>
    @else
        <script src="{{ mix('js/alpine.js', 'themes/WeTailwind') }}" defer></script>
    @endthemefilexists

    @livewireScripts
    @yield('script')
</body>

</html>
