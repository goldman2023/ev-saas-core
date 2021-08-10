@extends('frontend.layouts.app')

@section('content')
    <!-- Team Section -->
    <div class="container space-2">
        <!-- Title -->
        <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
            <span class="d-block small font-weight-bold text-cap mb-2">{{ translate('B2BWood Partners') }}</span>
            <h2>{{ translate('We work with the best companies in Digital Forestry Solutions industry') }}</h2>
           
        </div>
        <!-- End Title -->
        <div class="row">
            <div class="col-12">
                <p class="text-center">
                    We work with serious and trusted companies and confirmed traction. Partner relationships help us to
                    improve services
                </p>
            </div>
            <div class="col-sm-6 col-lg-3 px-2 mb-3">
                <!-- Team -->
                <div class="card h-100 transition-3d-hover">
                    <div class="card-body">
                        <div class=" mb-4">
                        {{-- TODO: Replace this with local images --}}
                            <img class="img-fluid"
                                src="https://ite-prod-cdn-end.azureedge.net/sharedmedia/woodexpo/media/assets/%D0%B4%D0%B5%D1%80%D0%B5%D0%B2%D0%BE_ru_logo.jpg?ext=.jpg"
                                alt="Derewo.ru">
                        </div>

                        <span class="d-block small font-weight-bold text-cap mb-1">Russia</span>
                        <h4 class="text-lh-sm">Derewo.ru</h4>
                        {{-- <p class="font-size-1">I am an ambitious workaholic, but apart from that, pretty simple person.</p> --}}
                    </div>

                    <div class="card-footer border-0 pt-0">
                        <!-- Social Networks -->
                        <ul class="list-inline mb-0 text-center">
                            <li class="list-inline-item">
                                <a class="btn btn-xs btn-icon btn-soft-secondary rounded-lg" target="_blank" href="#">
                                    <i class="lab la-facebook-f"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a class="btn btn-xs btn-icon btn-soft-secondary rounded-lg" target="_blank" href="#">
                                    <i class="lab la-linkedin-in"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a class="btn btn-xs btn-icon btn-soft-secondary rounded-lg" target="_blank" href="#">
                                    <i class="lab la-google"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- End Social Networks -->
                    </div>
                </div>
                <!-- End Team -->
            </div>


            {{-- TODO: Make this a blade component like: <x-partner-card> --}}

             <div class="col-sm-6 col-lg-3 px-2 mb-3">
                <!-- Team -->
                <div class="card h-100 transition-3d-hover">
                    <div class="card-body">
                        <div class=" mb-4">
                        {{-- TODO: Replace this with local images --}}
                            <img class="img-fluid"
                                src="https://whatwood.ru/english/wp-content/themes/whatwood_en/images/logo.jpg"
                                alt="whatwood.ru">
                        </div>

                        <span class="d-block small font-weight-bold text-cap mb-1">Russia</span>
                        <h4 class="text-lh-sm">What Wood</h4>
                        {{-- <p class="font-size-1">I am an ambitious workaholic, but apart from that, pretty simple person.</p> --}}
                    </div>

                    <div class="card-footer border-0 pt-0">
                        <!-- Social Networks -->
                        <ul class="list-inline mb-0 text-center">
                            <li class="list-inline-item">
                                <a class="btn btn-xs btn-icon btn-soft-secondary rounded-lg" target="_blank" href="#">
                                    <i class="lab la-facebook-f"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a class="btn btn-xs btn-icon btn-soft-secondary rounded-lg" target="_blank" href="#">
                                    <i class="lab la-linkedin-in"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a class="btn btn-xs btn-icon btn-soft-secondary rounded-lg" target="_blank" href="#">
                                    <i class="lab la-google"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- End Social Networks -->
                    </div>
                </div>
                <!-- End Team -->
            </div>
        </div>

    </div>
@endsection
