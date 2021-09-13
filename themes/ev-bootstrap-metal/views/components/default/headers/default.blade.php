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
                        <x-ev.label :label="ev_dynamic_translate('Company Email', true)"></x-ev.label>
                    </div>
                </li>

                <li class="list-inline-item">
                    @svg('bi-building', 'w-6')

                    <div class="hs-unfold">
                        <x-ev.label :label="ev_dynamic_translate('Company Address', true)"></x-ev.label>
                    </div>
                </li>

                <li class="list-inline-item">
                    <a href="{{ route('business.login') }}"
                       data-test="header.login">
                        {{ translate('Client Area') }}
                    </a>
                </li>
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


                            @foreach (get_setting('header_menu_labels') as $key => $value)
                                @php
                                    $target = "_self";

                                @endphp
                                <li class="position-static">

                                    <a id="homeMegaMenu" class="nav-link"
                                       target="{{$target}}"
                                       href="{{ get_setting('header_menu_links')[$key] }}">
                                        {{ $value }}
                                    </a>
                                </li>
                        @endforeach

                    @endif


                    <!-- End Home -->

                        <!-- End Docs -->

                        <!-- Button -->
                        <li class="navbar-nav-last-item">
                            {{-- <x-join-button>
                            </x-join-button> --}}
                            <a class="btn btn-primary" href="tel:+37065593933">+37065593933</a>
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

