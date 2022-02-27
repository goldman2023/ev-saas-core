<!-- ========== HEADER ========== -->
<header id="header" class="header shadow-lg" style="position: relative;">
    <div class="sub-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg">


                <x-default.system.tenant.logo style="max-width: 120px;">
                </x-default.system.tenant.logo>

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
                <div id="navBar" class="navbar-expand-lg navbar-expand-lg-collapse-block w-100">

                    <ul class="navbar-nav ml-0 mr-0 w-100 d-flex flex-nowrap">
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
                        <li class="ml-auto d-none d-sm-block position-relative">
                            @auth
                            @if(Auth::user()->user_type == 'seller')
                            <a href="{{ route('dashboard') }}" class="btn btn-white">
                                {{ translate('My Shop') }}
                            </a>
                            @else
                            <a href="{{ route('shops.create') }}" class="btn btn-white">
                                {{ translate('Become a Seller') }}

                                <div class="position-absolute badge badge-success d-flex align-items-center justify-content-center"
                                    style="top: -10px; right: -20px;  font-size: 14px;  ">
                                    {{ translate('Available in') }}
                                    <div style="font-size: 18px;" class="ml-1">
                                        🇪🇺
                                    </div>
                                </div>
                            </a>
                            @endif
                            @endauth

                        </li>

                        <!-- End Home -->

                        <!-- End Docs -->

                        <!-- Button -->

                        <!-- End Button -->
                    </ul>

                </div>

        </div>

    </div>
    <div class="header-section d-none d-sm-block">
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
                                @svg('heroicon-o-search', ['class' => 'square-22'])
                            </a>
                        </div>
                    </li>
                    <!-- End Search -->

                    <!-- Wish List Cart -->
                    <li class="list-inline-item">
                        <div class="hs-unfold">
                            <a class="btn btn-xs btn-icon btn-ghost-secondary position-relative" href="javascript:;"
                                x-data="" @click="$dispatch('display-flyout-panel', {'id': 'wishlist-panel'})">
                                @svg('heroicon-o-heart', ['class' => 'square-22'])
                                {{-- TODO: Make count different, probably create a wishlist service like CartService
                                --}}
                                <div class="position-absolute badge badge-primary circle-dynamic"
                                    style="top: -6px; right: -6px; line-height: 0.8;   "
                                    x-data="{count: {{ auth()->user()?->wishlists()?->count() ?? 0 }} }"
                                    x-text="Number(count) > 99 ? '99+':count"
                                    @refresh-wishlist-items-count.window="count = $event.detail.count;" x-cloak>
                                </div>
                            </a>
                        </div>
                    </li>

                    <!-- Shopping Cart -->
                    <li class="list-inline-item">
                        <div class="hs-unfold">
                            <a class="btn btn-xs btn-icon btn-ghost-secondary position-relative" href="javascript:;"
                                x-data="" @click="$dispatch('display-flyout-panel', {'id': 'cart-panel'})">
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
                        <div class="hs-unfold">
                            <a href="{{ route('user.logout') }}"
                            data-test="we-logout-header"
                            class="text-reset py-2 d-inline-block opacity-60">{{
                                translate('Logout') }}</a>
                        </div>
                    </li>
                    @else
                    <li class="list-inline-item">
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-secondary" href="javascript:;"
                                x-data="" @click="$dispatch('display-flyout-panel', {'id': 'auth-panel'})">
                                <!--data-toggle="modal" data-target="#signupModal">-->
                                @svg('heroicon-s-user-circle', ['class' => 'square-2'])
                            </a>
                        </div>
                    </li>

                    <li class="list-inline-item">
                        <a href="javascript:;" x-data=""
                        data-test="we-login-header"
                            @click="$dispatch('display-flyout-panel', {'id': 'auth-panel'})">
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

                <div class="col-sm-6 align-items-center d-none d-sm-block">
                    {{-- <x-b2-b-search></x-b2-b-search> --}}
                </div>

                <div class="col-sm-3 col-6">

                </div>
                <div class="col-sm-3 col-6 justify-content-end align-items-end text-right">

                    <x-join-button>
                    </x-join-button>

                    @auth
                    <div class="avatar avatar-sm avatar-soft-primary avatar-circle ml-3">
                        <span class="avatar-initials">EIM</span>
                        <span class="avatar-status avatar-sm-status avatar-status-success bg-success"></span>
                    </div>
                    @endauth
                </div>
                <!-- End Nav -->
            </div>

        </div>
    </div>

    <!-- End Navigation -->
    </div>
</header>

@if ($message = Session::get('message'))
<div class="alert alert-success alert-block mb-0"
data-test="we-user-feedback-inline-notification"
style="border-radius: 0;">
    <div class="container">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>

</div>
@endif

@if ($message = Session::get('Login'))
<div class="alert alert-info alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<strong>{{ $message }}</strong>
</div>
@endif
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
