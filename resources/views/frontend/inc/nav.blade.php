<!-- Top Bar -->
<div class="top-navbar bg-secondary z-1035">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col">
                <ul class="list-inline d-flex justify-content-between justify-content-lg-start mb-0">
                    @if (get_setting('show_language_switcher') == 'on')
                        <li class="list-inline-item dropdown mr-3" id="lang-change">
                            @php
                                if (Session::has('locale')) {
                                    $locale = Session::get('locale', Config::get('app.locale'));
                                } else {
                                    $locale = 'en';
                                }
                            @endphp
                            <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2" data-toggle="dropdown"
                                data-display="static">
                                <img src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ static_asset('assets/img/flags/' . $locale . '.png') }}"
                                    class="mr-2 lazyload"
                                    alt="{{ \App\Models\Language::where('code', $locale)->first()->name }}" height="11">
                                <span
                                    class="opacity-60">{{ \App\Models\Language::where('code', $locale)->first()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-left">
                                @foreach (\App\Models\Language::all() as $key => $language)
                                    <li>
                                        <a href="javascript:void(0)" data-flag="{{ $language->code }}"
                                            class="dropdown-item @if ($locale==$language) active @endif">
                                            <img src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ static_asset('assets/img/flags/' . $language->code . '.png') }}"
                                                class="mr-1 lazyload" alt="{{ $language->name }}" height="11">
                                            <span class="language">{{ $language->name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif

                    @if (get_setting('show_currency_switcher') == 'on')

                        <li class="list-inline-item dropdown" id="currency-change">
                            @php
                                if (Session::has('currency_code')) {
                                    $currency_code = Session::get('currency_code');
                                } else {
                                    $currency_code = \App\Models\Currency::findOrFail(\App\Models\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
                                }
                            @endphp
                            <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2 opacity-60"
                                data-toggle="dropdown" data-display="static">
                                {{ \App\Models\Currency::where('code', $currency_code)->first()->name }}
                                {{ \App\Models\Currency::where('code', $currency_code)->first()->symbol }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                @foreach (\App\Models\Currency::where('status', 1)->get() as $key => $currency)
                                    <li>
                                        <a class="dropdown-item @if ($currency_code==$currency->code) active @endif"
                                            href="javascript:void(0)"
                                            data-currency="{{ $currency->code }}">{{ $currency->name }}
                                            ({{ $currency->symbol }})</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="col-12 col-lg-5 text-right d-block">
                <ul class="list-inline mb-0 text-white">
                    <li class="list-inline-item mr-3">
                        @include('frontend.partials.header-greeting')
                    </li>

                    @auth
                        @if (isAdmin())
                            <li class="list-inline-item mr-3">
                                <a href="{{ route('admin.dashboard') }}"
                                    class="text-reset py-2 d-inline-block opacity-60">{{ translate('My Panel') }}</a>
                            </li>
                        @else
                            <li class="list-inline-item mr-3">
                                <a href="{{ route('dashboard') }}"
                                    class="text-reset py-2 d-inline-block opacity-60">{{ translate('My Panel') }}</a>
                            </li>
                        @endif
                        <li class="list-inline-item">
                            <a href="{{ route('logout') }}"
                                class="text-reset py-2 d-inline-block opacity-60">{{ translate('Logout') }}</a>
                        </li>
                    @else
                        <li class="list-inline-item mr-3">
                            <a href="{{ route('user.login') }}"
                                class="text-reset py-2 d-inline-block opacity-60" data-test="header.login">{{ translate('Login') }}</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route('shops.create') }}" class="text-reset py-2 d-inline-block opacity-60">
                                {{ translate('Registration') }}</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END Top Bar -->
<header class="@if (get_setting('header_stikcy')=='on' ) sticky-top @endif z-1020 bg-white shadow-sm">
    <div class="position-relative logo-bar-area z-1 bg-primary">
        <div class="container">
            <div class="d-flex align-items-center">

                <div class="col-auto col-xl-3 pl-0 pr-3 d-flex align-items-center">
                    <a class="d-block py-20px mr-3 ml-0" href="{{ route('home') }}">
                        @php
                            $header_logo = get_setting('header_logo');
                        @endphp
                        @if ($header_logo != null)
                            <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}"
                                class="mw-100 h-30px h-md-40px" height="40">
                        @else
                            <img src="{{ static_asset('img/logo.png') }}" alt="{{ env('APP_NAME') }}"
                                class="mw-100 h-30px h-md-40px" height="40">
                        @endif
                    </a>

                    @if (Route::currentRouteName() != 'home')
                        <div class="d-none align-self-stretch category-menu-icon-box ml-auto mr-0">
                            <div class="h-100 d-flex align-items-center" id="category-menu-icon">
                                <div
                                    class="dropdown-toggle navbar-light bg-light h-40px w-50px pl-2 rounded border c-pointer">
                                    <span class="navbar-toggler-icon"></span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="ml-auto mr-0">
                    <a class="p-2 d-none text-reset d-none" href="javascript:void(0);" data-toggle="class-toggle"
                        data-target=".front-header-search">
                        <i class="las la-search la-flip-horizontal la-2x"></i>
                    </a>
                </div>

                <!-- B2B Search -->
                {{-- <x-b2-b-search></x-b2-b-search> --}}
                <!-- END B2B Search -->

                <div class="d-none d-lg-none ml-3 mr-0">
                    <div class="nav-search-box">
                        <a href="#" class="nav-box-link">
                            <i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>
                        </a>
                    </div>
                </div>


                <div class="ml-auto mr-0">
                    @auth
                        <div class="text-white" id="wishlist">
                            {{-- @include('frontend.components.messages-dropdown') --}}
                        </div>
                    @else

                    @endauth

                        <div class="d-flex">
                            @auth
                                {{-- TODO: Make this enabled and disabled option in admin panel --}}

                                <div class="d-none text-white align-items-center">
                                    @include('frontend.partials.notification')
                                    @include('frontend.partials.wishlist')
                                </div>
                            @else

                            @endauth
                            <x-join-button></x-join-button>
                        </div>
                </div>

                <div class="d-none  align-self-stretch ml-3 mr-0" data-hover="dropdown">
                    <div class="nav-cart-box dropdown h-100" id="cart_items">
                        @include('frontend.partials.cart')
                    </div>
                </div>

            </div>
        </div>
        @if (Route::currentRouteName() != 'home')
            <div class="hover-category-menu position-absolute w-100 top-100 left-0 right-0 d-none z-3"
                id="hover-category-menu">
                <div class="container">
                    <div class="row gutters-10 position-relative">
                        <div class="col-lg-3 position-static">
                            @include('frontend.partials.category_menu')
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @if (get_setting('header_menu_labels') != null)
        <div class="bg-white border-top border-gray-200 py-1" id="b2b-main-menu">
            <div class="container">
                <ul class="list-inline mb-0 pl-0 mobile-hor-swipe text-center">
                    @foreach (json_decode(get_setting('header_menu_labels'), true) as $key => $value)
                        @php
                            $target = "_self";

                        @endphp
                        <li class="list-inline-item mr-0">
                            <a href="{{ json_decode(get_setting('header_menu_links'), true)[$key] }}"
                                class="opacity-100 fs-14 px-3 py-2 d-inline-block fw-600 hov-opacity-60 text-reset"
                                target="{{$target}}">
                                {{ translate($value) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if (isset($blog))
        <div id="b2b-progress-bar"></div>
    @endif
</header>
