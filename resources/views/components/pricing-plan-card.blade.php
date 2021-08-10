  {{-- @if ($plan->name === '') --}}

  <div class="col mb-3">
      @if ($plan->name === 'Basic')
          <span class="position-absolute text-nowrap mt-n5 ml-3 ml-md-7" style="left: 20%; top: 0;">
              <svg class="d-block position-absolute mt-n2 ml-n4" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                  viewBox="0 0 99.3 57" width="48">
                  <path fill="none" stroke="#bdc5d1" stroke-width="4" stroke-linecap="round" stroke-miterlimit="10"
                      d="M2,39.5l7.7,14.8c0.4,0.7,1.3,0.9,2,0.4L27.9,42"></path>
                  <path fill="none" stroke="#bdc5d1" stroke-width="4" stroke-linecap="round" stroke-miterlimit="10"
                      d="M11,54.3c0,0,10.3-65.2,86.3-50"></path>
              </svg>
              <span class="badge badge-primary badge-pill  h-auto w-auto py-sm-2 px-sm-3">
                  {{ translate('Most Popular!') }}
              </span>
          </span>
      @endif
      <div class="card h-100 overflow-hidden mb-3 position-relative">

          <div class="card-header text-center">

              <span class="d-block h3">{{ $plan->name }}</span>
              <span class="d-block">

                  @if ($plan->amount == 0)
                      <span class="display-4">{{ translate('Free') }}</span>
                      <br>
                      <span class="text-white">Free</span>
                  @else
                      <div>
                          <div>
                              <span class="d-block">
                                  <span class="text-primary align-top">$</span>
                                  <span class="display-4 text-primary font-weight-bold">
                                      <span id="pricingCount2Example2">
                                          {{ $plan->amount }}
                                      </span>
                                  </span>
                                  <span class="font-size-1 text-primary">
                                      {{ translate('/ year') }}
                                  </span>
                              </span>
                          </div>
                          <div>
                              <del class="text-danger">
                                  <span class="d-block">
                                      <span class="text-danger align-top">$</span>
                                      <span class="font-size-4 text-danger font-weight-bold">
                                          <span id="pricingCount2Example2">
                                              {{ $plan->amount * 2 }}
                                          </span>
                                      </span>
                                      <span class="font-size-1">{{ translate('/ year') }}</span>
                                  </span>
                              </del>
                          </div>
                      </div>
                  @endif
              </span>
          </div>
          <div class="card-body">
              <ul class="list-group list-group-raw fs-15 mb-5">
                  @php
                      $planItems = get_pricing_plans_array();
                  @endphp
                  @foreach ($planItems[$key] as $item)
                      <li class="list-group-item py-2">
                          @if ($item['included'])
                              <i class="las la-check text-success mr-2"></i>
                          @else
                              <i class="las la-times text-danger mr-2"></i>
                          @endif
                          {{ translate($item['label']) }}
                      </li>
                  @endforeach


              </ul>

              <div class="text-center">
                  @if ($plan->amount == 0)
                      <button class="btn btn-soft-secondary btn-block transition-3d-hover"
                          onclick="get_free_package({{ $plan->id }})">{{ translate('Get Started For Free') }}</button>
                  @else
                      @if (\App\Models\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Models\Addon::where('unique_identifier', 'offline_payment')->first()->activated)
                          <button class="btn btn-soft-secondary btn-block transition-3d-hover"
                              onclick="select_payment_type({{ $plan->id }})">{{ translate('Become a member') }}</button>
                      @else
                          <button class="btn btn-soft-secondary btn-block transition-3d-hover"
                              onclick="show_price_modal({{ $plan->id }})">{{ translate('Become a member') }}</button>
                      @endif
                  @endif


              </div>
          </div>
      </div>
  </div>
