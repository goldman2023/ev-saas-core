@extends('frontend.layouts.app')

@section('content')
    <!-- Team Section -->
    <!-- Contact Form Section -->
<div class="container space-2">
  <div class="row">
    <div class="col-lg-6 mb-9 mb-lg-0">
      <div class="mb-5">
        <h1 class="display-4">Get in touch</h1>
        <p>We'd love to talk about how we can help you.</p>
      </div>

      <!-- Leaflet -->
      <div id="mapExample2" class="min-h-300rem mb-5"
           data-hs-leaflet-options='{
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
            }'></div>
      <!-- End Leaflet -->

      <div class="row">
        <div class="col-sm-6">
          <div class="mb-3">
            <span class="d-block h5 mb-1">Call us:</span>
            <span class="d-block text-body font-size-1">+1 (062) 109-9222</span>
          </div>

          <div class="mb-3">
            <span class="d-block h5 mb-1">Email us:</span>
            <span class="d-block text-body font-size-1">hello@example.com</span>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="mb-3">
            <span class="d-block h5 mb-1">Address:</span>
            <span class="d-block text-body font-size-1">153 Williamson Plaza, Maggieberg</span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="ml-lg-5">
        <!-- Form -->
        <form class="js-validate card shadow-lg mb-4">
          <div class="card-header border-0 bg-light text-center py-4 px-4 px-md-6">
            <h2 class="h4 mb-0">General Enquiries</h2>
          </div>

          <div class="card-body p-4 p-md-6">
            <div class="row">
              <div class="col-sm-6">
                <!-- Form Group -->
                <div class="js-form-message form-group">
                  <label for="firstNameExample1" class="input-label">First name</label>
                  <input type="text" class="form-control" name="firstNameExample1" id="firstNameExample1" placeholder="Nataly" aria-label="Nataly" required
                         data-msg="Please enter first your name">
                </div>
                <!-- End Form Group -->
              </div>

              <div class="col-sm-6">
                <!-- Form Group -->
                <div class="js-form-message form-group">
                  <label for="lastNameExample1" class="input-label">Last name</label>
                  <input type="text" class="form-control" name="lastNameExample1" id="lastNameExample1" placeholder="Gaga" aria-label="Gaga" required
                         data-msg="Please enter last your name">
                </div>
                <!-- End Form Group -->
              </div>

              <div class="col-sm-12">
                <!-- Form Group -->
                <div class="js-form-message form-group">
                  <label for="emailAddressExample1" class="input-label">Email address</label>
                  <input type="email" class="form-control" name="emailAddressExample1" id="emailAddressExample1" placeholder="nayagaga@pixeel.com" aria-label="alex@pixeel.com" required
                         data-msg="Please enter a valid email address">
                </div>
                <!-- End Form Group -->
              </div>

              <div class="col-sm-12">
                <!-- Form Group -->
                <div class="js-form-message form-group">
                  <label for="message" class="input-label">Message</label>
                  <div class="input-group">
                    <textarea class="form-control" rows="4" name="message" id="message" placeholder="Hi there, I would like to ..." aria-label="Hi there, I would like to ..." required
                              data-msg="Please enter a reason."></textarea>
                  </div>
                </div>
                <!-- End Form Group -->
              </div>
            </div>

            <button type="submit" class="btn btn-block btn-primary transition-3d-hover">Submit</button>
          </div>
        </form>
        <!-- End Form -->

        <div class="text-center">
          <p class="small">We'll get back to you in 1-2 business days.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Contact Form Section -->


    @php
    $button_text = 'Try it out';
    $image_source = 'assets/img/img1.jpg';
    $heading = 'Register to B2BWood';
    $body = "Building brands people can't live without is how our clients grow.";
    @endphp
    <x-promo-banner :heading="$heading" :body="$body" :buttonText="$button_text" :imageSource="$image_source">
    </x-promo-banner>
    <!-- End Team Section -->
@endsection
