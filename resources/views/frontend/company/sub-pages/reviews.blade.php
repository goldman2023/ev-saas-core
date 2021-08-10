@extends('frontend.layouts.company-profile-layout')

@section('company_profile')


        <x-company-tabs :seller="$seller" type="reviews"></x-company-tabs>
        @php
   
            if (!isset($sort)) $sort = "desc";
            $review_relationships = $shop->reviews()->orderBy('created_at', $sort)->paginate(5);
            if ($review_relationships->count() > 0) {
                //get count of each star ratings
                $five_stars = $shop->reviews()->where("rating", 5)->count();
                $four_stars = $shop->reviews()->where("rating", 4)->count();
                $three_stars = $shop->reviews()->where("rating", 3)->count();
                $two_stars = $shop->reviews()->where("rating", 2)->count();
                $one_stars = $shop->reviews()->where("rating", 1)->count();
                //get total average rating and count;
                $total_rating = $five_stars * 5 + $four_stars * 4 + $three_stars * 3 + $two_stars * 2 + $one_stars;
                $review_count = $five_stars + $four_stars + $three_stars + $two_stars + $one_stars;
                $average = number_format($total_rating / $review_count, 2);
            }
        @endphp
        <!-- Review Section -->
        <div class="container">
            @if($review_relationships->count() > 0)
            <div class="row">
                <div class="col-12 mb-3">
                    <h1 class="">{{ translate('Company Reviews') }}: {{$shop->name}}</h1>
                </div>
                <div class="col-lg-4 mb-7 mb-lg-0">
                    <div class="pb-4 mb-4">
                        <!-- Overall Rating Stats -->
                        <div class="card bg-primary text-white p-4 mb-3">
                            <div class="d-flex justify-content-center align-items-center">
                                <span class="display-4">{{$average}}</span>
                                <div class="ml-3">
                                    <div class="small">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <span><span class="font-weight-bold">{{$review_count}}</span> reviews</span>
                                </div>
                            </div>
                        </div>
                        <!-- End Overall Rating Stats -->

                        <h3>Rating breakdown</h3>

                        <!-- Ratings -->
                        <ul class="list-unstyled list-sm-article">
                            <li>
                                <a class="row align-items-center mx-n2 font-size-1" href="javascript:;">
                                    <div class="col-3 px-2">
                                        <span class="text-dark">5 stars</span>
                                    </div>
                                    <div class="col-7 px-2">
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar" role="progressbar" style="{{'width: ' . ($five_stars == 0 ? '0' : $review_count * 100 / $five_stars) . '%;'}}"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-2 text-right px-2">
                                        <span>{{ $five_stars }}</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="row align-items-center mx-n2 font-size-1" href="javascript:;">
                                    <div class="col-3 px-2">
                                        <span class="text-dark">4 stars</span>
                                    </div>
                                    <div class="col-7 px-2">
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar" role="progressbar" style="{{'width: ' . ($four_stars == 0 ? '0' : $review_count * 100 / $four_stars) . '%;'}}"
                                                aria-valuenow="53" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-2 text-right px-2">
                                        <span>{{ $four_stars }}</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="row align-items-center mx-n2 font-size-1" href="javascript:;">
                                    <div class="col-3 px-2">
                                        <span class="text-dark">3 stars</span>
                                    </div>
                                    <div class="col-7 px-2">
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar" role="progressbar" style="{{'width: ' . ($three_stars == 0 ? '0' : $review_count * 100 / $three_stars) . '%;'}}"
                                                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-2 text-right px-2">
                                        <span>{{ $three_stars }}</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="row align-items-center mx-n2 font-size-1" href="javascript:;">
                                    <div class="col-3 px-2">
                                        <span class="text-dark">2 stars</span>
                                    </div>
                                    <div class="col-7 px-2">
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar" role="progressbar" style="{{'width: ' . ($two_stars == 0 ? '0' : $review_count * 100 / $two_stars) . '%;'}}"
                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-2 text-right px-2">
                                        <span>{{ $two_stars }}</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="row align-items-center mx-n2 font-size-1" href="javascript:;">
                                    <div class="col-3 px-2">
                                        <span class="text-dark">1 stars</span>
                                    </div>
                                    <div class="col-7 px-2">
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar" role="progressbar" style="{{'width: ' . ($one_stars == 0 ? '0' : $review_count * 100 / $one_stars) . '%;'}}"
                                                aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-2 text-right px-2">
                                        <span>{{ $one_stars }}</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- End Ratings -->
                    </div>

                    <!-- <span class="d-block display-4 text-dark">77%</span>
                    <p class="small">of customers recommend this product</p> -->
                </div>

                <div class="col-lg-8">
                    <div class="pl-lg-4">
                        <!-- Title -->
                        <div class="border-bottom pb-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="text-body mb-0">Sort on</h4>

                                <!-- Select -->
                                <form id="sort_type" action="" method="GET">
                                    <select class="js-custom-select" data-hs-select2-options='{
                                        "minimumResultsForSearch": "Infinity",
                                        "customClass": "btn btn-sm btn-white dropdown-toggle",
                                        "dropdownAutoWidth": true,
                                        "width": "auto"
                                    }' name="sort_type" onchange="submit()">
                                        <option value="desc" {{$sort == "desc" ? "selected" : ""}}>Most recent</option>
                                        <option value="asc" {{$sort == "asc" ? "selected" : ""}}>Oldest</option>
                                    </select>
                                </form>
                                <!-- End Select -->
                            </div>
                        </div>
                        <!-- End Title -->

                        <!-- Review -->
                        @foreach ($review_relationships as $relationship)
                        <div class="border-bottom pb-4 mb-4">
                            <!-- Review Rating -->
                            <div class="d-flex justify-content-between align-items-center text-body font-size-1 mb-3">
                                {{renderStarRating($relationship->rating)}}
                                <span>{{ date('M d, Y', strtotime($relationship->created_at)) }}</span>
                            </div>
                            <!-- End Review Rating -->

                            <h4 class="text-uppercase">Reliable partner for wood-palets</h4>
                            <p>{{ $relationship->comment }}</p>

                            <!-- Reviewer -->
                            <div class="text-body font-size-1 mb-2">
                                <span class="text-dark font-weight-bold"><a href="#">{{ \App\User::where('id', $relationship->user_id)->first()->name }}</a></span>
                                @if ($relationship->status == 1)
                                <span>- {{ translate('Verified Review') }} <img class="avatar avatar-xss ml-1" src="{{ asset('assets/svg/illustrations/top-vendor.svg') }}"
                                    alt="{{ translate('Verified Company') }}" data-toggle="tooltip" data-placement="top"
                                    title="" data-original-title="{{ translate('Verified Review') }}"></span>
                                @endif
                            </div>
                            <!-- End Reviewer -->

                          
                        </div>
                        @endforeach
                        <!-- End Review -->

                      
                        <!-- End Review -->

                      

                        <div class="d-sm-flex justify-content-sm-end">
                            <div class="aiz-pagination mr-4 mt-2">
                                {{ $review_relationships->links() }}
                            </div>
                            <a href="{{ route('reviews.create', $shop->slug) }}">
                                <button type="button"
                                    class="btn btn-primary btn-pill w-100 w-sm-auto transition-3d-hover px-5 mb-2">Write a
                                    Review</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <x-company-reviews-empty-state :shop="$shop"></x-company-reviews-empty-state>
            @endif
        </div>
        <!-- End Review Section -->

@endsection

@section('script')
    <script type="text/javascript">
    </script>
@endsection