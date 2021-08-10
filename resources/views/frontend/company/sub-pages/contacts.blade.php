@extends('frontend.layouts.company-profile-layout')

@section('company_profile')



    <x-company-tabs :seller="$seller" type="contacts"></x-company-tabs>
    @php
    $reviews = false;
    @endphp
    <!-- Review Section -->
    <div class="container">
        <!-- Contact Form Section -->
        <div class="row">
            <div class="col-lg-6 mb-9 mb-lg-0">
                <div class="mb-5">
                    <h1 class="display-4">{{ translate('Contacts: ') }} {{ $seller->user->shop->name }} </h1>
                    <p>{{ translate('Fill out this form and get in touch with') }} {{ $seller->user->shop->name }}</p>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <span class="d-block h5 mb-1">{{ translate('Company Phone') }}</span>
                            <span
                                class="d-block text-body font-size-1">{{ $seller->get_attribute_value_by_id(38) }}</span>
                        </div>

                        <div class="mb-3">
                            <span class="d-block h5 mb-1">{{ translate('Contact Email') }}</span>
                            <span
                                class="d-block text-body font-size-1">{{ $seller->get_attribute_value_by_id(39) }}</span>
                        </div>

                        <div class="mb-3 text-left">
                            <span class="d-block h5 mb-1">{{ translate('Social Media') }}</span>

                            <x-company-social-links align="left" :company="$seller->user->shop"> </x-company-social-links>

                        </div>


                    </div>

                    <div class="col-sm-6">
                        <div class="mb-3">
                            <span class="d-block h5 mb-1">
                                {{ translate('Address') }}
                            </span>
                            <span
                                class="d-block text-body font-size-1">{{ $seller->get_attribute_value_by_id(38) }}</span>
                        </div>

                        <div class="mb-3 text-left">
                            <span class="d-block h5 mb-1">{{ translate('Website') }}</span>
                            {{-- TODO: add dynamic page url --}}
                            <x-company-website-link :company="$seller->user->shop"> </x-company-website-link>


                        </div>
                    </div>
                </div>
                <!-- Leaflet -->
                <div id="mapExample2" class="min-h-300rem mb-5 d-none" data-hs-leaflet-options='{
                                             "map": {
                                               "scrollWheelZoom": false,
                                               "coords": [37.4040344, -122.0289704]
                                             },
                                             "marker": [
                                               {
                                                 "coords": [37.4040344, -122.0289704],
                                                 "icon": {
                                                   "iconUrl": "../assets/svg/components/map-pin.svg",
                                                   "iconSize": [50, 45]
                                                 },
                                                 "popup": {
                                                   "text": "Test text!"
                                                 }
                                               }
                                             ]
                                            }'>
                    {{-- <iframe style="width: 100%; min-height: 400px;" frameborder="0"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4587.523005935945!2d23.974581304245078!3d54.907108168733934!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46e71866041643c3%3A0x46ea40a86e490200!2sKovo+11-osios+g.+26%2C+Kaunas+51323!5e0!3m2!1slt!2slt!4v1431947536935"
                        style="border:0"></iframe> --}}
                </div>
                <!-- End Leaflet -->


            </div>

            <div class="col-lg-6">
                <div class="ml-lg-5">
                    <!-- Form -->
                    <div class="js-validate card shadow-lg mb-4">
                        <div class="card-header border-0 bg-light text-center py-4 px-4 px-md-6">
                            <h2 class="h4 mb-0">{{ translate('General inquiries') }}</h2>
                        </div>

                        <div class="card-body p-4 p-md-2" style="position: relative;">
                            @guest
                                <x-card-overlay :extraButtonsEnabled="false"
                                    text="{{ translate('Please Join B2BWood To Contact this company') }}"></x-card-overlay>
                            @endguest
                            <x-company-contact-form :seller="$seller"> </x-company-contact-form>

                        </div>
                    </div>
                    <!-- End Form -->

                    <div class="text-center">
                        <p class="small">{{ translate("We'll get back to you in 1-2 business days.") }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contact Form Section -->
    </div>
    <!-- End Review Section -->
    </div>

@endsection
