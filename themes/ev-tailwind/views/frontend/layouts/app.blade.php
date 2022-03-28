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

          .container {
              max-width: 100%;
              width: 1140px;
              margin: 0 auto;
          }
        }
    </style>


    {{ seo()->render() }}

    @livewireScripts
    @livewireStyles

    <script src="{{ static_asset('js/alpine.js', false, true, true) }}" defer></script>

    @stack('head_scripts')
</head>
<body class="font-sans antialiased {{ Route::currentRouteName() }}" x-data="{}" @keydown.escape="$dispatch('main-navigation-dropdown-hide');">
    <div class="min-h-screen">
        <x-tailwind-ui.headers.header></x-tailwind-ui.headers.header>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <x-tailwind-ui.footers.footer></x-tailwind-ui.headers.header>
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
        <x-default.chat.main-chat></x-default.chat.main-chat>
    @endauth
    @stack('footer_scripts')


</body>

</html>
