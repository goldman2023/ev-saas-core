@extends('frontend.layouts.app')

@section('content')
    <main id="content" role="main">
        <div id="hero-form">
            @include('frontend.landings.sections.hero-signup')

        </div>
        @include('frontend.landings.sections.benefits')




        <!-- CTA Section -->
        <div class="container">
            <div class="bg-light rounded-lg overflow-hidden space-top-2 space-top-lg-1 pl-5 pl-md-8">
                <div class="row justify-content-lg-between align-items-lg-center no-gutters">
                    <div class="col-lg-4">
                        <div class="mb-4">
                            <h2>Present your company online with amazing profile</h2>

                            <ul class="list-checked list-checked-sm list-checked-success text-white">
                                <li class="list-checked-item">Add your logo and comapny details</li>
                                <li class="list-checked-item">You get your personal blog</li>
                                <li class="list-checked-item">You can inform the market about your achievements and changes</li>
                            </ul>
                        </div>
                        <a class="btn btn-success btn-wide transition-3d-hover text-white"
                           href="https://themes.getbootstrap.com/product/front-multipurpose-responsive-template/">
                            Get Started
                            <i class="fas fa-angle-right fa-sm ml-1"></i>
                        </a>
                    </div>

                    <div class="col-lg-7 space-top-1 space-top-sm-2 ml-auto">
                        <div data-aos="fade-up" class="aos-init aos-animate">
                            <img class="img-fluid shadow-lg" src="{{ static_asset('assets/img/promo/company-profile-demo.jpg') }}"
                                 alt="Image Description">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End CTA Section -->

        <!-- Learn Section -->
        <div id="learnSection" class="container space-2 space-lg-3 active">
            <!-- Title -->
            <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
                <h2 class="h1">How To Join B2BWood?</h2>
                <p class="d-none">B2BWood is an incredibly beautiful, fully responsive, and mobile-first projects on the web – it is the
                    starting point for creative sites.</p>
            </div>
            <!-- End Title -->

            <div class="w-lg-75 mx-md-auto">
                <!-- Step -->
                <ul class="step step-md step-centered mb-md-9">
                    <li class="step-item">
                        <div class="step-content-wrapper">
                            <span class="step-icon step-icon-sm step-icon-soft-primary">1</span>
                            <div class="step-content">
                                <h5>Fill in info briefly</h5>
                            </div>
                        </div>
                    </li>

                    <li class="step-item">
                        <div class="step-content-wrapper">
                            <span class="step-icon step-icon-sm step-icon-soft-primary">2</span>
                            <div class="step-content">
                                <h5>Activate your profile</h5>
                            </div>
                        </div>
                    </li>

                    <li class="step-item">
                        <div class="step-content-wrapper">
                            <span class="step-icon step-icon-sm step-icon-soft-primary ">3</span>
                            <div class="step-content">
                                <h5>Improve your profile up to 5 star</h5>
                            </div>
                        </div>
                    </li>

                    <li class="step-item">
                        <div class="step-content-wrapper">
                            <span class="step-icon step-icon-sm step-icon-soft-primary">4</span>
                            <div class="step-content">
                                <h5>Do browse and learn more about the others</h5>
                            </div>
                        </div>
                    </li>
                </ul>
                <!-- End Step -->

                <!-- Video Block -->
                <div id="youTubeVideoPlayer" class="video-player rounded-lg d-none" style="background-color: #000;">
                    <img class="img-fluid video-player-preview rounded-lg" src="https://htmlstream.com/front/assets/img/1920x800/img6.jpg"
                         alt="Image">





                </div>
                <!-- End Video Block -->
            </div>
        </div>
        <!-- End Learn Section -->

        <!-- Testimonials Section -->
        @include('frontend.landings.sections.testimonials')

        <!-- End Testimonials Section -->

        <!-- Clients Section -->

        <!-- Pricing Section -->
        <div id="pricingSection" class="container space-2 space-lg-3">
            <!-- Title -->
            <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
                <h2 class="h1">Pricing</h2>
                <p>No additional costs. Pay for what you use.</p>
            </div>
            <!-- End Title -->

            <div class="row align-items-lg-center">
                <div id="stickyBlockStartPoint" class="col-lg-5 mb-9 mb-lg-0">
                    <!-- Pricing -->
                    <div class="card z-index-2 p-4 p-md-7 aos-init aos-animate" data-aos="fade-up">
            <span class="text-dark">
              <span class="font-size-2">from</span>
              <span class="display-4">$99</span>
              <span class="font-size-2">/ mo</span>
            </span>

                        <hr class="my-4">

                        <div class="mb-5">
                            <p>Start your Front business now. 100% guaranteed money back. No questions asked.</p>
                        </div>

                        <div class="mb-2">
                            <a class="btn btn-success text-white btn-wide transition-3d-hover"
                               href="https://themes.getbootstrap.com/product/front-multipurpose-responsive-template/">
                                Get Started <i class="fas fa-angle-right fa-sm ml-1"></i>
                            </a>

                            <a class="btn btn-primary text-white btn-wide transition-3d-hover"
                               href="https://themes.getbootstrap.com/product/front-multipurpose-responsive-template/">
                                See Pricing Plans <i class="fas fa-angle-right fa-sm ml-1"></i>
                            </a>
                        </div>

                        <p class="small">No credit card required.</p>
                    </div>
                    <!-- End Pricing -->
                </div>

                <div class="col-lg-7">
                    <div class="pl-lg-6">
                        <div class="row">
                            <div class="col-sm-6 mb-3 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                                <!-- Icon Blocks -->
                                <figure class="w-100 max-w-6rem mb-3">
                                    <img class="img-fluid" src="https://htmlstream.com/front/assets/svg/icons/icon-29.svg" alt="SVG">
                                </figure>
                                <h4>Hundreds of companies</h4>
                                <p>Achieve maximum productivity with minimum effort with Front and create robust
                                    limitless products.</p>
                                <!-- End Icon Blocks -->
                            </div>
                            <div class="col-sm-6 mb-3 aos-init aos-animate" data-aos="fade-up" data-aos-delay="150">
                                <!-- Icon Blocks -->
                                <figure class="w-100 max-w-6rem mb-3">
                                    <img class="img-fluid" src="https://htmlstream.com/front/assets/svg/icons/icon-30.svg" alt="SVG">
                                </figure>
                                <h4>Company Profile</h4>
                                <p>We made custom license for all our premium images in the Front.</p>
                                <!-- End Icon Blocks -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 mb-3 mb-sm-0 aos-init aos-animate" data-aos="fade-up"
                                 data-aos-delay="200">
                                <!-- Icon Blocks -->
                                <figure class="w-100 max-w-6rem mb-3">
                                    <img class="img-fluid" src="https://htmlstream.com/front/assets/svg/icons/icon-32.svg" alt="SVG">
                                </figure>
                                <h4>Cancel anytime</h4>
                                <p>If its not for you, just cancel, no hidden costs or fees.</p>
                                <!-- End Icon Blocks -->
                            </div>
                            <div class="col-sm-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="250">
                                <!-- Icon Blocks -->
                                <figure class="w-100 max-w-6rem mb-3">
                                    <img class="img-fluid" src="https://htmlstream.com/front/assets/svg/icons/icon-31.svg" alt="SVG">
                                </figure>
                                <h4>Money back</h4>
                                <p>100% guaranteed money back. No questions asked.</p>
                                <!-- End Icon Blocks -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Pricing Section -->

        <div id="footer-form">
            @include('frontend.landings.sections.hero-signup')
        </div>

    </main>
    <style>
        .front-header-search {
            opacity: 0 !important;
        }

        #b2b-main-menu {
            display: none !important;
        }

        #b2b-bottom-links {
            display: none !important;
        }

        .footer-widget {
            display: none !important;
        }

        #category-menu-icon {
            display: none !important;
        }
    </style>
@endsection
