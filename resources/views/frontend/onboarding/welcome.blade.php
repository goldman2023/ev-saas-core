@extends('frontend.layouts.app')

@section('content')

<section>
    <!-- Features Section -->
<div class="container space-2">
    <div class="row justify-content-lg-between align-items-lg-center">
      <div class="col-lg-5 mb-9 mb-lg-0">
        <div class="mb-5">
          <h2>
              {{ translate('Welcome to your new digital home!') }}
          </h2>
          <p>
            {{ translate('We are happy that you decided to give our platform a try. Complete the wizard with information to launch your site!') }}
            </p>

            {{-- TODO: add onboarding wizard for entering all the necessary data@production
                Step 1: Logo and Colors + name
                Step 2: Contact information
                Step 3: Menu pages selector (Predefined options: contacts/about-us/brands/services/team)

             --}}
            <a class="btn btn-primary">
                {{ translate('Get Started') }}
            </a>
        </div>

        <div class="w-md-50 w-lg-80 mb-2">
          <!-- Fancybox -->
          <div class="bg-img-hero text-center rounded py-11 px-5" style="background-image: url(../assets/img/480x320/img18.jpg);">
            <a class="js-fancybox video-player video-player-btn d-flex justify-content-center align-items-center" href="javascript:;"
               data-hs-fancybox-options='{
                 "src": "//vimeo.com/167434033",
                 "caption": "Front - Responsive Website Template",
                 "speed": 700,
                 "buttons": ["fullScreen", "close"],
                 "vimeo": {
                   "autoplay": 1
                 }
               }'>
              <span class="video-player-icon">
                <i class="fas fa-play"></i>
              </span>
            </a>
          </div>
          <!-- End Fancybox -->
        </div>

        <p class="small">{{ translate('Explore EV-SaaS educational videos')  }}</p>
      </div>

      <div class="col-lg-6">
        <div class="position-relative max-w-50rem mx-auto">
          <!-- Device Mockup -->
          <div class="device device-iphone-x w-75 mx-auto">
            <img class="device-iphone-x-frame" src="https://htmlstream.com/front/assets/svg/components/iphone-x.svg" alt="Image Description">
            <img class="device-iphone-x-screen" src="https://i.pinimg.com/originals/8a/d4/80/8ad480ea557c6029ec04077a159e81e1.png" alt="Image Description">
          </div>
          <!-- End Device Mockup -->

          <!-- SVG Component -->
          <div class="position-absolute bottom-0 right-0 max-w-50rem w-100 z-index-n1 mx-auto">
            <img class="img-fluid" src="https://htmlstream.com/front/assets/svg/components/abstract-shapes-2.svg" alt="Image Description">
          </div>
          <!-- End SVG Component -->
        </div>
      </div>
    </div>
  </div>
  <!-- End Features Section -->
</section>

<section>
    <x-default.forms.contact-form></x-default.forms.contact-form>
</section>
{{-- TODO: Refactor this to blade components --}}
{{-- @include('frontend.components.news') --}}
@endsection

@section('script')

@endsection
