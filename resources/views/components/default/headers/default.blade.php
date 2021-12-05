<!-- ========== HEADER ========== -->
<header id="header" class="header shadow-lg">
    <div class="header-section">
        <!-- Topbar -->
        <div class="container header-hide-content pt-2">
            <div class="d-flex align-items-center ev-top-bar">
                <div>
                    <!-- Language -->
                    @if (get_setting('show_language_switcher') == 'on')
                    @php
                    if (Session::has('locale')) {
                    $locale = Session::get('locale', Config::get('app.locale'));
                    } else {
                    $locale = 'en';
                    }
                    @endphp
                    <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker dropdown-nav-link dropdown-toggle d-flex align-items-center"
                            href="javascript:;" data-hs-unfold-options='{
                              "target": "#languageDropdown",
                              "type": "css-animation",
                              "event": "hover",
                              "hideOnScroll": "true"
                             }'>
                            <img class="dropdown-item-icon mr-2"
                                src="{{ global_asset('assets/img/flags/' . $locale . '.png') }}" alt="SVG">
                            <span class="d-inline-block d-sm-none">{{ $locale }}</span>
                            <span class="d-none d-sm-inline-block">{{ $locale }}</span>
                        </a>

                        <div id="languageDropdown" class="hs-unfold-content dropdown-menu">
                            @foreach (\App\Models\Language::all() as $key => $language)
                            <a href="javascript:void(0)" data-flag="{{ $language->code }}"
                                class="dropdown-item @if ($locale == $language) active @endif">
                                <img class="dropdown-item-icon mr-2"
                                    src="{{ global_asset('assets/img/flags/' . $language->code . '.png') }}" alt="SVG">

                                {{ $language->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <!-- End Language -->
                </div>
                <div class="ml-4">
                    {{-- Currency --}}
                    @if (get_setting('show_currency_switcher') == 'on')
                    @php
                    if (Session::has('currency_code')) {
                    $currency_code = Session::get('currency_code', Config::get('app.currency_code'));
                    } else {
                    $currency_code = 'USD';
                    }
                    @endphp
                    <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker dropdown-nav-link dropdown-toggle d-flex align-items-center"
                            href="javascript:;" data-hs-unfold-options='{
                              "target": "#currencyDropdown",
                              "type": "css-animation",
                              "event": "hover",
                              "hideOnScroll": "true"
                             }'>
                            <span class="d-inline-block d-sm-none">{{ $currency_code }}</span>
                            <span class="d-none d-sm-inline-block">{{ $currency_code }}</span>
                        </a>

                        <div id="currencyDropdown" class="hs-unfold-content dropdown-menu">
                            @foreach (\App\Models\Currency::all() as $key => $currency)
                            <a href="javascript:void(0)" data-flag="{{ $currency->code }}"
                                class="dropdown-item d-flex justify-content-between @if ($currency_code == $currency) active @endif">
                                <div class="mr-3">{{ $currency->name }}</div>
                                <div>{{ $currency->symbol }}</div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    {{-- End Currency --}}
                </div>

                <div class="ml-auto">


                    <!-- Links -->
                    {{-- <div class="nav nav-sm nav-y-0 d-none d-sm-flex ml-sm-auto">
                        <a class="nav-link" href="#">Help</a>
                        <a class="nav-link" href="#">Contacts</a>
                    </div> --}}
                    <!-- End Links -->
                </div>

                <ul class="list-inline ml-2 mb-0">
                    <!-- Search -->
                    <li class="list-inline-item">
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-xs btn-icon btn-ghost-secondary" href="javascript:;"
                                data-hs-unfold-options='{
                                  "target": "#searchPushTop",
                                  "type": "jquery-slide",
                                  "contentSelector": ".search-push-top"
                                 }'>
                                @svg('heroicon-o-search', ['style' => 'width:16px;'])
                            </a>
                        </div>
                    </li>
                    <!-- End Search -->

                    <!-- Shopping Cart -->
                    <li class="list-inline-item">
                        <div class="hs-unfold">
                            <a class="btn btn-xs btn-icon btn-ghost-secondary" href="javascript:;" x-data="" @click="$dispatch('display-cart')">
                                @svg('heroicon-o-shopping-cart', ['style' => 'width:16px;'])
                            </a>

                            <div id="shoppingCartDropdown"
                                class="hs-unfold-content dropdown-menu dropdown-menu-right text-center p-7"
                                style="min-width: 250px;">
                                <figure class="max-w-9rem mx-auto mb-3">
                                    @svg('heroicon-o-shopping-cart')
                                </figure>
                                <span class="d-block">
                                    {{ translate('Your Cart is Empty') }}
                                </span>
                            </div>
                        </div>
                    </li>
                    <!-- End Shopping Cart -->

                    <!-- Account Login -->
                    @auth
                    <li class="list-inline-item">
                        <div class="hs-unfold">
                            <a href="{{ route('user.logout') }}" class="text-reset py-2 d-inline-block opacity-60">{{
                                translate('Logout') }}</a>
                        </div>
                    </li>
                    @else
                    <li class="list-inline-item">
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-secondary"
                                href="{{ route('business.login') }}">
                                <!--data-toggle="modal" data-target="#signupModal">-->
                                @svg('heroicon-s-user-circle', ['style' => 'width:16px;'])
                            </a>
                        </div>
                    </li>

                    <li class="list-inline-item">
                        <a href="{{ route('business.login') }}" data-test="header.login">
                            {{ translate('Login') }}
                        </a>
                    </li>

                    @endauth
                    <!-- End Account Login -->
                </ul>
            </div>
        </div>
        <!-- End Topbar -->
        <div id="logoAndNav" class="container pb-3">
            <!-- Nav -->
            <div class="row">
                <div class="col-sm-3 col-6">
                    <a class="navbar-brand" href="{{ route('home') }}" aria-label="{{ get_site_name() }}">
                        @php
                        $header_logo = get_setting('header_logo');
                        @endphp
                        @if ($header_logo != null)
                        <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}">
                        @else
                        <img src="{{ static_asset('tenancy/assets/img/logo.jpg') }}" alt="{{ env('APP_NAME') }}">
                        @endif
                    </a>
                </div>
                <div class="col-sm-6 align-items-center d-none d-sm-block">
                    <x-b2-b-search></x-b2-b-search>
                </div>
                <div class="col-sm-3 col-6 justify-content-end align-items-end text-right">
                    <x-join-button>
                    </x-join-button>
                </div>
                <!-- End Nav -->
            </div>

        </div>
    </div>
    <div class="sub-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <!-- Responsive Toggle Button -->
                <button type="button" class="navbar-toggler btn btn-icon btn-sm rounded-circle"
                    aria-label="Toggle navigation" aria-expanded="false" aria-controls="navBar" data-toggle="collapse"
                    data-target="#navBar">
                    <span class="navbar-toggler-default">
                        <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor"
                                d="M17.4,6.2H0.6C0.3,6.2,0,5.9,0,5.5V4.1c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,5.9,17.7,6.2,17.4,6.2z M17.4,14.1H0.6c-0.3,0-0.6-0.3-0.6-0.7V12c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,13.7,17.7,14.1,17.4,14.1z" />
                        </svg>
                    </span>
                    <span class="navbar-toggler-toggled">
                        <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor"
                                d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z" />
                        </svg>
                    </span>
                </button>
                <!-- End Responsive Toggle Button -->

                <!-- Navigation -->
                <div id="navBar" class="collapse navbar-collapse">

                    <ul class="navbar-nav ml-0 mr-0">
                        <!-- Home -->
                        <li class="category-dropdown-toggle">

                            <a href="#" class="nav-link text-white d-flex align-items-center fw-600">

                                @svg('heroicon-s-menu', ["class" => 'ev-icon__small mr-2'])

                                </span>{{ translate('Browse Categories') }}
                            </a>
                        </li>
                        @if (get_setting('header_menu_labels') != null)


                        @foreach (get_setting('header_menu_labels') as $key => $value)
                        @php
                        $target = '_self';

                        @endphp
                        <li class="position-static">
                            {{-- TODO: Add active menu indicators --}}
                            <a class="nav-link text-white" style="font-weight: 600; font-size: 16px;"
                                target="{{ $target }}" href="{{ get_setting('header_menu_links')[$key] }}">
                                {{ $value }}
                            </a>
                        </li>
                        @endforeach

                        @endif


                        <!-- End Home -->

                        <!-- End Docs -->

                        <!-- Button -->

                        <!-- End Button -->
                    </ul>

                </div>

        </div>

    </div>
    <!-- End Navigation -->
    </div>
</header>
<!-- ========== END HEADER ========== -->

@push('footer_scripts')
<!-- JS Plugins Init. -->
<script src="{{ static_asset('vendor/hs-header/dist/hs-header.min.js', false, true) }}"></script>
<script src="{{ static_asset('vendor/hs-show-animation/dist/hs-show-animation.min.js', false, true) }}"></script>
<script>
    $(document).on('ready', function() {
            // INITIALIZATION OF HEADER
            // =======================================================
            var header = new HSHeader($('#header')).init();


            // INITIALIZATION OF HSMEGAMENU COMPONENT
            // =======================================================
            var megaMenu = new HSMegaMenu($('.js-mega-menu')).init();




            // INITIALIZATION OF FORM VALIDATION
            // =======================================================
            $('.js-validate').each(function() {
                $.HSCore.components.HSValidation.init($(this), {
                    rules: {
                        confirmPassword: {
                            equalTo: '#signupPassword'
                        }
                    }
                });
            });


            // INITIALIZATION OF SHOW ANIMATIONS
            // =======================================================
            $('.js-animation-link').each(function() {
                var showAnimation = new HSShowAnimation($(this)).init();
            });
        });
</script>

@endpush
