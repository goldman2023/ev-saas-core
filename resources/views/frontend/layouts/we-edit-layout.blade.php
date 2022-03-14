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

    
    <script id="img-proxy-data" type="application/json">
        @json(\IMG::getIMGProxyData())
    </script>

    @if(!isset($detailedProduct) && !isset($customer_product) && !isset($shop) && !isset($page) && !isset($blog))
        <x-default.system.og-meta>
        </x-default.system.og-meta>
    @endif


    <!-- Vendor Styles -->

    <!-- Theme styles -->
    <link rel="stylesheet" href="{{ \EVS::getThemeStyling() }}">

    @stack('pre_head_scripts')

    <script src="{{ static_asset('js/app.js', false, true, true) }}"></script>
    <!-- Vendor Scripts -->

    <x-default.system.tracking-pixels>
    </x-default.system.tracking-pixels>

    @stack('head_scripts')

    @livewireStyles
    @livewireScripts

    <script src="{{ static_asset('js/alpine.js', false, true, true) }}" defer></script>
</head>
<body class="h-full">
    <div class="main-wrapper h-full">
        @yield('content')
    </div>

    <x-default.system.cookies-agreement></x-default.system.cookies-agreement>

    {{-- Include WeEdit modals --}}
    <x-tailwind-ui.system.info-modal></x-tailwind-ui.system.info-modal>


    {{-- TODO: Include this propertly --}}

    @include('frontend.layouts.partials.app-js')

    {{-- <script src="{{ static_asset('js/aiz-core.js', false, true) }}"></script> --}}
    {{-- <script>
        $(function() {
            /* Init file managers */
            $('.custom-file-manager [data-toggle="aizuploader"]').each(function(index, element) {
                let selected_files = $.map($(element).find(".selected-files").val().split(','), function(value){
                    let id = parseInt(value, 10);
                    if(id) {
                        return id;
                    }
                });

                window.AIZ.uploader.inputSelectPreviewGenerate($(element), selected_files, true);
            });
        });
    </script> --}}

    @stack('footer_scripts')
</body>
</html>
