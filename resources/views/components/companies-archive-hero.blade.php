<!-- Hero Section -->
<div class="position-relative gradient-x-three-sm-primary rounded-lg space-top-md-1 space-bottom-md-2 mx-md-10">
    <div class="container position-relative space-top-2 space-top-lg-2 space-bottom-1">
        <div class="row position-relative z-index-2">
            <div class="col-lg-6">
                <!-- Title -->
                <div class="w-lg-80 text-center text-lg-left mb-5 mb-lg-7">
                    <h1 class="display-4">
                        @php
                            
                            $image = asset('assets/img/hero-images/b2bwood-homepage-banner.jpg');
                            
                            if ($category) {
                                $categoryTitle = $category->tile;
                                $categoryTitle = $category->name;
                            }
                            
                            //$country = 'Germany';
                            
                        @endphp
                        @if ($categoryTitle)
                            {{ translate('Find ') }} <span class="">{{ $categoryTitle }}</span>
                            {{ translate('companies') }}
                            <br><span class="text-primary text-highlight-warning">{{ translate('in') }}</span>

                            @if ($country)
                                {{ $country }}
                                <img src="{{ static_asset('assets/img/flags/de.png') }}" height="20" class="mr-1">
                            @else
                                {{ translate('B2BWood Club') }}
                            @endif

                    </h1>
                @else
                    {{ translate('Find Trusted Global Wood Companies') }}
                    <br><span class="text-primary text-highlight-warning">{{ translate('in') }}</span> B2BWood Club
                    </h1>
                    @endif

                </div>
                <!-- End Title -->

                <!-- Card -->
                <div class="card p-2 mb-3">
                    <!-- Input Group -->
                    <x-b2-b-search></x-b2-b-search>

                    <!-- End Input Group -->
                </div>
                {{-- Show filtering only on mobile devices and in category pages --}}
                @if ($categoryTitle)
                <div class=" text-center mb-3 d-sm-block d-lg-none">
                    {{ translate(' — or — ') }}
                </div>
                <div class="card p-0 m-0 d-sm-block d-lg-none">

                    <div class="row">
                        <div class="col-12 text-right align-items-center justify-content-center">
                            {{-- Filtering Mobile --}}
                            <div class="d-xl-none  d-flex align-self-center">
                                <div class=" btn btn-primary w-100" data-toggle="class-toggle"
                                    data-target=".aiz-filter-sidebar">
                                    <i class="la la-filter la-2x"></i> {{ translate('Filter Companies') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endif
                <!-- End Card -->

                <small class="form-text">
                    {{ translate('Search through over') }} {{ App\Models\Shop::companies_count_rounded() }}
                    {{ translate('companies') }}
                    @guest
                        {{ translate(' — or — ') }}
                        <a href="{{ route('shops.create') }}"> {{ translate('Join The Club!') }} </a>
                    @endguest
                </small>
            </div>
        </div>
        <!-- End Row -->

        <div class="d-none d-lg-block col-lg-6 position-absolute top-0 right-0">
            <img class="img-fluid rounded-lg" src="{{ $image }}" alt="Image Description">

            <figure class="max-w-15rem w-100 position-absolute top-0 left-0 z-index-n1">
                <div class="mt-n6 ml-n5">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 335.2 335.2" width="100"
                        height="100">
                        <circle fill="#083937" opacity=".7" cx="167.6" cy="167.6" r="130.1" />
                    </svg>
                </div>
            </figure>



            <div class="d-flex align-items-center">
                <small class="ml-auto">
                    {{ translate('Powered by:') }}
                </small>
                <a href="https://eim.solutions" target="_blank">
                    <img class="" width="150px" src="https://eim.solutions/dist/images/eim-logo.png"
                        alt="EIM Solutions Logo">
                </a>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->
