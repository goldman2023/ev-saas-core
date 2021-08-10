<!-- Card -->
<a class="d-block border-bottom pb-5 mb-5" href="{{ route('product', $product->slug) }}">
    <div class="row mx-md-n2">
        <div class="col-md-4 px-md-2 mb-3 mb-md-0">
            <div class="position-relative">
                @if($product->thumbnail_img)
                <img class="img-fluid w-100 rounded-lg" src="{{ uploaded_asset($product->thumbnail_img) }}"
                     data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                     alt="{{  $product->getTranslation('name')  }}"
                >

                @else

                    <img class="img-fluid w-100 rounded-lg" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                         data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                         alt="{{  $product->getTranslation('name')  }}"
                    >
                    @endif

                <div class="position-absolute top-0 left-0 mt-3 ml-3">
                    <small
                        class="btn btn-xs btn-success text-white btn-pill text-uppercase shadow-soft py-1 px-2 mb-3">{{ translate('New!') }}</small>
                </div>


            </div>
        </div>

        <div class="col-md-8">
            <div class="media mb-2">
                <div class="media-body mr-7">
                    <h3 class="text-hover-primary">
                        {{  $product->getTranslation('name')  }}
                    </h3>
                    <h6>
                        {{ translate('Sold By: ') }} {{ $product->user->shop->name }}
                    </h6>
                </div>

                <div class="d-flex mt-1 ml-auto">
                    <div class="text-right">
                        @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                            <small class="d-block display-6 text-danger">
                                <del class="fw-600  mr-1">{{ home_base_price($product->id) }}</del>
                            </small>
                        @endif

                        <span class="d-block h5 text-primary display-4 mb-0">
                            <span class="fw-700 text-primary">
                                {{ home_discounted_base_price($product->id) }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-start align-items-center small text-muted mb-2 opacity-0"">
                <div class="d-flex align-items-center">
                    <div class="avatar-group">
                        {{ renderStarRating($product->rating) }}

                    </div>
                </div>
                <div class="ml-auto opacity-0">
                    <i class="fa fa-book-reader mr-1"></i>
                    10 lessons
                </div>
                <span class="text-muted mx-2">|</span>
                <div class="d-inline-block">
                    <i class="fa fa-clock mr-1"></i>
                    3h 25m
                </div>
                <span class="text-muted mx-2">|</span>

                <div class="d-inline-block">
                    <i class="fa fa-signal mr-1"></i>
                    Free For Prime members
                </div>


            </div>

            <div class="font-size-1 text-body mb-0">
                {!! shorten_string(strip_tags($product->description), 50) !!}


                <div class="text-right mt-3">

                   <button class="buy-now-button btn-primary btn">
                       {{ translate('Buy Now') }}
                   </button>

                    <button class="buy-now-button btn-success text-white btn">
                        {{ translate('Product details') }}
                    </button>

                </div>
            </div>


        </div>
    </div>
</a>
<!-- End Card -->


