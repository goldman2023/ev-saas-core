<!-- ========== FOOTER ========== -->
<footer class="bg-dark">
    <div class="container space-2">
      <div class="row mb-9">
        <div class="col-lg-3 mb-5 mb-lg-0">
          <!-- Logo -->
          <a href="#" aria-label="Front">
            <img src="{{ $logo }}" alt="Logo">
          </a>
          <!-- End Logo -->
        </div>

        <div class="col-6 col-md-3 col-lg-2 mb-5 mb-lg-0">
          <h5 class="text-white font-weight-bold">
            {{ translate('Products Catalog') }}
          </h5>
         
        </div>

        <div class="col-6 col-md-3 col-lg-2 mb-5 mb-lg-0">
          <h5 class="text-white font-weight-bold"> 
            {{ translate('Gun Range') }}
          </h5>

          <h5 class="text-white font-weight-bold"> 
            {{ translate('Contact us') }}
          </h5>

          <h5 class="text-white font-weight-bold"> 
            {{ translate('Shipping') }}
          </h5>

          <h5 class="text-white font-weight-bold"> 
            {{ translate('About us') }}
          </h5>
          
        </div>

        <div class="col-md-6 col-lg-5">
          <!-- Form -->
          <form class="js-validate mb-2">
            <h5 class="text-white font-weight-bold mb-3">Stay up to date</h5>
            <div class="form-row">
              <div class="col">
                <div class="js-form-message">
                  <label class="sr-only" for="subscribeSrEmail">Email address</label>
                  <div class="input-group">
                    <input type="email" class="form-control" name="email" id="subscribeSrEmail" placeholder="Email address" aria-label="Email address" required
                           data-msg="Please enter a valid email address.">
                  </div>
                </div>
              </div>

              <div class="col-auto">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-arrow-right"></i>
                </button>
              </div>
            </div>
          </form>
          <!-- End Form -->

          <p class="text-white-70 small mb-0">New UI kits or big discounts. Never spam.</p>
        </div>
      </div>

      <!-- Copyright -->
      <div class="row align-items-md-center">
        <div class="col-md-6 mb-4 mb-md-0">
          <p class="small text-white-70 mb-0">
            {{ translate('Powered by: ') }} {{ get_setting('website_name') }}
            {{ translate('© Copyright.') }} {{ date('Y')}}.</p>
        </div>

        <div class="col-md-6 text-md-right">
          <!-- Social Networks -->
          <ul class="list-inline mb-0">
            <li class="list-inline-item mb-2 mb-sm-0">
              <a class="btn btn-xs btn-icon btn-ghost-light" href="#">
                <i class="fab fa-facebook-f"></i>
              </a>
            </li>
            <li class="list-inline-item mb-2 mb-sm-0">
              <a class="btn btn-xs btn-icon btn-ghost-light" href="#">
                <i class="fab fa-google"></i>
              </a>
            </li>
            <li class="list-inline-item mb-2 mb-sm-0">
              <a class="btn btn-xs btn-icon btn-ghost-light" href="#">
                <i class="fab fa-twitter"></i>
              </a>
            </li>
            <li class="list-inline-item mb-2 mb-sm-0">
              <a class="btn btn-xs btn-icon btn-ghost-light" href="#">
                <i class="fab fa-github"></i>
              </a>
            </li>
            <li class="list-inline-item mb-2 mb-sm-0">
              <a class="btn btn-xs btn-icon btn-ghost-light" href="#">
                <i class="fab fa-linkedin"></i>
              </a>
            </li>
          </ul>
          <!-- End Social Networks -->
        </div>
      </div>
      <!-- End Copyright -->
    </div>
  </footer>
  <!-- ========== END FOOTER ========== -->
