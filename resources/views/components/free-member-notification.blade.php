  @php
      $seller_package = \App\Models\SellerPackage::find(auth()->user()->seller->seller_package_id);
  @endphp
  @if ($seller_package === null || $seller_package->name === 'Prospect')

      <div class="alert alert-soft-dark mb-5 mb-lg-7" role="alert">
          <div class="media align-items-center">
              <img class="avatar avatar-xl mr-3"
                  src="https://htmlstream.com/front-dashboard/assets/svg/illustrations/yelling-reverse.svg"
                  alt="Image Description">

              <div class="media-body">
                  <div class="row align-items-center">
                      <div class="col-lg-8">
                          <h3 class="alert-heading mb-1">{{ translate('Get your company Profile Verified') }}</h3>
                          <p class="mb-0">
                              {{ translate('Get your company credit report and show that your company is trusted market player') }}
                          </p>

                      </div>
                      <div class="col-lg-4 text-right mt-3">
                          <a href="{{ route('seller_packages_list') }}"
                              class="text-white d-inline-block btn-login btn btn-success">
                              {{ translate('Become a Club Member') }}
                              <i class="la la-angle-right "></i>
                          </a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  @endif
