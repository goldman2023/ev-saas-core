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


    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css', 'themes/WeTailwind') }}">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js', 'themes/WeTailwind') }}" defer></script>

    {{ seo()->render() }}

    @php
        echo get_setting('header_script');
    @endphp
    @auth
        @livewireStyles

        @livewireScripts
    @endauth
</head>

<body class="font-sans antialiased" x-data="{}" @keydown.escape="$dispatch('main-navigation-dropdown-hide');">
    <div class="min-h-screen">
        <header>
            @include('frontend.layouts.navigation')
        </header>
        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <footer>
            <x-tenant.footer.simple-centered></x-tenant.footer.simple-centered>
        </footer>

    </div>
</body>

</html>