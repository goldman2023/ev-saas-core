<!-- Hero Section -->
<div class="d-lg-flex">
    <div class="container d-lg-flex align-items-lg-center vh-lg-100 space-bottom-1 space-top-3 space-bottom-lg-3 space-lg-0">
      <div class="row justify-content-lg-between align-items-lg-center w-100 mt-lg-9">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <img class="img-fluid" src="../assets/svg/illustrations/relaxing-man.svg" alt="SVG Illustration">
        </div>

        <div class="col-lg-5">
          <!-- Title -->
          <div class="mb-4">
            <h1>We're coming soon.</h1>
            <p>Our website is under construction. We'll be here soon with our new awesome site, subscribe to be notified.</p>
          </div>
          <!-- End Title -->

          <!-- Countdown -->
          <div class="js-countdown row mb-5"
               data-hs-countdown-options='{
                 "endDate": "2023/11/30"
               }'>
            <div class="col-3">
              <span class="js-cd-days font-size-3 text-primary font-weight-bold mb-0"></span>
              <span class="h5 d-block mb-0">Days</span>
            </div>
            <div class="col-3">
              <span class="js-cd-hours font-size-3 text-primary font-weight-bold mb-0"></span>
              <span class="h5 d-block mb-0">Hours</span>
            </div>
            <div class="col-3">
              <span class="js-cd-minutes font-size-3 text-primary font-weight-bold mb-0"></span>
              <span class="h5 d-block mb-0">Mins</span>
            </div>
            <div class="col-3">
              <span class="js-cd-seconds font-size-3 text-primary font-weight-bold mb-0"></span>
              <span class="h5 d-block mb-0">Secs</span>
            </div>
          </div>
          <!-- End Countdown -->

          <!-- Input -->
          <form class="js-validate js-form-message">
            <label class="sr-only" for="subscribeSrEmail">Your email</label>
            <div class="input-group">
              <input type="text" class="form-control" name="name" id="subscribeSrEmail" placeholder="Your email" aria-label="Your email" aria-describedby="subscribeEmailButton" required
                     data-msg="Please enter a valid email address.">
              <div class="input-group-append">
                <button type="submit" class="btn btn-primary" id="subscribeEmailButton">Subscribe</button>
              </div>
            </div>
          </form>
          <!-- End Input -->
        </div>
      </div>
    </div>
  </div>
  <!-- End Hero Section -->

  @push('footer_scripts')

  <script>
    $(document).on('ready', function () {
      // INITIALIZATION OF FORM VALIDATION
      // =======================================================


      // INITIALIZATION OF COUNTDOWNS
      // =======================================================
      $('.js-countdown').each(function () {
        var countdown = $.HSCore.components.HSCountdown.init($(this));
      });
    });
  </script>
  @endpush
