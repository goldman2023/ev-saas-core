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
    <meta name="file-base-url" content="{{ getStorageBaseURL() }}">
    <meta name="file-bucket-url" content="{{ getStorageBaseURL() }}">
    <meta name="storage-base-url" content="{{ getStorageBaseURL() }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css', 'themes/ev-tailwind') }}">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js', 'themes/ev-tailwind') }}" defer></script>

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
                    primary: '#EF0E50',
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
    <style type="text/tailwindcss">
        @layer utilities {
            [x-cloak] {
                @apply hidden;
            }
            .btn-standard {
                @apply cursor-pointer inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-500 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700;
            }
            .btn-primary {
                @apply cursor-pointer inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primaryDark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary;
            }
            .btn-success {
                @apply cursor-pointer inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-success hover:bg-success focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-success;
            }
            .btn-danger {
                @apply cursor-pointer inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-danger hover:bg-danger focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-danger;
            }
            .btn-ghost {
                @apply cursor-pointer inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-primary bg-transparent hover:text-primaryDark;
            }
            .badge-info {
                @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-infoLight text-info;
            }
            .badge-success {
                @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-successLight text-success;
            }
            .badge-warning {
                @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warningLight text-warning;
            }
            .badge-danger {
                @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-dangerLight text-danger;
            }
            .badge-dark {
                @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-900 text-white;
            }
            .form-standard {
                @apply flex-1 block w-full max-w-lg focus:ring-primary focus:border-primary min-w-0 rounded-md sm:text-sm border-gray-300 shadow-sm;
            }
            .form-checkbox-standard {
                @apply focus:ring-primary h-5 w-5 text-primary border-gray-300 rounded cursor-pointer;
            }
            .form-radio-standard {
                @apply focus:ring-primary h-5 w-5 text-primary border-gray-300 cursor-pointer;
            }
            .is-invalid {
                @apply border-danger;
            }

            .container {
                max-width: 100%;
                width: 1140px;
                margin: 0 auto;
            }

            .card {
                @apply bg-white border-2 border-gray-300 rounded-lg shadow-lg p-3;
            }
        }

        .we-dashboard-sidebar-background {
              background-color: "{{ get_setting('we_dashboard_sidebar_background_color', '#f5f5f5') }}";
          }
    </style>


    {{ seo()->render() }}

    @livewireScripts
    @livewireStyles

    <script src="{{ static_asset('js/alpine.js', false, true, true) }}" defer></script>

    @stack('head_scripts')
</head>

<body class="font-sans antialiased {{ Route::currentRouteName() }}" x-data="{}"
    @keydown.escape="$dispatch('main-navigation-dropdown-hide');">
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
    <x-panels.flyout-wishlist></x-panels.flyout-wishlist>
    <x-panels.flyout-categories></x-panels.flyout-categories>

    @guest
    <x-panels.flyout-auth></x-panels.flyout-auth>
    @endguest

    @auth
    <x-panels.flyout-profile></x-panels.flyout-profile>
    <x-default.chat.widget-chat></x-default.chat.widget-chat>
    <livewire:we-media-library />

    @endauth

    <x-ev.toast id="global-toast" position="bottom-center" class="bg-success border-success text-white h3" :is_x="true"
        :timeout="4000">
    </x-ev.toast>

    @yield('script')

    @stack('footer_scripts')


</body>

</html>
