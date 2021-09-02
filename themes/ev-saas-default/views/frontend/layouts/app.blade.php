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
    <meta name="file-bucket-url" content="{{ getBucketBaseURL() }}">

    <title>@yield('meta_title', get_setting('website_name').' | '.get_setting('site_motto'))</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="description" content="@yield('meta_description', get_setting('meta_description') )"/>
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords') )">

    @yield('meta')

    @if(!isset($detailedProduct) && !isset($customer_product) && !isset($shop) && !isset($page) && !isset($blog))
        <x-default.system.og-meta>
        </x-default.system.og-meta>
    @endif

    <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">

    <!-- Vendor Styles -->
    <link rel="stylesheet" href="{{ static_asset('vendor/hs-unfold/dist/hs-unfold.min.css', false, true) }}">

    <style>
        :root {
            --primary: yellow;
            --secondary: green;
            --soft-primary: {{ hex2rgba(get_setting('base_color','#e62d04'),.15) }};
        }
    </style>
    <link rel="stylesheet" href="{{ mix('css/app.css', 'themes/ev-saas-default') }}">

    <!-- Scripts
    <script src="https://htmlstream.com/front/assets/js/vendor.min.js"></script>
    <script src="https://htmlstream.com/front/assets/js/theme.min.js"></script>-->
    <script src="{{ mix('js/app.js', 'themes/'.Theme::active()) }}"></script>

    <!-- Vendor Scripts -->
    <script src="{{ static_asset('vendor/hs.core.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-unfold/dist/hs-unfold.min.js', false, true) }}"></script>


    <script>
        window.AIZ = window.AIZ || {};
        window.AIZ.local = {
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



    <x-default.system.tracking-pixels>
    </x-default.system.tracking-pixels>

    @php
        echo get_setting('header_script');
    @endphp

    @stack('head_scripts')
</head>
<body>
<!-- aiz-main-wrapper -->
<div class="">

    {{-- @include('frontend.inc.nav') --}}
        <x-default.headers.header>
        </x-default.headers.header>


    @yield('content')

    {{-- @include('frontend.inc.footer') --}}

    <x-default.footers.footer>
    </x-default.footers.footer>

</div>

<x-default.system.cookies-agreement></x-default.system.cookies-agreement>

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

<!-- Print SignUp Modal Component -->
<x-default.modals.signup-modal style="signup-modal" id="signupModal"></x-default.modals.signup-modal>

@yield('modal')

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
