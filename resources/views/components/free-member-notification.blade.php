  @php
      $seller_package = null;
  @endphp
  @if ($seller_package === null)

      <div class="alert alert-soft-dark mb-5 mb-lg-7" role="alert">
          <div class="media align-items-center">
              <img class="avatar avatar-xl mr-3"
                  src="https://htmlstream.com/front-dashboard/assets/svg/illustrations/yelling-reverse.svg"
                  alt="Image Description">

              <div class="media-body">
                  <div class="row align-items-center">
                      <div class="col-lg-8">
                          <h3 class="alert-heading mb-1">{{ translate('Verify your profile') }}</h3>
                          <p class="mb-0">
                              {{ translate('Get your Profile Verified') }}
                          </p>

                      </div>
                      <div class="col-lg-4 text-right mt-3">
                          <a href="#"
                              class="text-white d-inline-block btn-login btn btn-success">
                              {{ translate('Verify account') }}
                              <i class="la la-angle-right "></i>
                          </a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  @endif
