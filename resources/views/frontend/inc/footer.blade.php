<x-footer-bottom-links></x-footer-bottom-links>

<section class="bg-dark py-5 text-light footer-widget">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-xl-12 text-center text-md-left">
                <a href="{{ route('home') }}" class="d-block">
                    @if (get_setting('footer_logo') != null)
                        <img class="lazyload" src="{{ static_asset('assets/img/logo.jpg') }}"
                             data-src="{{ uploaded_asset(get_setting('footer_logo')) }}" alt="{{ get_site_name() }}"
                             height="44">
                    @else
                        <img class="lazyload" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                             data-src="{{ static_asset('assets/img/logo.png') }}" alt="{{ get_site_name() }}"
                             height="44">
                    @endif
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 pt-4 text-center text-md-left">


                <h4 class="fs-16 fw-600 text-white mb-3">
                    {{ translate('Contacts') }}
                </h4>

                <ul class="list-unstyled">
                    <li class="mb-1">
                        {{ translate('Company:') }} {{ get_site_name() }}
                    </li>

                    <li class="mb-1">
                        {{ translate('Address:') }} {{ get_setting('contact_address') }}
                    </li>

                    <li class="mb-1">
                        {{ translate('Phone:') }} {{ get_setting('contact_phone') }}
                    </li>

                    <li class="mb-1">
                        {{ translate('Email:') }}{{ get_setting('contact_email') }}
                    </li>
                </ul>

                <x-b2b-newsletter-form-footer></x-b2b-newsletter-form-footer>
            </div>
            <div class="col-lg-3 col-md-3 pt-4">
                <div class="text-center text-md-left">
                    <h4 class="fs-16 fw-600 text-white">
                        {{ translate('Who We Are') }}
                    </h4>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a class="text-white" href="/page/company/">
                                {{ translate('Company') }} </a>
                        </li>
                        <li class="mb-2">
                            <a class="text-white"  href="/page/careers/">
                                {{ translate('Careers') }} </a>
                        </li>
                        {{-- <li class="mb-2">
                            <a class="text-white" rel="noopener" target="_blank" href="/page/partners/">
                                {{ translate('Partners') }} </a>
                        </li> --}}
                        <li class="mb-2">
                            <a class="text-white" href="/page/contacts/">
                                {{ translate('Contact Us') }} </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 pt-4">
                <div class="text-center text-md-left">

                    <h4 class="fs-16 fw-600 text-white">
                        {{ translate('What We Do') }}
                    </h4>
                    {{-- TODO: Make this dynamic --}}
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a class="text-white"  href="{{ route('shops.create') }}">
                                {{ translate('Become a club member') }} </a>
                        </li>

                        <li class="mb-2">
                            <a class="text-white" href="/page/pricing/">
                                {{ translate('Pricing and Club Memberships') }} </a>
                        </li>
                        <li class="mb-2">
                            <a class="text-white" href="/page/verification/">
                                {{ translate('Verification') }} </a>
                        </li>
                        <li class="mb-2">
                            {{-- <a class="text-white" rel="noopener" target="_blank" href="#"> {{ translate('Customers stories') }} </a> --}}
                        </li>
                        <li class="mb-2">
                            <a class="text-white" href="/page/advertising/">
                                {{ translate('Advertising') }} </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 pt-4">
                <div class="text-center text-md-left">
                    <h4 class="fs-16 fw-600 text-white">
                        {{ translate('Helpful Links') }}
                    </h4>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a class="text-white" href="{{ route('shops.create') }}">
                                {{ translate('Create a Profile') }} </a>
                        </li>
<!--                        <li class="mb-2">
                            <a class="text-white"  href="#">
                                {{ translate('Knowledge Center') }} </a>
                        </li>-->
                        <li class="mb-2">
                            <a class="text-white" href="/page/privacy/"> {{ translate('Privacy') }}
                            </a>
                        </li>

                        <li class="mb-2">
                            <a class="text-white"
                               href="/page/terms-and-conditions/"> {{ translate('Terms And Conditions') }}
                            </a>
                        </li>
                    </ul>

                    <x-join-button></x-join-button>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="pt-3 pb-7 pb-xl-3 text-light" id="ev-saas-footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <div class="text-center text-md-left">
                    @php
                        echo get_setting('frontend_copyright_text');
                    @endphp
                </div>
            </div>
            <div class="col-lg-4">
                <ul class="list-inline my-3 my-md-0 social colored text-center">
                    @if (get_setting('facebook_link') != null)
                        <li class="list-inline-item">
                            <a href="{{ get_setting('facebook_link') }}" target="_blank" class="facebook"><i
                                    class="lab la-facebook-f"></i></a>
                        </li>
                    @endif
                    @if (get_setting('twitter_link') != null)
                        <li class="list-inline-item">
                            <a href="{{ get_setting('twitter_link') }}" target="_blank" class="twitter"><i
                                    class="lab la-twitter"></i></a>
                        </li>
                    @endif
                    @if (get_setting('instagram_link') != null)
                        <li class="list-inline-item">
                            <a href="{{ get_setting('instagram_link') }}" target="_blank" class="instagram"><i
                                    class="lab la-instagram"></i></a>
                        </li>
                    @endif
                    @if (get_setting('youtube_link') != null)
                        <li class="list-inline-item">
                            <a href="{{ get_setting('youtube_link') }}" target="_blank" class="youtube"><i
                                    class="lab la-youtube"></i></a>
                        </li>
                    @endif
                    @if (get_setting('linkedin_link') != null)
                        <li class="list-inline-item">
                            <a href="{{ get_setting('linkedin_link') }}" target="_blank" class="linkedin"><i
                                    class="lab la-linkedin-in"></i></a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="col-lg-4">
                <div class="text-center text-md-right">
                    <ul class="list-inline mb-0">
                        @if (get_setting('payment_method_images') != null)
                            @foreach (explode(',', get_setting('payment_method_images')) as $key => $value)
                                <li class="list-inline-item">
                                    <img src="{{ uploaded_asset($value) }}" height="30" class="mw-100 h-auto"
                                         style="max-height: 100px">
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="aiz-mobile-bottom-nav d-xl-none fixed-bottom bg-white shadow-lg border-top">
    <div class="d-flex justify-content-around align-items-center">
        <a href="{{ route('home') }}"
           class="text-reset flex-grow-1 text-center py-3 border-right {{ areActiveRoutes(['home'], 'bg-soft-primary') }}">
            <i class="las la-home la-2x"></i>
            <div class="fs-12">
                {{ translate('Home') }}
            </div>
        </a>
        <a href="{{ route('categories.all') }}"
           class="text-reset flex-grow-1 text-center py-3 border-right {{ areActiveRoutes(['categories.all'], 'bg-soft-primary') }}">
            <span class="d-inline-block position-relative px-2">
                <i class="las la-list-ul la-2x"></i>
                <div class="fs-12">
                    {{ translate('Industries') }}
                </div>
            </span>
        </a>
        {{-- TODO Implement option to disable cart --}}
        @if (1 > 2)
            <a href="{{ route('cart') }}"
               class="text-reset flex-grow-1 text-center py-3 border-right {{ areActiveRoutes(['cart'], 'bg-soft-primary') }}">
                <span class="d-inline-block position-relative px-2">
                    <i class="las la-shopping-cart la-2x"></i>
                    @if (Session::has('cart'))
                        <span class="badge badge-circle badge-primary position-absolute absolute-top-right"
                              id="cart_items_sidenav">{{ count(Session::get('cart')) }}</span>
                    @else
                        <span class="badge badge-circle badge-primary position-absolute absolute-top-right"
                              id="cart_items_sidenav">0</span>
                    @endif
                </span>
            </a>
        @endif
        @if (Auth::check())
            @if (isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="text-reset flex-grow-1 text-center py-2">
                    <span class="avatar avatar-sm d-block mx-auto">
                        @if (auth()->user()->photo != null)
                            <img alt="user avatar" src="{{ custom_asset(auth()->user()->avatar_original) }}">
                        @else
                            <img alt="user avatar" src="{{ static_asset('assets/img/avatar-place.png') }}">
                        @endif
                    </span>
                </a>
            @else
                @if(Auth::user()->user_type == 'seller')
                <a href="javascript:void(0)" class="text-reset flex-grow-1 text-center py-2 mobile-side-nav-thumb"
                   data-toggle="class-toggle" data-target=".aiz-mobile-side-nav">
                    <span class="avatar avatar-sm d-block mx-auto">
                        <img class="img-fluid" style="object-fit:contain;"
                             src="{{ auth()->user()->shop->get_company_logo() }}"
                             alt="{{ auth()->user()->shop->name }}">
                    </span>

                    <div class="fs-12">
                        {{ translate('Company Profile') }}
                    </div>
                </a>
                    @endif
            @endif
        @else
            <a href="{{ route('business.login') }}" class="text-reset flex-grow-1 text-center py-2">
                <span class="avatar avatar-sm d-block mx-auto">
                    <img alt="user avatar" src="{{ static_asset('assets/img/promo/b2b-wood-logo-bg.jpeg') }}">
                </span>
                <div class="fs-12">
                    {{ translate('Join') }} {{ get_site_name() }}
                </div>
            </a>
        @endif
    </div>
</div>
@if (Auth::check() && !isAdmin())
    <div class="aiz-mobile-side-nav collapse-sidebar-wrap sidebar-xl d-xl-none z-1035">
        <div class="overlay dark c-pointer overlay-fixed" data-toggle="class-toggle" data-target=".aiz-mobile-side-nav"
             data-same=".mobile-side-nav-thumb"></div>
        <div class="collapse-sidebar bg-white">
            @include('frontend.inc.user_side_nav')
        </div>
    </div>
@endif
