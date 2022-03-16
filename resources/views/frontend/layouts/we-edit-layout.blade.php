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

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script>
        tailwind.config = {
          theme: {
            screens: {
                'mobile': {'min': '300px', 'max': '599px'},
                'tablet-portrait-up': '600px',
                'tablet-landscape-up': '900px',
                'laptop-up': '1200px',
                'desktop-up': '1500px',
                'xs': {'min': '300px', 'max': '599px'},
                'sm': '600px',
                'md': '900px',
                'lg': '1200px',
                'xl': '1500px',
            },
            extend: {
                fontFamily: {
                    sans: ['-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', 'sans-serif'],
                    roboto: ['Roboto'],
                },
                fontSize: {
                    '10': '10px',
                    '11': '11px',
                    '12': '12px',
                    '13': '13px',
                    '14': '14px',
                    '16': '16px',
                    '18': '18px',
                    '20': '20px',
                    '22': '22px',
                    '24': '24px',
                    '26': '26px',
                    '28': '28px',
                    '30': '30px',
                    '32': '32px',
                    '34': '34px',
                    '36': '36px',
                    '48': '48px',
                    '52': '52px',
                    '94': '94px',
                },
                lineClamp: {
                    7: '7',
                    8: '8',
                    9: '9',
                    10: '10',
                    11: '11',
                    12: '12',
                },
                colors: {
                    // Use WeSaaS brand colors here
                    primary: '#8BC53F',
                    primaryLight: '#EBF8DC',
                    primaryDark: '#657934',
                    secondary: '#FF8E3B',
                    secondaryLight: '#FFD53F',
                    secondaryDark: '',
                    info: '#219FFF',
                    infoLight: '#E9F6FF',
                    success: '#17BD8D',
                    successLight: '#E9FBF6',
                    warning: '#FFA114',
                    warningLight: '#FFF7EB',
                    danger: '#FF4E3E',
                    dangerLight: '#FFEDEC',
                }
            }
          }
        }
    </script>

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
