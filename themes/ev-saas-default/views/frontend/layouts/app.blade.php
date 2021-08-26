<!DOCTYPE html>
@if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
    <html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @else
        <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        @endif
        <head>

            {{ seo()->render() }}

            <meta name="csrf-token" content="{{ csrf_token() }}">
            <meta name="app-url" content="{{ getBaseURL() }}">
            <meta name="file-base-url" content="{{ getFileBaseURL() }}">

            <title>@yield('meta_title', get_setting('website_name').' | '.get_setting('site_motto'))</title>

            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="robots" content="index, follow">
            <meta name="description" content="@yield('meta_description', get_setting('meta_description') )"/>
            <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords') )">
            @yield('meta')

            @if(!isset($detailedProduct) && !isset($customer_product) && !isset($shop) && !isset($page) && !isset($blog))
            <!-- Schema.org markup for Google+ -->
                <meta itemprop="name" content="{{ get_setting('meta_title') }}">
                <meta itemprop="description" content="{{ get_setting('meta_description') }}">
                <meta itemprop="image" content="{{ uploaded_asset(get_setting('meta_image')) }}">

                <!-- Twitter Card data -->
                <meta name="twitter:card" content="product">
                <meta name="twitter:site" content="@publisher_handle">
                <meta name="twitter:title" content="{{ get_setting('meta_title') }}">
                <meta name="twitter:description" content="{{ get_setting('meta_description') }}">
                <meta name="twitter:creator" content="@author_handle">
                <meta name="twitter:image" content="{{ uploaded_asset(get_setting('meta_image')) }}">

                <!-- Open Graph data -->
                <meta property="og:title" content="{{ get_setting('meta_title') }}"/>
                <meta property="og:type" content="website"/>
                <meta property="og:url" content="{{ route('home') }}"/>
                <meta property="og:image" content="{{ uploaded_asset(get_setting('meta_image')) }}"/>
                <meta property="og:description" content="{{ get_setting('meta_description') }}"/>
                <meta property="og:site_name" content="{{ env('APP_NAME') }}"/>
                <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
            @endif

            <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">

            <link rel="stylesheet" href="https://htmlstream.com/front/assets/css/theme.min.css?v=1.0">
            {{-- <link rel="stylesheet" href="{{ global_asset('ev-assets/front/css/snippets.min.css') }}"> --}}
            <!-- Front Icon Set CSS Files -->
            {{-- <link rel="stylesheet" href="{{ global_asset('front/icon-set/style.css') }}"> --}}

            <script>
                var AIZ = AIZ || {};
                AIZ.local = {
                    nothing_found: '{{ translate('Nothing found') }}',
                    choose_file: '{{ translate('Choose file') }}',
                    file_selected: '{{ translate('File selected') }}',
                    files_selected: '{{ translate('Files selected') }}',
                    add_more_files: '{{ translate('Add more files') }}',
                    adding_more_files: '{{ translate('Adding more files') }}',
                    drop_files_here_paste_or: '{{ translate('Drop files here, paste or') }}',
                    browse: '{{ translate('Browse') }}',
                    upload_complete: '{{ translate('Upload complete') }}',
                    upload_paused: '{{ translate('Upload paused') }}',
                    resume_upload: '{{ translate('Resume upload') }}',
                    pause_upload: '{{ translate('Pause upload') }}',
                    retry_upload: '{{ translate('Retry upload') }}',
                    cancel_upload: '{{ translate('Cancel upload') }}',
                    uploading: '{{ translate('Uploading') }}',
                    processing: '{{ translate('Processing') }}',
                    complete: '{{ translate('Complete') }}',
                    file: '{{ translate('File') }}',
                    files: '{{ translate('Files') }}',
                }
            </script>

            <style>
                body {
                    font-family: 'Open Sans', sans-serif;
                    font-weight: 400;
                }

                :root {
                    --primary: {{ get_setting('base_color', '#e62d04') }};
                    --hov-primary: {{ get_setting('base_hov_color', '#c52907') }};
                    --soft-primary: {{ hex2rgba(get_setting('base_color','#e62d04'),.15) }};
                }
            </style>

            @if (\App\Models\BusinessSetting::where('type', 'google_analytics')->first()->value == 1)
            <!-- Global site tag (gtag.js) - Google Analytics -->
                <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('TRACKING_ID') }}"></script>

                <script>
                    window.dataLayer = window.dataLayer || [];

                    function gtag() {
                        dataLayer.push(arguments);
                    }

                    gtag('js', new Date());
                    gtag('config', '{{ env('TRACKING_ID') }}');
                </script>
            @endif

            @if (\App\Models\BusinessSetting::where('type', 'facebook_pixel')->first()->value == 1)
            <!-- Facebook Pixel Code -->
                <script>
                    !function (f, b, e, v, n, t, s) {
                        if (f.fbq) return;
                        n = f.fbq = function () {
                            n.callMethod ?
                                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                        };
                        if (!f._fbq) f._fbq = n;
                        n.push = n;
                        n.loaded = !0;
                        n.version = '2.0';
                        n.queue = [];
                        t = b.createElement(e);
                        t.async = !0;
                        t.src = v;
                        s = b.getElementsByTagName(e)[0];
                        s.parentNode.insertBefore(t, s)
                    }(window, document, 'script',
                        'https://connect.facebook.net/en_US/fbevents.js');
                    fbq('init', '{{ env('FACEBOOK_PIXEL_ID') }}');
                    fbq('track', 'PageView');
                </script>
                <noscript>
                    <img height="1" width="1" style="display:none"
                         src="https://www.facebook.com/tr?id={{ env('FACEBOOK_PIXEL_ID') }}&ev=PageView&noscript=1"/>
                </noscript>
                <!-- End Facebook Pixel Code -->
            @endif

            @php
                echo get_setting('header_script');
            @endphp

        </head>
        <body>
        <!-- aiz-main-wrapper -->
        <div class="aiz-main-wrapper d-flex flex-column">

            <div class="position-relative">
            @include('frontend.inc.nav')

                <x-default.headers.header>

                </x-default.headers.header>
            </div>


            @yield('content')

            @include('frontend.inc.footer')

        </div>

        @if (get_setting('show_cookies_agreement') == 'on')
            <div class="aiz-cookie-alert shadow-xl">
                <div class="p-3 bg-dark rounded">
                    <div class="text-white mb-3">
                        @php
                            echo get_setting('cookies_agreement_text');
                        @endphp
                    </div>
                    <button class="btn btn-primary aiz-cookie-accepet">
                        {{ translate('Ok. I Understood') }}
                    </button>
                </div>
            </div>
        @endif

        @include('frontend.partials.modal')

        <div class="modal fade" id="addToCart">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size"
                 role="document">
                <div class="modal-content position-relative">
                    <div class="c-preloader text-center p-3">
                        <i class="las la-spinner la-spin la-3x"></i>
                    </div>
                    <button type="button" class="close absolute-top-right btn-icon close z-1" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true" class="la-2x">&times;</span>
                    </button>
                    <div id="addToCart-modal-body">

                    </div>
                </div>
            </div>
        </div>

        @yield('modal')




        <!-- JS Front -->
        <script src="https://htmlstream.com/front/assets/js/vendor.min.js"></script>
        <script src="https://htmlstream.com/front/assets/js/theme.min.js"></script>

        @include('frontend.layouts.partials.app-js')

        @yield('script')

        @stack('footer_scripts')

        @php
            echo get_setting('footer_script');
        @endphp

@livewireStyles
@livewireScripts
        </body>
        </html>
