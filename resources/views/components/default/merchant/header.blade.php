<!-- ========== HEADER ========== -->
<header id="header" class="header header-box-shadow header-box-shadow-on-scroll header-floating-lg">
    <div id="logoAndNav" class="container">
        <div class="header-section header-floating-inner mx-lg-n3">
            <!-- Nav -->
            <nav class="js-mega-menu navbar navbar-expand-lg">
                <!-- Logo -->
                <a class="navbar-brand" href="#" aria-label="Front">
                    <img src="{{ $logo }}" alt="Logo">
                </a>
                <!-- End Logo -->

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
                    <ul class="navbar-nav">
                        <!-- Home -->
                        <li class="hs-has-mega-menu navbar-nav-item">
                            <a id="homeMegaMenu" class="hs-mega-menu-invoker nav-link nav-link-toggle"
                                href="javascript:;" aria-haspopup="true" aria-expanded="false">Landings</a>

                            <!-- Home - Mega Menu -->
                            <div class="hs-mega-menu dropdown-menu w-100" aria-labelledby="homeMegaMenu">
                                <div class="row no-gutters">
                                    <div class="col-lg-6">
                                        <!-- Banner Image -->
                                        <div class="navbar-banner"
                                            style="background-image: url(../../assets/img/750x750/img1.jpg);">
                                            <div class="navbar-banner-content">
                                                <div class="mb-4">
                                                    <span class="h2 d-block text-white">Branding Works</span>
                                                    <p class="text-white">Experience a level of our quality in both
                                                        design & customization works.</p>
                                                </div>
                                                <a class="btn btn-primary btn-sm transition-3d-hover" href="#">Learn
                                                    More <i class="fas fa-angle-right fa-sm ml-1"></i></a>
                                            </div>
                                        </div>
                                        <!-- End Banner Image -->
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row mega-menu-body">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <span class="d-block h5">Classic</span>
                                                <a class="dropdown-item" href="#">Agency</a>
                                                <a class="dropdown-item" href="#">Analytics <span
                                                        class="badge badge-primary badge-pill ml-2">Hot</span></a>
                                                <a class="dropdown-item" href="#">Studio</a>
                                                <a class="dropdown-item" href="#">Marketing</a>
                                                <a class="dropdown-item" href="#">Advertisement <span
                                                        class="badge badge-primary badge-pill ml-2">Hot</span></a>
                                                <a class="dropdown-item" href="#">Consulting</a>
                                                <a class="dropdown-item" href="#">Portfolio</a>
                                                <a class="dropdown-item" href="#">Software</a>
                                                <a class="dropdown-item" href="#">Business</a>
                                            </div>

                                            <div class="col-sm-6">
                                                <span class="d-block h5">App</span>
                                                <div class="mb-3">
                                                    <a class="dropdown-item" href="#">UI Kit</a>
                                                    <a class="dropdown-item" href="#">SaaS</a>
                                                    <a class="dropdown-item" href="#">Workflow</a>
                                                    <a class="dropdown-item" href="#">Payment</a>
                                                    <a class="dropdown-item" href="#">Tool</a>
                                                </div>

                                                <span class="d-block h5">Onepages</span>
                                                <a class="dropdown-item" href="#">Corporate</a>
                                                <a class="dropdown-item" href="#">SaaS <span
                                                        class="badge badge-primary badge-pill ml-2">Hot</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Home - Mega Menu -->
                        </li>
                        <!-- End Home -->

                        <!-- Pages -->
                        <li class="hs-has-sub-menu navbar-nav-item">
                            <a id="pagesMegaMenu" class="hs-mega-menu-invoker nav-link nav-link-toggle"
                                href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                aria-labelledby="pagesSubMenu">Pages</a>

                            <!-- Pages - Submenu -->
                            <div id="pagesSubMenu" class="hs-sub-menu dropdown-menu" aria-labelledby="pagesMegaMenu"
                                style="min-width: 230px;">
                                <!-- Account -->
                                <!-- Company -->
                                <div class="hs-has-sub-menu">
                                    <a id="navLinkPagesCompany"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navSubmenuPagesCompany">Company</a>

                                    <div id="navSubmenuPagesCompany" class="hs-sub-menu dropdown-menu"
                                        aria-labelledby="navLinkPagesCompany" style="min-width: 230px;">
                                        <a class="dropdown-item" href="#">About Agency</a>
                                        <a class="dropdown-item" href="#">Services Agency</a>
                                        <a class="dropdown-item" href="#">Customers</a>
                                        <a class="dropdown-item" href="#">Customer story</a>
                                        <a class="dropdown-item" href="#">Careers</a>
                                        <a class="dropdown-item" href="#">Careers Single</a>
                                        <a class="dropdown-item" href="#">Hire Us</a>
                                    </div>
                                </div>
                                <!-- Company -->

                                <!-- Portfolio -->
                                <div class="hs-has-sub-menu">
                                    <a id="navLinkPagesPortfolio"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navSubmenuPagesPortfolio">Portfolio</a>

                                    <div id="navSubmenuPagesPortfolio" class="hs-sub-menu dropdown-menu"
                                        aria-labelledby="navLinkPagesPortfolio" style="min-width: 230px;">
                                        <a class="dropdown-item" href="#">Grid</a>
                                        <a class="dropdown-item" href="#">Masonry</a>
                                        <a class="dropdown-item" href="#">Modern</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Case Studies Branding</a>
                                        <a class="dropdown-item" href="#">Case Studies Product</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Single Page List</a>
                                        <a class="dropdown-item" href="#">Single Page Grid</a>
                                        <a class="dropdown-item" href="#">Single Page Masonry</a>
                                    </div>
                                </div>
                                <!-- End Portfolio -->

                                <!-- Login -->
                                <div class="hs-has-sub-menu">
                                    <a id="navLinkPagesLogin"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navSubmenuPagesLogin">Login & Signup</a>

                                    <div id="navSubmenuPagesLogin" class="hs-sub-menu dropdown-menu"
                                        aria-labelledby="navLinkPagesLogin" style="min-width: 230px;">
                                        <a class="dropdown-item" href="#">Login</a>
                                        <a class="dropdown-item" href="#">Signup</a>
                                        <a class="dropdown-item" href="#">Recover Account</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Login Simple</a>
                                        <a class="dropdown-item" href="#">Signup Simple</a>
                                        <a class="dropdown-item" href="#">Recover Account Simple</a>
                                    </div>
                                </div>
                                <!-- Signup -->

                                <!-- Contacts -->
                                <div class="hs-has-sub-menu">
                                    <a id="navLinkContactsServices"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navSubmenuContactsServices">Contacts</a>

                                    <div id="navSubmenuContactsServices" class="hs-sub-menu dropdown-menu"
                                        aria-labelledby="navLinkContactsServices" style="min-width: 230px;">
                                        <a class="dropdown-item" href="#">Contacts Agency</a>
                                        <a class="dropdown-item" href="#">Contacts Start-Up</a>
                                    </div>
                                </div>
                                <!-- Contacts -->

                                <!-- Utilities -->
                                <div class="hs-has-sub-menu">
                                    <a id="navLinkPagesUtilities"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navSubmenuPagesUtilities">Utilities</a>

                                    <div id="navSubmenuPagesUtilities" class="hs-sub-menu dropdown-menu"
                                        aria-labelledby="navLinkPagesUtilities" style="min-width: 230px;">
                                        <a class="dropdown-item" href="#">Pricing</a>
                                        <a class="dropdown-item" href="#">FAQ</a>
                                        <a class="dropdown-item" href="#">Terms & Conditions</a>
                                        <a class="dropdown-item" href="#">Privacy & Policy</a>
                                    </div>
                                </div>
                                <!-- Utilities -->

                                <!-- Specialty -->
                                <div class="hs-has-sub-menu">
                                    <a id="navLinkPagesSpecialty"
                                        class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle"
                                        href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                        aria-controls="navSubmenuPagesSpecialty">Specialty</a>

                                    <div id="navSubmenuPagesSpecialty" class="hs-sub-menu dropdown-menu"
                                        aria-labelledby="navLinkPagesSpecialty" style="min-width: 230px;">
                                        <a class="dropdown-item" href="#">Cover Page</a>
                                        <a class="dropdown-item" href="#">Coming Soon</a>
                                        <a class="dropdown-item" href="#">Maintenance Mode</a>
                                        <a class="dropdown-item" href="#">Status</a>
                                        <a class="dropdown-item" href="#">Invoice</a>
                                        <a class="dropdown-item" href="#">Error 404</a>
                                    </div>
                                </div>
                                <!-- Specialty -->
                            </div>
                            <!-- End Pages - Submenu -->
                        </li>
                        <!-- End Pages -->

                        <!-- Blog -->
                        <li class="hs-has-sub-menu navbar-nav-item">
                            <a id="blogMegaMenu" class="hs-mega-menu-invoker nav-link nav-link-toggle"
                                href="javascript:;" aria-haspopup="true" aria-expanded="false"
                                aria-labelledby="blogSubMenu">Blog</a>

                            <!-- Blog - Submenu -->
                            <div id="blogSubMenu" class="hs-sub-menu dropdown-menu" aria-labelledby="blogMegaMenu"
                                style="min-width: 230px;">
                                <a class="dropdown-item" href="#">Journal</a>
                                <a class="dropdown-item" href="#">Metro</a>
                                <a class="dropdown-item" href="#">Newsroom</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Blog Profile</a>
                                <a class="dropdown-item" href="#">Single Article</a>
                            </div>
                            <!-- End Submenu -->
                        </li>
                        <!-- End Blog -->

                        <!-- Shop -->
                        <li class="hs-has-mega-menu navbar-nav-item" data-hs-mega-menu-item-options='{
                    "desktop": {
                      "position": "right",
                      "maxWidth": "440px"
                    }
                  }'>
                            <a id="shopMegaMenu" class="hs-mega-menu-invoker nav-link nav-link-toggle"
                                href="javascript:;" aria-haspopup="true" aria-expanded="false">Shop</a>

                            <!-- Shop - Mega Menu -->
                            <div class="hs-mega-menu dropdown-menu" aria-labelledby="shopMegaMenu">
                                <div class="mega-menu-body">
                                    <span class="d-block h5">Shop Elements</span>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a class="dropdown-item" href="#">Classic</a>
                                            <a class="dropdown-item" href="#">Categories</a>
                                            <a class="dropdown-item" href="#">Categories Sidebar</a>
                                            <a class="dropdown-item" href="#">Products Grid</a>
                                            <a class="dropdown-item" href="#">Products List</a>
                                        </div>

                                        <div class="col-sm-6">
                                            <a class="dropdown-item" href="#">Single Product</a>
                                            <a class="dropdown-item" href="#">Empty Cart</a>
                                            <a class="dropdown-item" href="#">Cart</a>
                                            <a class="dropdown-item" href="#">Checkout</a>
                                            <a class="dropdown-item" href="#">Order Completed</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mega Menu Banner -->
                                <div class="navbar-product-banner">
                                    <div class="d-flex align-items-end">
                                        <img class="img-fluid mr-4" src="../../assets/img/mockups/img4.png"
                                            alt="Image Description">
                                        <div class="navbar-product-banner-content">
                                            <div class="mb-4">
                                                <span class="h4 d-block text-primary">Win T-shirt</span>
                                                <p>Win one of our Front brand T-shirts.</p>
                                            </div>
                                            <a class="btn btn-sm btn-soft-primary transition-3d-hover" href="#">Learn
                                                More <i class="fas fa-angle-right fa-sm ml-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Mega Menu Banner -->
                            </div>
                            <!-- End Shop - Mega Menu -->
                        </li>
                        <!-- End Shop -->

                        <!-- Demos -->
                        <li class="hs-has-mega-menu navbar-nav-item" data-hs-mega-menu-item-options='{
                    "desktop": {
                      "position": "right",
                      "maxWidth": "900px"
                    }
                  }'>
                            <a id="demosMegaMenu" class="hs-mega-menu-invoker nav-link nav-link-toggle"
                                href="javascript:;" aria-haspopup="true" aria-expanded="false">Demos</a>

                            <!-- Demos - Mega Menu -->
                            <div class="hs-mega-menu dropdown-menu w-100" aria-labelledby="demosMegaMenu">
                                <div class="row no-gutters">
                                    <div class="col-lg-8">
                                        <div class="navbar-promo-card-deck">
                                            <!-- Promo Item -->
                                            <div class="navbar-promo-card navbar-promo-item">
                                                <a class="navbar-promo-link" href="#">
                                                    <div class="media align-items-center">
                                                        <img class="navbar-promo-icon"
                                                            src="../../assets/svg/icons/icon-67.svg" alt="SVG">
                                                        <div class="media-body">
                                                            <span class="navbar-promo-title">Course <span
                                                                    class="badge badge-success badge-pill ml-1">New</span></span>
                                                            <span class="navbar-promo-text">Learn On-demand demo</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <!-- End Promo Item -->

                                            <!-- Promo Item -->
                                            <div class="navbar-promo-card navbar-promo-item">
                                                <a class="navbar-promo-link" href="#">
                                                    <div class="media align-items-center">
                                                        <img class="navbar-promo-icon"
                                                            src="../../assets/svg/icons/icon-45.svg" alt="SVG">
                                                        <div class="media-body">
                                                            <span class="navbar-promo-title">App Marketplace</span>
                                                            <span class="navbar-promo-text">Marketplace app demo</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <!-- End Promo Item -->
                                        </div>

                                        <div class="navbar-promo-card-deck">
                                            <!-- Promo Item -->
                                            <div class="navbar-promo-card navbar-promo-item">
                                                <a class="navbar-promo-link" href="#">
                                                    <div class="media align-items-center">
                                                        <img class="navbar-promo-icon"
                                                            src="../../assets/svg/icons/icon-4.svg" alt="SVG">
                                                        <div class="media-body">
                                                            <span class="navbar-promo-title">Help Desk</span>
                                                            <span class="navbar-promo-text">Help desk demo</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <!-- End Promo Item -->

                                            <!-- Promo Item -->
                                            <div class="navbar-promo-card navbar-promo-item">
                                                <a class="navbar-promo-link disabled" href="#">
                                                    <div class="media align-items-center">
                                                        <img class="navbar-promo-icon"
                                                            src="../../assets/svg/icons/icon-5.svg" alt="SVG">
                                                        <div class="media-body">
                                                            <span class="navbar-promo-title">Account</span>
                                                            <span class="navbar-promo-text">Coming soon...</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <!-- End Promo Item -->
                                        </div>

                                        <div class="navbar-promo-card-deck">
                                            <!-- Promo Item -->
                                            <div class="navbar-promo-card navbar-promo-item">
                                                <a class="navbar-promo-link disabled" href="#">
                                                    <div class="media align-items-center">
                                                        <img class="navbar-promo-icon"
                                                            src="../../assets/svg/icons/icon-19.svg" alt="SVG">
                                                        <div class="media-body">
                                                            <span class="navbar-promo-title">Job</span>
                                                            <span class="navbar-promo-text">Coming soon...</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <!-- End Promo Item -->

                                            <!-- Promo Item -->
                                            <div class="navbar-promo-card navbar-promo-item">
                                                <a class="navbar-promo-link disabled" href="#">
                                                    <div class="media align-items-center">
                                                        <img class="navbar-promo-icon"
                                                            src="../../assets/svg/icons/icon-13.svg" alt="SVG">
                                                        <div class="media-body">
                                                            <span class="navbar-promo-title">House</span>
                                                            <span class="navbar-promo-text">Coming soon...</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <!-- End Promo Item -->
                                        </div>
                                    </div>

                                    <!-- Promo -->
                                    <div class="col-lg-4 navbar-promo d-none d-lg-block">
                                        <a class="d-block navbar-promo-inner" href="#">
                                            <div class="position-relative">
                                                <img class="img-fluid rounded mb-3"
                                                    src="../../assets/img/380x227/img1.jpg" alt="Image Description">
                                            </div>
                                            <span class="navbar-promo-text font-size-1">Front makes you look at things
                                                from a different perspectives.</span>
                                        </a>
                                    </div>
                                    <!-- End Promo -->
                                </div>
                            </div>
                            <!-- End Demos - Mega Menu -->
                        </li>
                        <!-- End Demos -->

                        <!-- Docs -->
                        <li class="hs-has-mega-menu navbar-nav-item" data-hs-mega-menu-item-options='{
                    "desktop": {
                      "position": "right",
                      "maxWidth": "260px"
                    }
                  }'>
                            <a id="docsMegaMenu" class="hs-mega-menu-invoker nav-link nav-link-toggle"
                                href="javascript:;" aria-haspopup="true" aria-expanded="false">Docs</a>

                            <!-- Docs - Submenu -->
                            <div class="hs-mega-menu dropdown-menu" aria-labelledby="docsMegaMenu"
                                style="min-width: 330px;">
                                <!-- Promo Item -->
                                <div class="navbar-promo-item">
                                    <a class="navbar-promo-link" href="#">
                                        <div class="media align-items-center">
                                            <img class="navbar-promo-icon" src="../../assets/svg/icons/icon-2.svg"
                                                alt="SVG">
                                            <div class="media-body">
                                                <span class="navbar-promo-title">
                                                    Documentation
                                                    <span class="badge badge-primary badge-pill ml-1">v3.0</span>
                                                </span>
                                                <small class="navbar-promo-text">Development guides</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!-- End Promo Item -->

                                <!-- Promo Item -->
                                <div class="navbar-promo-item">
                                    <a class="navbar-promo-link" href="#">
                                        <div class="media align-items-center">
                                            <img class="navbar-promo-icon" src="../../assets/svg/icons/icon-1.svg"
                                                alt="SVG">
                                            <div class="media-body">
                                                <span class="navbar-promo-title">Snippets</span>
                                                <small class="navbar-promo-text">Start building</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!-- End Promo Item -->

                                <div class="navbar-promo-footer">
                                    <!-- List -->
                                    <div class="row no-gutters">
                                        <div class="col-6">
                                            <div class="navbar-promo-footer-item">
                                                <span class="navbar-promo-footer-text">Check what's new</span>
                                                <a class="navbar-promo-footer-text" href="#">
                                                    Changelog
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-6 navbar-promo-footer-ver-divider">
                                            <div class="navbar-promo-footer-item">
                                                <span class="navbar-promo-footer-text">Have a question?</span>
                                                <a class="navbar-promo-footer-text" href="#">
                                                    Contact us
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End List -->
                                </div>
                            </div>
                            <!-- End Docs - Submenu -->
                        </li>
                        <!-- End Docs -->

                        <!-- Button -->
                        <li class="navbar-nav-last-item">
                            <a class="btn btn-sm btn-primary transition-3d-hover"
                                href="https://themes.getbootstrap.com/product/front-multipurpose-responsive-template/"
                                target="_blank">
                                Buy Now
                            </a>
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

<script src="{{ static_asset('vendor/hs-header/dist/hs-header.min.js', false, true) }}"></script>

    {{-- TODO Vukasin: Make this work - need to include hs-header propertly --}}
    {{-- How? :) --}}
    <script>
            // INITIALIZATION OF HEADER
            // =======================================================
            var header = new HSHeader($('#header')).init();
    </script>
@endpush
