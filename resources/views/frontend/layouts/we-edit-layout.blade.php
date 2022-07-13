<!DOCTYPE html>
@if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
    <html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
@endif
<head>
    {{ seo()->render() }}

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <meta name="file-base-url" content="{{ getStorageBaseURL() }}">
    <meta name="file-bucket-url" content="{{ getStorageBaseURL() }}">
    <meta name="storage-base-url" content="{{ getStorageBaseURL() }}">

    <title>@yield('meta_title')</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="description" content="@yield('meta_description', get_setting('meta_description') )"/>
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords') )">

    @yield('meta')


    <script id="img-proxy-data" type="application/json">@json(\IMG::getIMGProxyData())</script>

    @if(!isset($detailedProduct) && !isset($customer_product) && !isset($shop) && !isset($page) && !isset($blog))
        <x-default.system.og-meta>
        </x-default.system.og-meta>
    @endif


    <!-- Vendor Styles -->

    <!-- Theme styles -->
    <link rel="stylesheet" href="{{ \EVS::getThemeStyling() }}">

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    @include('frontend.layouts.global-partials.all')


    @stack('pre_head_scripts')

    <script src="{{ static_asset('js/app.js', false, true, true) }}"></script>
    <!-- Vendor Scripts -->

    <x-default.system.tracking-pixels>
    </x-default.system.tracking-pixels>

    @stack('head_scripts')

    @livewireStyles
    @livewireScripts

    <style type="text/css">
        .CodeMirror {
            height: 100% !important;
        }
    </style>

    <script src="{{ static_asset('js/alpine.js', false, true, true) }}" defer></script>
</head>
<body class="h-full">
    <div class="main-wrapper h-full">
        {{-- Sidebar (Mobile/Tablet and Laptop/Desktop) --}}
        @include('frontend.dashboard.partials.sidebar')
        @include('frontend.dashboard.partials.sidebar-mobile')

        <div class="lg:pl-64 flex flex-col">
            @include('frontend.dashboard.navigation.topbar')

            <main class="flex-1">
                <div class="w-full ">
                    @yield('content')
                </div>
            </main>

        </div>
    </div>

    <x-default.system.cookies-agreement></x-default.system.cookies-agreement>

    {{-- Include WeEdit modals --}}
    <x-system.info-modal></x-system.info-modal>


    {{-- @include('frontend.layouts.partials.app-js') --}}

    @stack('footer_scripts')
</body>
</html>
