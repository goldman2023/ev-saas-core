<!-- ========== HEADER ========== -->
<header id="header" class="header">
    <div class="header-section">
        <!-- Topbar -->
        <div class="container header-hide-content pt-2">
            <div class="d-flex align-items-center">
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
                        <a class="js-hs-unfold-invoker dropdown-nav-link dropdown-toggle d-flex align-items-center" href="javascript:;"
                           data-hs-unfold-options='{
                              "target": "#languageDropdown",
                              "type": "css-animation",
                              "event": "hover",
                              "hideOnScroll": "true"
                             }'>
                            <img class="dropdown-item-icon mr-2" src="{{ global_asset('assets/img/flags/' . $locale . '.png') }}" alt="SVG">
                            <span class="d-inline-block d-sm-none">{{ $locale }}</span>
                            <span class="d-none d-sm-inline-block">{{ $locale }}</span>
                        </a>

                        <div id="languageDropdown" class="hs-unfold-content dropdown-menu">
                            @foreach (\App\Models\Language::all() as $key => $language)
                                <a
                                    href="javascript:void(0)" data-flag="{{ $language->code }}"
                                    class="dropdown-item @if ($locale==$language) active @endif">
                                    <img class="dropdown-item-icon mr-2" src="{{ global_asset('assets/img/flags/' . $language->code . '.png') }}" alt="SVG">

                                    {{ $language->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
            @endif
            <!-- End Language -->

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
                            <a class="js-hs-unfold-invoker btn btn-xs btn-icon btn-ghost-secondary" href="javascript:;"
                               data-hs-unfold-options='{
                                  "target": "#shoppingCartDropdown",
                                  "type": "css-animation",
                                  "event": "hover",
                                  "hideOnScroll": "true"
                                 }'>
                                @svg('heroicon-o-shopping-cart', ['style' => 'width:16px;'])
                            </a>

                            <div id="shoppingCartDropdown" class="hs-unfold-content dropdown-menu dropdown-menu-right text-center p-7" style="min-width: 250px;">
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
                                <a href="{{ route('logout') }}"
                                   class="text-reset py-2 d-inline-block opacity-60">{{ translate('Logout') }}</a>
                            </div>
                        </li>
                    @else
                        <li class="list-inline-item">
                            <div class="hs-unfold">
                                <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-secondary"
                                   href="{{ route('user.login') }}"> <!--data-toggle="modal" data-target="#signupModal">-->
                                    @svg('heroicon-s-user-circle', ['style' => 'width:16px;'])
                                </a>
                            </div>
                        </li>

                        <!--<li class="list-inline-item">
                            <a href="{{ route('user.login') }}"
                               data-test="header.login">
                                {{ translate('Login') }}
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route('shops.create') }}">
                                {{ translate('Registration') }}
                            </a>
                        </li>-->
                @endauth
                <!-- End Account Login -->
                </ul>
            </div>
        </div>
        <!-- End Topbar -->
        <div id="logoAndNav" class="container">
            <!-- Nav -->
            <nav class="navbar navbar-expand-lg">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ route('home') }}" aria-label="{{ get_site_name() }}">
                    @php
                        $header_logo = get_setting('header_logo');
                    @endphp
                    @if ($header_logo != null)
                        <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}">
                    @else
                        <img src="{{ static_asset('img/logo.png') }}" alt="{{ env('APP_NAME') }}">
                    @endif
                </a>
                <!-- End Logo -->

                <!-- Responsive Toggle Button -->
                <button type="button" class="navbar-toggler btn btn-icon btn-sm rounded-circle"
                        aria-label="Toggle navigation"
                        aria-expanded="false"
                        aria-controls="navBar"
                        data-toggle="collapse"
                        data-target="#navBar">
            <span class="navbar-toggler-default">
              <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor" d="M17.4,6.2H0.6C0.3,6.2,0,5.9,0,5.5V4.1c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,5.9,17.7,6.2,17.4,6.2z M17.4,14.1H0.6c-0.3,0-0.6-0.3-0.6-0.7V12c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,13.7,17.7,14.1,17.4,14.1z"/>
              </svg>
            </span>
                    <span class="navbar-toggler-toggled">
              <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor" d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
              </svg>
            </span>
                </button>
                <!-- End Responsive Toggle Button -->

                <!-- Navigation -->
                <div id="navBar" class="collapse navbar-collapse">

                    <ul class="navbar-nav">
                        <!-- Home -->
                        @if (get_setting('header_menu_labels') != null)


                            @foreach (json_decode(get_setting('header_menu_labels'), true) as $key => $value)
                                @php
                                    $target = "_self";

                                @endphp
                                <li class="position-static">

                                    <a id="homeMegaMenu" class="nav-link"
                                       target="{{$target}}"
                                       href="{{ json_decode(get_setting('header_menu_links'), true)[$key] }}">
                                        {{ $value }}
                                    </a>
                                </li>
                        @endforeach

                    @endif


                    <!-- End Home -->

                        <!-- End Docs -->

                        <!-- Button -->
                        <li class="navbar-nav-last-item">
                            <x-join-button>
                            </x-join-button>
                        </li>
                        <!-- End Button -->
                    </ul>

                </div>
                <!-- End Navigation -->
            </nav>
            <!-- End Nav -->
        </div>
    </div>
</header>
<!-- ========== END HEADER ========== -->

@push('footer_scripts')
<!-- JS Plugins Init. -->
<script src="{{ static_asset('vendor/hs-header/dist/hs-header.min.js', false, true) }}"></script>
<script src="{{ static_asset('vendor/hs-show-animation/dist/hs-show-animation.min.js', false, true) }}"></script>
<script>
    $(document).on('ready', function () {
        // INITIALIZATION OF HEADER
        // =======================================================
        var header = new HSHeader($('#header')).init();


        // INITIALIZATION OF HSMEGAMENU COMPONENT
        // =======================================================
        var megaMenu = new HSMegaMenu($('.js-mega-menu')).init();


        // INITIALIZATION OF UNFOLD
        // =======================================================
        var unfold = new HSUnfold('.js-hs-unfold-invoker').init();


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
        $('.js-animation-link').each(function () {
            var showAnimation = new HSShowAnimation($(this)).init();
        });
    });
</script>

@endpush