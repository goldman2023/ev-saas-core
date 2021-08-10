@extends('frontend.layouts.app')

@section('content')
    <!-- Team Section -->
    <!-- Hero Section -->
    <div class="container space-2">
        <div class="row">
            <div class="col-lg-5 mb-7 mb-lg-0">
                <div class="pr-lg-4">
                    <div class="position-relative">
                        <!-- Main Slider -->
                        <div id="heroSlider" class="js-slick-carousel slick border rounded-lg">
                            <div class="js-slide">
                                {{-- TODO: Move this image as an asset--}}
                                <img class="img-fluid w-100 rounded-lg"
                                     src="https://img.freepik.com/free-psd/annual-report-mockup-with-wavy-shapes_1389-413.jpg?size=338&ext=jpg&ga=GA1.2.473829469.1610064000"
                                     alt="Image Description">
                            </div>

                        </div>
                        <!-- End Main Slider -->


                    </div>
                </div>
            </div>

            <!-- Product Description -->
            <div class="col-lg-5">


                <!-- Title -->
                <div class="mb-5">
                    <h1 class="h2">{{ translate('Request Credit Report about: ') }}</h1>
                    <p>{{ translate('Provide your details and we will contact you with available options about your selected company')  }}</p>
                </div>
                <!-- End Title -->

                <!-- Price -->
                <div class="mb-5">
                    <h2 class="font-size-1 text-body mb-0">{{ translate('Price') }}:</h2>
                    <span class="text-dark display-4 font-weight-bold">80.00€</span>
                </div>
                <!-- End Price -->


                <!-- Accordion -->
                <div id="shopCartAccordionExample2" class="accordion mb-5">
                    <!-- Card -->
                    <div class="card card-bordered shadow-none">

                        <div class="card-body">
                            @guest

                                <span>{{ translate('To request data about this company please register on B2BWood') }}</span>

                            <div class="mt-3">
                                <x-join-button></x-join-button>
                                <span class="text-primary pl-3">{{ translate("It's free to join!")  }}</span>
                            </div>
                            @else
                                <div class="mb-4">
                                    <button type="button" class="btn btn-block btn-primary btn-pill transition-3d-hover">
                                        {{ translate('Send Request') }}
                                    </button>
                                </div>
                            @endguest
                        </div>


                    </div>
                    <!-- End Card -->


                </div>
                <!-- End Accordion -->



                <!-- Help Link -->
                <div class="media align-items-center">

                    <div class="media-body text-body small">
                        <span class="font-weight-bold mr-1">{{ translate('We will contact you in 24hours') }}</span>
                    </div>
                </div>
                <!-- End Help Link -->
            </div>
            <!-- End Product Description -->
        </div>
    </div>
    <!-- End Hero Section -->


    @php
        $button_text = 'Try it out';
        $image_source = 'assets/img/img1.jpg';
        $heading = 'Register to B2BWood';
        $body = "Present your business online with beautifull company profile and stay on top of global wood industry trends with B2BWood Club Membership.";
    @endphp
    {{--    <x-promo-banner :heading="$heading" :body="$body" :buttonText="$button_text" :imageSource="$image_source">--}}
    {{--    </x-promo-banner>--}}
    <!-- End Team Section -->
@endsection



