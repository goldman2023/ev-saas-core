@extends('frontend.layouts.user_panel')
@section('page_title', translate('Manage Design'))

@section('panel_content')
    <!-- Basic Info-->
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Design Settings')}}</h5>
        </div>
        <div class="card-body">

                <div class="row">
                    <div class="col-lg-5 mb-7 mb-lg-0">
                      <!-- Nav -->
                      <ul class="nav nav-box" role="tablist">
                        <li class="nav-item w-100 mx-0 mb-3">
                          <a class="nav-link p-4 active" id="pills-one-code-features-example3-tab" data-toggle="pill" href="#pills-one-code-features-example3" role="tab" aria-controls="pills-one-code-features-example3" aria-selected="true">
                            <div class="media align-items-center align-items-lg-start">
                              <figure class="w-100 max-w-6rem mt-2 mr-4">
                                <img class="img-fluid" src="/assets/svg/icons/icon-45.svg" alt="SVG">
                              </figure>
                              <div class="media-body">
                                <h4 class="mb-0">Product Page Design</h4>
                                <div class="d-none d-lg-block mt-2">
                                  <p class="text-body mb-0">You can work with your existing website.</p>
                                </div>
                              </div>
                            </div>
                          </a>
                        </li>

                        <li class="nav-item w-100 mx-0 mb-3">
                          <a class="nav-link p-4" id="pills-two-code-features-example3-tab" data-toggle="pill" href="#pills-two-code-features-example3" role="tab" aria-controls="pills-two-code-features-example3" aria-selected="false">
                            <div class="media align-items-center align-items-lg-start">
                              <figure class="w-100 max-w-6rem mt-2 mr-4">
                                <img class="img-fluid" src="/assets/svg/icons/icon-23.svg" alt="SVG">
                              </figure>
                              <div class="media-body">
                                <h4 class="mb-0">Powerful features</h4>
                                <div class="d-none d-lg-block mt-2">
                                  <p class="text-body mb-0">Easily draft, change, customize and launch.</p>
                                </div>
                              </div>
                            </div>
                          </a>
                        </li>

                        <li class="nav-item w-100 mx-0">
                          <a class="nav-link p-4" id="pills-three-code-features-example3-tab" data-toggle="pill" href="#pills-three-code-features-example3" role="tab" aria-controls="pills-three-code-features-example3" aria-selected="false">
                            <div class="media align-items-center align-items-lg-start">
                              <figure class="w-100 max-w-6rem mt-2 mr-4">
                                <img class="img-fluid" src="../assets/svg/icons/icon-44.svg" alt="SVG">
                              </figure>
                              <div class="media-body">
                                <h4 class="mb-0">Advanced HTML/CSS editing</h4>
                                <div class="d-none d-lg-block mt-2">
                                  <p class="text-body mb-0">You can modify any aspect of your website.</p>
                                </div>
                              </div>
                            </div>
                          </a>
                        </li>
                      </ul>
                      <!-- End Nav -->
                    </div>

                    <div class="col-lg-7">
                      <!-- Tab Content -->
                      <div class="tab-content">
                        <div class="tab-pane fade p-4 show active" id="pills-one-code-features-example3" role="tabpanel" aria-labelledby="pills-one-code-features-example3-tab">
                                <x-default.system.theme-select-form />
                        </div>

                        <div class="tab-pane fade p-4" id="pills-two-code-features-example3" role="tabpanel" aria-labelledby="pills-two-code-features-example3-tab">
                          <p>Second tab content...</p>
                        </div>

                        <div class="tab-pane fade p-4" id="pills-three-code-features-example3" role="tabpanel" aria-labelledby="pills-three-code-features-example3-tab">
                          <p>Third tab content...</p>
                        </div>
                      </div>
                      <!-- End Tab Content -->
                    </div>
                  </div>

                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Update Settings')}}</button>
                </div>
        </div>
    </div>
@endsection

