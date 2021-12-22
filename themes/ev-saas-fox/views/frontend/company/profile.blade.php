@extends('frontend.layouts.'.$globalLayout)

@section('content')
<div class="container space-top-1 space-top-sm-2 space-bottom-2">
    <div class="row">
        <div id="stickyBlockStartPoint" class="col-md-5 col-lg-4 mb-7 mb-md-0">
            <div class="js-sticky-block card border p-4" data-hs-sticky-block-options="{
               &quot;parentSelector&quot;: &quot;#stickyBlockStartPoint&quot;,
               &quot;breakpoint&quot;: &quot;md&quot;,
               &quot;startPoint&quot;: &quot;#stickyBlockStartPoint&quot;,
               &quot;endPoint&quot;: &quot;#stickyBlockEndPoint&quot;,
               &quot;stickyOffsetTop&quot;: 12,
               &quot;stickyOffsetBottom&quot;: 12
             }">
                <div class="text-center">
                    <!-- User Content -->
                    <img class="img-fluid rounded-circle mx-auto" src="{{ $shop->get_company_logo() }}"
                        alt="{{ $shop->name }}" width="120" height="120">

                    <span class="d-block text-body font-size-1 mt-3">{{ translate('Joined in') }} {{
                        $shop->created_at->format("Y") }}</span>
                    {{-- TODO: Change this to active_at --}}
                    <span class="d-block text-body font-size-1 mt-3">{{ translate('Last active') }} {{
                        $shop->created_at->diffForHumans() }}</span>

                    <div class="mt-3">
                        <a class="btn btn-sm btn-outline-primary transition-3d-hover" href="#">
                            @svg('heroicon-o-chat', ['class' => 'd-block d-sm-inline-block mb-sm-0 mr-1', 'style' =>
                            'width: 16px;'])

                            {{ translate('Send Message') }}
                        </a>

                        <a class="btn btn-sm btn-outline-primary transition-3d-hover" href="#">
                            @svg('heroicon-o-heart', ['class' => 'd-block d-sm-inline-block mb-sm-0 mr-1', 'style' =>
                            'width: 16px;'])

                            {{ translate('Follow') }}
                        </a>
                    </div>
                    <!-- End User Content -->
                </div>

                <div class="border-top pt-4 mt-4">
                    <div class="row">
                        <div class="col-6 col-md-12 col-lg-6 mb-4">
                            <!-- Icon Block -->
                            <div class="media">
                                <div class="d-flex">
                                    <span class="avatar avatar-xs mr-3">
                                        <img class="avatar-img"
                                            src="https://htmlstream.com/preview/front-v3.1.1/assets/svg/illustrations/review-rating-shield.svg"
                                            alt="Image Description">
                                    </span>
                                    <span class="text-body font-size-1 mt-1">533 Reviews</span>
                                </div>
                            </div>
                            <!-- End Icon Block -->
                        </div>

                        <div class="col-6 col-md-12 col-lg-6 mb-4">
                            <!-- Icon Block -->
                            <div class="d-flex">
                                <span class="avatar avatar-xs mr-3">
                                    <img class="avatar-img"
                                        src="https://htmlstream.com/preview/front-v3.1.1/assets/svg/illustrations/star.svg"
                                        alt="Image Description">
                                </span>
                                <span class="text-body font-size-1 mt-1">4.87 rating</span>
                            </div>
                            <!-- End Icon Block -->
                        </div>

                        <div class="col-6 col-md-12 col-lg-6 mb-4 col-6 col-md-12 mb-lg-0">
                            <!-- Icon Block -->
                            <div class="d-flex">
                                <span class="avatar avatar-xs mr-3">
                                    <img class="avatar-img"
                                        src="https://htmlstream.com/preview/front-v3.1.1/assets/svg/illustrations/medal.svg"
                                        alt="Image Description">
                                </span>
                                <span class="text-body font-size-1 mt-1">Top teacher</span>
                            </div>
                            <!-- End Icon Block -->
                        </div>

                        <div class="col-6 col-md-12 col-lg-6">
                            <!-- Icon Block -->
                            <div class="d-flex">
                                <span class="avatar avatar-xs mr-3">
                                    <img class="avatar-img"
                                        src="https://htmlstream.com/preview/front-v3.1.1/assets/svg/illustrations/add-file.svg"
                                        alt="Image Description">
                                </span>
                                <span class="text-body font-size-1 mt-1">29 courses</span>
                            </div>
                            <!-- End Icon Block -->
                        </div>
                    </div>
                </div>

                <div class="border-top pt-4 mt-4">
                    <h1 class="h4 mb-4">{{ translate('Connected accounts') }}</h1>

                    <div class="row">
                        <div class="col-6 col-md-12 col-lg-6 mb-4">
                            <!-- Social Profiles -->
                            <a class="media" href="#">
                                <div class="icon icon-xs icon-soft-secondary mr-3">
                                    <i class="fab fa-github"></i>
                                </div>
                                <div class="media-body">
                                    <span class="d-block font-size-1 font-weight-bold">Behance</span>
                                    <small class="d-block text-body">1.2k followers</small>
                                </div>
                            </a>
                            <!-- End Social Profiles -->
                        </div>

                        <div class="col-6 col-md-12 col-lg-6 mb-4">
                            <!-- Social Profiles -->
                            <a class="media" href="#">
                                <div class="icon icon-xs icon-soft-secondary mr-3">
                                    <i class="fab fa-slack"></i>
                                </div>
                                <div class="media-body">
                                    <span class="d-block font-size-1 font-weight-bold">Slack</span>
                                    <small class="d-block text-body">4.5k followers</small>
                                </div>
                            </a>
                            <!-- End Social Profiles -->
                        </div>

                        <div class="col-6 col-md-12 col-lg-6 mb-0 mb-md-4 mb-lg-0">
                            <!-- Social Profiles -->
                            <a class="media" href="#">
                                <div class="icon icon-xs icon-soft-secondary mr-3">
                                    <i class="fab fa-twitter"></i>
                                </div>
                                <div class="media-body">
                                    <span class="d-block font-size-1 font-weight-bold">Twitter</span>
                                    <small class="d-block text-body">2.7k followers</small>
                                </div>
                            </a>
                            <!-- End Social Profiles -->
                        </div>

                        <div class="col-6 col-md-12 col-lg-6">
                            <!-- Social Profiles -->
                            <a class="media" href="#">
                                <div class="icon icon-xs icon-soft-secondary mr-3">
                                    <i class="fab fa-facebook-f"></i>
                                </div>
                                <div class="media-body">
                                    <span class="d-block font-size-1 font-weight-bold">Facebook</span>
                                    <small class="d-block text-body">3k followers</small>
                                </div>
                            </a>
                            <!-- End Social Profiles -->
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="col-md-7 col-lg-8 card">
            <div class=" card-body">
                <div class="mb-3 mb-sm-0 mr-2">
                    <h2>{{ $shop->name }}</h2>
                </div>

                <div class="media text-body font-size-1 mb-3">
                    <i class="fas fa-briefcase mt-1 mr-2"></i>
                    <div class="media-body">
                        {{ $shop->description }}
                    </div>
                </div>

                <p>Nataly Gaga has a BS and MS in Mechanical Engineering from Santa Clara University and years of
                    experience as a professional instructor and trainer for Data Science and programming. She has
                    publications and patents in various fields such as microfluidics, materials science, and data
                    science technologies.</p>

                <!-- Read More - Collapse -->
                <div class="collapse" id="collapseDescriptionSection">
                    <p>Over the course of her career she has developed a skill set in analyzing data and she hopes to
                        use her experience in teaching and data science to help other people learn the power of
                        programming the ability to analyze data, as well as present the data in clear and beautiful
                        visualizations.</p>
                </div>
                <!-- End Read More - Collapse -->

                <!-- Link -->
                <a class="link link-collapse small font-size-1 font-weight-bold" data-toggle="collapse"
                    href="#collapseDescriptionSection" role="button" aria-expanded="false"
                    aria-controls="collapseDescriptionSection">
                    <span class="link-collapse-default">Read more</span>
                    <span class="link-collapse-active">Read less</span>
                    <span class="link-icon ml-1">+</span>
                </a>
                <!-- End Link -->

                <div class="js-nav-scroller hs-nav-scroller-horizontal">
                    <span class="hs-nav-scroller-arrow-prev" style="display: none;">
                      <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                        <i class="bi-chevron-left"></i>
                      </a>
                    </span>

                    <span class="hs-nav-scroller-arrow-next" style="display: flex;">
                      <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                        <i class="bi-chevron-right"></i>
                      </a>
                    </span>

                    <!-- Nav -->
                    <ul class="nav nav-segment nav-fill mb-7" id="propertyOverviewNavTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <a class="nav-link active" href="#propertyOverviewNavOne" id="propertyOverviewNavOne-tab" data-bs-toggle="tab" data-bs-target="#propertyOverviewNavOne" role="tab" aria-controls="propertyOverviewNavOne" aria-selected="true" style="min-width: 7rem;">Details</a>
                      </li>

                      <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#propertyOverviewNavTwo" id="propertyOverviewNavTwo-tab" data-bs-toggle="tab" data-bs-target="#propertyOverviewNavTwo" role="tab" aria-controls="propertyOverviewNavTwo" aria-selected="false" style="min-width: 7rem;">Floorplan</a>
                      </li>

                      <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#propertyOverviewNavThree" id="propertyOverviewNavThree-tab" data-bs-toggle="tab" data-bs-target="#propertyOverviewNavThree" role="tab" aria-controls="propertyOverviewNavThree" aria-selected="false" style="min-width: 7rem;">Map</a>
                      </li>

                      <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#propertyOverviewNavThree" id="propertyOverviewNavFour-tab" data-bs-toggle="tab" data-bs-target="#propertyOverviewNavFour" role="tab" aria-controls="propertyOverviewNavFour" aria-selected="false" style="min-width: 7rem;">Market stats</a>
                      </li>
                    </ul>
                    <!-- End Nav -->
                  </div>

                  <div class="tab-content">
                    <div class="tab-pane fade active show" id="propertyOverviewNavOne" role="tabpanel" aria-labelledby="propertyOverviewNavOne-tab">
                      <div class="mb-4">
                        <h4>Home details</h4>
                      </div>

                      <div class="row justify-content-md-between">
                        <div class="col-md-5">
                          <dl class="row">
                            <dt class="col-6">Property ID:</dt>
                            <dd class="col-6">HG328e91UA</dd>

                            <dt class="col-6">Property type:</dt>
                            <dd class="col-6">House</dd>

                            <dt class="col-6">Year built:</dt>
                            <dd class="col-6">2015</dd>
                          </dl>
                          <!-- End Row -->
                        </div>
                        <!-- End Col -->

                        <div class="col-md-5">
                          <dl class="row">
                            <dt class="col-6">Lot size:</dt>
                            <dd class="col-6">1,428 sq.m.</dd>

                            <dt class="col-6">Rooms:</dt>
                            <dd class="col-6">12</dd>

                            <dt class="col-6">Parking:</dt>
                            <dd class="col-6">2</dd>
                          </dl>
                          <!-- End Row -->
                        </div>
                        <!-- End Col -->
                      </div>
                      <!-- End Row -->

                      <div class="border-top border-bottom py-4 mt-4 mb-7">
                        <div class="row col-sm-divider">
                          <div class="col-sm-6 text-sm-end mb-2 mb-sm-0">
                            <div class="pe-md-4">
                              <span>Last 30 days:</span>
                              <span class="text-dark fw-semi-bold">920 page views</span>
                            </div>
                          </div>
                          <!-- End Col -->

                          <div class="col-sm-6">
                            <div class="ps-md-4">
                              <span>Since listed:</span>
                              <span class="text-dark fw-semi-bold">471 page views</span>
                            </div>
                          </div>
                          <!-- End Col -->
                        </div>
                        <!-- End Row -->
                      </div>

                      <div class="mb-4">
                        <h4>Description</h4>
                      </div>

                      <p>This extremely spacious two/three bedroom duplex apartment occupies a desirable position to the South-West of Harrogate's town centre and offers a huge amount of scope to update and re-model to suit the individual including a large eaves storage room ripe for conversion into a second bathroom.</p>

                      <p>Accessed via a communal hall up to the first floor, the apartment opens into a split level hall. To the front elevation there is a lovely, light and airy lounge with far reaching views towards the town centre and countryside beyond. Adjoining there is a well proportioned double bedroom with a fitted wardrobe.</p>

                      <!-- Collapse Link - Content -->
                      <div class="collapse" id="propertyOverviewDescriptionViewMoreCollapse">
                        <div class="mb-4">
                          <h4>Directions</h4>
                        </div>

                        <p>Proceed up the Otley Road from the Prince Of Wales roundabout and through the traffic lights with the turning into Harlow Moor Road. Continue ahead where the property can be found on the left hand side.</p>

                        <div class="mb-4">
                          <h4>Strictly by appointment through Front House</h4>
                        </div>

                        <p>You may download, store and use the material for your own personal use and research. You may not republish, retransmit, redistribute or otherwise make the material available to any party or make the same available on any website, online service or bulletin board of your own or of any other party or make the same available in hard copy or in any other media without the website owner's express prior written consent. The website owner's copyright must remain on all reproductions of material taken from this website.</p>
                      </div>
                      <!-- End Collapse Link - Content -->

                      <!-- Collapse Link -->
                      <a class="link link-collapse" data-bs-toggle="collapse" href="#propertyOverviewDescriptionViewMoreCollapse" role="button" aria-expanded="false" aria-controls="propertyOverviewDescriptionViewMoreCollapse">
                        <span class="link-collapse-default">View More</span>
                        <span class="link-collapse-active">View Less</span>
                      </a>
                      <!-- End Collapse Link -->

                      <hr class="my-6">

                      <div class="mb-4">
                        <h4>Accessibility</h4>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <!-- List -->
                          <ul class="list-unstyled list-py-1 mb-0">
                            <li class="d-flex align-items-center">
                              <h6 class="mb-0">Location</h6>

                              <div class="d-flex gap-1 ms-auto">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                              </div>
                            </li>

                            <li class="d-flex align-items-center">
                              <h6 class="mb-0">Area safety</h6>

                              <div class="d-flex gap-1 ms-auto">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star-half.svg" alt="Review rating" width="16">
                              </div>
                            </li>

                            <li class="d-flex align-items-center">
                              <h6 class="mb-0">Close to schools</h6>

                              <div class="d-flex gap-1 ms-auto">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star-half.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star-muted.svg" alt="Review rating" width="16">
                              </div>
                            </li>
                          </ul>
                          <!-- End List -->
                        </div>

                        <div class="col-sm-6">
                          <!-- List -->
                          <ul class="list-unstyled list-py-1 mb-0">
                            <li class="d-flex align-items-center">
                              <h6 class="mb-0">Low cost</h6>

                              <div class="d-flex gap-1 ms-auto">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                              </div>
                            </li>

                            <li class="d-flex align-items-center">
                              <h6 class="mb-0">Built around</h6>

                              <div class="d-flex gap-1 ms-auto">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star-muted.svg" alt="Review rating" width="16">
                              </div>
                            </li>

                            <li class="d-flex align-items-center">
                              <h6 class="mb-0">Value</h6>

                              <div class="d-flex gap-1 ms-auto">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star-muted.svg" alt="Review rating" width="16">
                                <img src="../assets/svg/illustrations/star-muted.svg" alt="Review rating" width="16">
                              </div>
                            </li>
                          </ul>
                          <!-- End List -->
                        </div>
                      </div>
                      <!-- End Row -->

                      <hr class="my-6">

                      <h4 class="mb-1">Estimated running costs</h4>
                      <p class="small">Based on available 3rd party data</p>

                      <div class="row">
                        <div class="col-md-6">
                          <span class="h1">£810</span>
                          <p>Approximate costs per month</p>
                        </div>
                        <!-- End Col -->

                        <div class="col-md-6">
                          <dl class="row">
                            <dt class="col-6">
                              <i class="bi-bank2 me-2"></i> Mortgage
                            </dt>
                            <dd class="col-6 text-end">£700 p/m</dd>

                            <dt class="col-6">
                              <i class="bi-lightning-charge-fill me-2"></i> Energy
                            </dt>
                            <dd class="col-6 text-end">from £72 p/m</dd>

                            <dt class="col-6">
                              <i class="bi-droplet-half me-2"></i> Water
                            </dt>
                            <dd class="col-6 text-end">
                              from £38 p/m
                            </dd>

                            <dt class="col-6 text-dark">
                              <i class="bi-shield-shaded me-2"></i> Home insurance
                            </dt>
                            <dd class="col-6 text-end">not known</dd>
                          </dl>
                          <!-- End Row -->
                        </div>
                        <!-- End Col -->
                      </div>
                      <!-- End Row -->
                    </div>

                    <div class="tab-pane fade" id="propertyOverviewNavTwo" role="tabpanel" aria-labelledby="propertyOverviewNavTwo-tab">
                      <a href="../assets/img/others/img1.png" data-fslightbox="propertyOverviewFloorplan">
                        <img class="img-fluid" src="../assets/img/others/img1.png" alt="Image Description">
                      </a>

                      <small class="form-text">Image source from <a class="link-sm" href="https://floorplanner.com/" target="_blank">floorplanner.com</a></small>
                    </div>

                    <div class="tab-pane fade" id="propertyOverviewNavThree" role="tabpanel" aria-labelledby="propertyOverviewNavThree-tab">
                      <!-- Gmap -->
                      <div id="map" class="h-380rem leaflet-container leaflet-touch leaflet-retina leaflet-safari leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom" data-hs-leaflet-options="{
                             &quot;map&quot;: {
                               &quot;scrollWheelZoom&quot;: false,
                               &quot;coords&quot;: [37.4040344, -122.0289704]
                             },
                             &quot;marker&quot;: [
                               {
                                 &quot;coords&quot;: [37.4040344, -122.0289704],
                                 &quot;icon&quot;: {
                                   &quot;iconUrl&quot;: &quot;../assets/svg/components/map-pin.svg&quot;,
                                   &quot;iconSize&quot;: [50, 45]
                                 },
                                 &quot;popup&quot;: {
                                   &quot;text&quot;: &quot;153 Williamson Plaza, Maggieberg&quot;,
                                   &quot;title&quot;: &quot;Address&quot;
                                 }
                               }
                             ]
                            }" tabindex="0" style="position: relative;"><div class="leaflet-pane leaflet-map-pane" style="transform: translate3d(0px, 0px, 0px);"><div class="leaflet-pane leaflet-tile-pane"><div class="leaflet-layer " style="z-index: 1; opacity: 1;"><div class="leaflet-tile-container leaflet-zoom-animated" style="z-index: 18; transform: translate3d(0px, 0px, 0px) scale(1);"><img alt="" role="presentation" src="https://api.mapbox.com/styles/v1/mapbox/streets-v11/tiles/13/1319/3177?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(-42px, -8px, 0px); opacity: 1;"></div></div><div class="leaflet-layer " style="z-index: 1; opacity: 1;"><div class="leaflet-tile-container leaflet-zoom-animated" style="z-index: 18; transform: translate3d(0px, 0px, 0px) scale(1);"><img alt="" role="presentation" src="https://api.mapbox.com/styles/v1/mapbox/light-v9/tiles/13/1319/3177?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(-42px, -8px, 0px); opacity: 1;"></div></div></div><div class="leaflet-pane leaflet-shadow-pane"></div><div class="leaflet-pane leaflet-overlay-pane"></div><div class="leaflet-pane leaflet-marker-pane"><img src="../assets/svg/components/map-pin.svg" class="leaflet-marker-icon leaflet-zoom-animated leaflet-interactive" alt="" tabindex="0" style="margin-left: -25px; margin-top: -22.5px; width: 50px; height: 45px; transform: translate3d(0px, 0px, 0px); z-index: 0;"></div><div class="leaflet-pane leaflet-tooltip-pane"></div><div class="leaflet-pane leaflet-popup-pane"></div><div class="leaflet-proxy leaflet-zoom-animated" style="transform: translate3d(337706px, 813320px, 0px) scale(4096);"></div></div><div class="leaflet-control-container"><div class="leaflet-top leaflet-left"><div class="leaflet-control-zoom leaflet-bar leaflet-control"><a class="leaflet-control-zoom-in" href="#" title="Zoom in" role="button" aria-label="Zoom in">+</a><a class="leaflet-control-zoom-out" href="#" title="Zoom out" role="button" aria-label="Zoom out">−</a></div></div><div class="leaflet-top leaflet-right"></div><div class="leaflet-bottom leaflet-left"></div><div class="leaflet-bottom leaflet-right"><div class="leaflet-control-attribution leaflet-control"><a href="https://leafletjs.com" title="A JS library for interactive maps">Leaflet</a></div></div></div></div>
                      <!-- End Gmap -->
                    </div>

                    <div class="tab-pane fade" id="propertyOverviewNavFour" role="tabpanel" aria-labelledby="propertyOverviewNavFour-tab">
                      <div class="mb-5">
                        <h5>Sale activity</h5>
                        <p>Average estimated value for a flat in HG2:</p>

                        <h3 class="text-primary mb-0">£271,401</h3>
                        <i class="bi-arrow-down-right text-danger"></i>
                        <span>£7,710  (-2.762%)</span>
                        <span class="text-muted small ms-1">Over the last 12 months</span>
                      </div>

                      <div class="mb-5">
                        <h5>In the last 12 months</h5>

                        <div class="row justify-content-sm-between">
                          <div class="col-sm-6">
                            <span class="d-block">Average sale price</span>
                            <h3 class="text-primary mb-0">£267,606</h3>
                          </div>
                          <!-- End Col -->

                          <div class="col-sm-6">
                            <span class="d-block">Properties sold</span>
                            <h3 class="text-primary mb-0">51</h3>
                          </div>
                          <!-- End Col -->
                        </div>
                        <!-- End Row -->
                      </div>
                    </div>
                  </div>

                <!-- Courses -->
                <div class="border-top pt-5 mt-5">
                    <h3 class="mb-4">{{ $shop->name }} {{ translate('Products') }}</h3>

                    <!-- Course -->
                    <div class="row pt-0 mt-0 ev-horizontal-slider d-flex flex-nowrap pb-5" style="overflow-x: auto;">
                        @foreach($shop->products as $product)
                        <div class="col-sm-5">
                            <x-default.products.cards.product-card :product="$product">
                            </x-default.products.cards.product-card>
                        </div>

                        @endforeach

                    </div>
                    <!-- End Course -->



                    <div class="text-right font-size-1 mt-6">
                        <a class="font-weight-bold" href="courses-listing.html">See all Courses <i
                                class="fas fa-angle-right fa-sm ml-1"></i></a>
                    </div>
                </div>
                <!-- End Courses -->

                <!-- Courses -->
                <div class="border-top pt-5 mt-5">
                    <h3 class="h5 mb-4">{{ $shop->name }} {{ translate('Services') }}</h3>

                    <div class="row mx-n2 mx-lg-n3">

                        <!-- Article -->
                        <article class="col-sm-6 col-lg-4 px-2 px-lg-3 mb-3 mb-lg-0">
                            <a class="card bg-img-hero w-100 min-h-270rem transition-3d-hover"
                                href="course-description.html"
                                style="background-image: url(../../assets/img/400x500/img15.jpg);">
                                <div class="card-body">
                                    <span
                                        class="d-block small text-white-70 font-weight-bold text-cap mb-2">Tooling</span>
                                    <h3 class="text-white">Build a staging server</h3>
                                </div>
                                <div class="card-footer border-0 bg-transparent pt-0">
                                    <span class="text-white font-size-1 font-weight-bold">Read now</span>
                                </div>
                            </a>
                        </article>
                        <!-- End Article -->


                    </div>
                </div>
                <!-- End Courses -->

                <!-- Sticky Block End Point -->
                <div id="stickyBlockEndPoint"></div>
            </div>
        </div>
    </div>
</div>

@endsection
