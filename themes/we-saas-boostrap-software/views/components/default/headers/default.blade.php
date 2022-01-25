<!-- ========== HEADER ========== -->
<header id="header" class="header bg-primary shadow-lg" style="position: relative;">
    <div class="header-section">

        <!-- End Topbar -->
        <div id="logoAndNav" class="container">
            <!-- Nav -->
            <div class="row align-items-center">
                <div class="col-sm-3 col-6">
                    <a class="navbar-brand p-2" href="{{ route('home') }}" aria-label="{{ get_site_name() }}">
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
                </div>
                <div class="d-flex align-items-center ev-top-bar ">
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
                                        src="{{ global_asset('assets/img/flags/' . $language->code . '.png') }}"
                                        alt="SVG">

                                    {{ $language->name }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        <!-- End Language -->
                    </div>
                    <div class="ml-4 d-none">
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
                                <a class="js-hs-unfold-invoker btn btn-xs btn-icon btn-secondary" href="javascript:;"
                                    data-hs-unfold-options='{
                                      "target": "#searchPushTop",
                                      "type": "jquery-slide",
                                      "contentSelector": ".search-push-top"
                                     }'>
                                    @svg('heroicon-o-search', ['class' => 'square-22'])
                                </a>
                            </div>
                        </li>
                        <!-- End Search -->

                        <!-- Wish List Cart -->
                        <li class="list-inline-item">
                            <div class="hs-unfold">
                                <a class="btn btn-xs btn-icon btn-secondary position-relative"
                                href="javascript:;" x-data="" @click="$dispatch('display-flyout-panel', {'id': 'wishlist-panel'})" >
                                    @svg('heroicon-o-heart', ['class' => 'square-22'])
                                    {{-- TODO: Make count different, probably create a wishlist service like CartService
                                    --}}
                                    <div class="position-absolute badge badge-primary circle-dynamic"
                                        style="top: -6px; right: -6px; line-height: 0.8;   " x-data="{count: 2}"
                                        x-text="Number(count) > 99 ? '99+':count" x-cloak>
                                    </div>
                                </a>
                            </div>
                        </li>

                        <!-- Shopping Cart -->
                        <li class="list-inline-item">
                            <div class="hs-unfold">
                                <a class="btn btn-xs btn-icon btn-secondary position-relative" href="javascript:;"
                                    x-data="" @click="$dispatch('display-cart')">
                                    @svg('heroicon-o-shopping-cart', ['class' => 'square-22'])
                                    <div class="position-absolute badge badge-primary circle-dynamic"
                                        style="top: -6px; right: -6px; line-height: 0.8;   "
                                        x-data="{count: {{ \CartService::getTotalItemsCount() }}}"
                                        x-text="Number(count) > 99 ? '99+':count" x-cloak
                                        @refresh-cart-items-count.window="count = $event.detail.count">
                                    </div>
                                </a>
                            </div>
                        </li>
                        <!-- End Shopping Cart -->

                        <!-- Account Login -->
                        @auth

                        <li class="list-inline-item">
                            <!-- Account -->
                            <div class="hs-unfold">
                                <a class="js-hs-unfold-invoker navbar-dropdown-account-wrapper hs-active"
                                    href="javascript:;" data-hs-unfold-options="{
                                   &quot;target&quot;: &quot;#accountNavbarDropdown&quot;,
                                   &quot;type&quot;: &quot;css-animation&quot;
                                 }" data-hs-unfold-target="#accountNavbarDropdown" data-hs-unfold-invoker="">
                                    <div class="avatar avatar-sm avatar-circle bg-light">
                                        <img class="avatar-img" src="{{ auth()->user()->getAvatar() }}"
                                            alt="Image Description">
                                        <span
                                            class="avatar-status avatar-sm-status avatar-status-success bg-success"></span>
                                    </div>
                                </a>

                                <div id="accountNavbarDropdown"
                                    class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account hs-unfold-content-initialized hs-unfold-css-animation animated slideInUp"
                                    style="width: 16rem; animation-duration: 300ms;" data-hs-target-height="403.344"
                                    data-hs-unfold-content="" data-hs-unfold-content-animation-in="slideInUp"
                                    data-hs-unfold-content-animation-out="fadeOut">
                                    <div class="dropdown-item-text">
                                        <div class="media align-items-center">
                                            <div class="avatar avatar-sm avatar-circle bg-light mr-2">
                                                <img class="avatar-img" src="{{ auth()->user()->getAvatar() }}"
                                                    alt="Image Description">
                                            </div>
                                            <div class="media-body">
                                                <span class="card-title h5">{{ auth()->user()->name }}</span>
                                                <span class="card-text">{{ auth()->user()->email }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <span class="text-truncate pr-2" title="Profile &amp; account">
                                            {{ translate('Dashboard') }}
                                        </span>
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <!-- Unfold -->
                                    <div class="hs-unfold w-100">
                                        <a class="js-hs-unfold-invoker navbar-dropdown-submenu-item dropdown-item d-flex align-items-center"
                                            href="javascript:;" data-hs-unfold-options="{
                                       &quot;target&quot;: &quot;#navSubmenuPagesAccountDropdown1&quot;,
                                       &quot;event&quot;: &quot;hover&quot;
                                     }" data-hs-unfold-target="#navSubmenuPagesAccountDropdown1"
                                            data-hs-unfold-invoker="">
                                            <span class="text-truncate pr-2" title="Set status">Set status</span>
                                            <i
                                                class="tio-chevron-right navbar-dropdown-submenu-item-invoker ml-auto"></i>
                                        </a>

                                        <div id="navSubmenuPagesAccountDropdown1"
                                            class="hs-unfold-content hs-unfold-has-submenu dropdown-unfold dropdown-menu navbar-dropdown-sub-menu hs-unfold-hidden hs-unfold-content-initialized hs-unfold-simple"
                                            data-hs-target-height="0" data-hs-unfold-content="">
                                            <a class="dropdown-item" href="#">
                                                <span class="legend-indicator bg-success mr-1"></span>
                                                <span class="text-truncate pr-2" title="Available">Available</span>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <span class="legend-indicator bg-danger mr-1"></span>
                                                <span class="text-truncate pr-2" title="Busy">Busy</span>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <span class="legend-indicator bg-warning mr-1"></span>
                                                <span class="text-truncate pr-2" title="Away">Away</span>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">
                                                <span class="text-truncate pr-2" title="Reset status">Reset
                                                    status</span>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- End Unfold -->

                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        <span class="text-truncate pr-2" title="Profile &amp; account">Profile &amp;
                                            account</span>
                                    </a>

                                    <a class="dropdown-item" href="#">
                                        <span class="text-truncate pr-2" title="Settings">Settings</span>
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="#">
                                        <span class="text-truncate pr-2" title="Manage team">Manage team</span>
                                    </a>

                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('user.logout') }}" class="dropdown-item">
                                        {{ translate('Logout') }}
                                    </a>

                                </div>
                            </div>
                            <!-- End Account -->
                        </li>
                        @else
                        <li class="list-inline-item">
                            <div class="hs-unfold">
                                <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-secondary"
                                    href="{{ route('business.login') }}">
                                    <!--data-toggle="modal" data-target="#signupModal">-->
                                    @svg('heroicon-s-user-circle', ['class' => 'square-2'])
                                </a>
                            </div>
                        </li>
                        @endauth
                        <!-- End Account Login -->
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div class="sub-header d-none d-sm-block">
        <div class="container">
            <nav class="navbar navbar-expand">
                <!-- Responsive Toggle Button -->

                <!-- End Responsive Toggle Button -->

                <!-- Navigation -->
                <div id="navBar" class="">

                    <ul class="navbar-nav ml-0 mr-0 d-flex">
                        {{--
                        <!-- Home -->
                        <li class="category-dropdown-toggle">

                            <a href="#" class="nav-link text-white d-flex align-items-center fw-600">

                                @svg('heroicon-s-menu', ["class" => 'ev-icon__small mr-2'])

                                </span>{{ translate('Browse Categories') }}
                            </a>
                        </li> --}}
                        @if (get_setting('header_menu_labels') != null)


                        @foreach (get_setting('header_menu_labels') as $key => $value)
                        @php
                        $target = '_self';
                        $url = get_setting('header_menu_links')[$key];
                        if(Str::length($url) > 1) {
                        $url = ltrim($url, '/');
                        }

                        @endphp
                        <li class="position-static {{ request()->is($url) ? 'category-dropdown-toggle' : '' }}">
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
