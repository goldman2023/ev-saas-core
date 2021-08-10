@extends('frontend.layouts.app')

@section('content')


    <section id="homepage-stats">
        <x-homepage-stats></x-homepage-stats>
    </section>


    <section id="b2b-new-companies">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <x-b2b-new-companies></x-b2b-new-companies>
                </div>
            </div>
        </div>
    </section>


    @guest
        <section id="become-a-member" class="space-2">
            @php
                $button_text = 'Add Your Company For Free';
                $image_source = 'assets/img/img1.jpg';
                $heading = 'Become a B2BWood Club Member';
                $body = 'Present your business online with beautifull company profile and stay on top of global wood industry trends with B2BWood Club Membership';
            @endphp
            <x-promo-banner :heading="$heading" :body="$body" :buttonText="$button_text" :imageSource="$image_source">
            </x-promo-banner>
        </section>

    @endguest

    {{-- Banner section 1 --}}
    @if (get_setting('home_banner1_images') != null)
        <div class="mb-4">
            <div class="container">
                <div class="row gutters-10">
                    @php $banner_1_imags = json_decode(get_setting('home_banner1_images')); @endphp
                    @foreach ($banner_1_imags as $key => $value)
                        <div class="col-xl col-md-6">
                            <div class="mb-3 mb-lg-0">
                                <a href="{{ json_decode(get_setting('home_banner1_links'), true)[$key] }}"
                                   class="d-block text-reset">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                         data-src="{{ uploaded_asset($banner_1_imags[$key]) }}"
                                         alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- <x-affiliate-banner></x-affiliate-banner> --}}

    {{-- @include('frontend.components.benefits') --}}

    {{-- @include('frontend.components.news') --}}


    {{-- Banner Section 2 --}}
    @if (get_setting('home_banner2_images') != null)
        <div class="mb-4">
            <div class="container">
                <div class="row gutters-10">
                    @php $banner_2_imags = json_decode(get_setting('home_banner2_images')); @endphp
                    @foreach ($banner_2_imags as $key => $value)
                        <div class="col-xl col-md-6">
                            <div class="mb-3 mb-lg-0">
                                <a href="{{ json_decode(get_setting('home_banner2_links'), true)[$key] }}"
                                   class="d-block text-reset">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                         data-src="{{ uploaded_asset($banner_2_imags[$key]) }}"
                                         alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Category wise Products --}}
    <div id="section_home_categories">

    </div>


    {{-- Banner Section 2 --}}
    @if (get_setting('home_banner3_images') != null)
        <div class="mb-4">
            <div class="container">
                <div class="row gutters-10">
                    @php $banner_3_imags = json_decode(get_setting('home_banner3_images')); @endphp
                    @foreach ($banner_3_imags as $key => $value)
                        <div class="col-xl col-md-6">
                            <div class="mb-3 mb-lg-0">
                                <a href="{{ json_decode(get_setting('home_banner3_links'), true)[$key] }}"
                                   class="d-block text-reset">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                         data-src="{{ uploaded_asset($banner_3_imags[$key]) }}"
                                         alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif




@endsection

@section('script')
    <script>

    </script>
@endsection
