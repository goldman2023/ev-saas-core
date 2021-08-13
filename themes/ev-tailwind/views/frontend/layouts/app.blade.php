<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EV Saas') }}</title>

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ static_asset('css/app.css', 'themes/ev-tailwind') }}">

    <!-- Scripts -->
    <script src="{{ static_asset('js/app.js', 'themes/ev-tailwind') }}" defer></script>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
@include('frontend.layouts.navigation')
<!-- Page Content -->
    <main>
        @yield('content')
    </main>
</div>
<x-tenant.footer></x-tenant.footer>
</body>
</html>
