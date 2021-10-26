<!-- ========== HEADER ========== -->
<header id="header" class="header header-box-shadow header-box-shadow-on-scroll header-floating-lg">
    <div id="logoAndNav" class="container">
        <div class="header-section header-floating-inner mx-lg-n3">
            <!-- Nav -->
            <nav class="js-mega-menu navbar navbar-expand-lg">

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

                <!-- Logo -->
                <a class="navbar-brand" href="{{ route('home') }}" aria-label="Front">
                    <img src="{{ $logo }}" alt="Logo">
                </a>
                <!-- End Logo -->

                <!-- Responsive Toggle Button -->

                <!-- End Responsive Toggle Button -->

                <!-- Navigation -->
                <div id="navBar" class="collapse navbar-collapse">
                    <ul class="navbar-nav">
                        <!-- Home -->
                        <li class="navbar-nav-item">
                            <a id="" class="nav-link"
                                href="/search" aria-haspopup="true" aria-expanded="false">
                                {{ translate('Products Catalog') }}
                            </a>


                        </li>
                        <!-- End Home -->

                        <!-- Pages -->
                        <li class="navbar-nav-item">
                            <a id="pagesMegaMenu" class="nav-link "
                                href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                aria-labelledby="pagesSubMenu">
                                {{ translate('Gun Range') }}
                            </a>


                        </li>
                        <!-- End Pages -->

                        <!-- Blog -->
                        <li class="navbar-nav-item">
                            <a id="blogMegaMenu" class="nav-link"
                                href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                aria-labelledby="blogSubMenu">
                            {{ translate('Contact us') }}
                            </a>


                        </li>
                        <!-- End Blog -->




                        <!-- Button -->
                        <li class="navbar-nav-last-item">
                            <a class="btn btn-sm btn-primary transition-3d-hover"
                                href="https://themes.getbootstrap.com/product/front-multipurpose-responsive-template/"
                                target="_blank">
                                {{ translate('Client area') }}
                            </a>
                        </li>
                        <!-- End Button -->
                    </ul>
                </div>

            </nav>

            <!-- End Nav -->
        </div>
    </div>
</header>
<!-- ========== END HEADER ========== -->

@push('footer_scripts')

<script src="{{ static_asset('vendor/hs-header/dist/hs-header.min.js', false, true) }}"></script>

    {{-- TODO Vukasin: Make this work - need to include hs-header propertly --}}
    {{-- How? :) --}}
    <script>
            // INITIALIZATION OF HEADER
            // =======================================================
            var header = new HSHeader($('#header')).init();
    </script>
@endpush
