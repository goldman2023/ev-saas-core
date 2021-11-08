<!-- Featured Topics Carousel -->
<article class="mb-5 h-100">
    <!-- Article -->
    <div class="card card-bordered h-100 b2b-product-card">
        <div class="card-img-top position-relative">

            <a href="{{ $product->permalink }}">
                @if($product->thumbnail_img)
                    <img class="card-img-top" src="{{ uploaded_asset($product->thumbnail_img) }}"
                         data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                         alt="{{  $product->getTranslation('name')  }}">
                @else
                    <img class="card-img-top" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                         data-src="{{ static_asset('assets/img/placeholder.jpg') }}"
                         alt="{{  $product->getTranslation('name')  }}">
                @endif
            </a>


            <div class="position-absolute top-0 left-0 mt-3 ml-3">
                <small class="btn btn-xs btn-success btn-pill text-uppercase shadow-soft mb-3 text-white">
                    {{ translate('New!') }}
                </small>
            </div>

            <div class="position-absolute bottom-0 left-0 mb-3 ml-4">
                <div class="d-none align-items-center flex-wrap">
                    {{ renderStarRating($product->rating) }}
                </div>
            </div>
        </div>

        <div class="card-body">
            <small class="d-block small font-weight-bold text-cap mb-2">{{ translate('Product') }}</small>

            <div class="mb-3">
                <h3>
                    <a class="text-inherit" href="{{ $product->permalink }}">{{  $product->getTranslation('name')  }}</a>
                </h3>
            </div>

            <div class="">
                <div class="">
                    <a class="">
                        <h6>
                            {{ translate('Sold By: ') }} {{ $product->shop->name }}
                        </h6>
                    </a>
                </div>

            </div>
        </div>

        <div class="card-footer border-0 pt-0">


            <div class="b2b-product-pricing">
                @if($product->getBasePrice() != $product->getTotalPrice())
                    <small class="d-block text-lh-sm text-danger">
                        <del>{{ $product->getBasePrice(true) }}</del>
                    </small>
                @endif
                <span class="d-block h5 text-primary display-5 mb-0">
                            <span class="fw-700 text-primary">
                                {{ $product->getTotalPrice(true) }}
                            </span>
            </span>
            </div>


            <div class="d-flex justify-content-between align-items-center">
                <a class="btn  btn-primary transition-3d-hover" href="{{ $product->permalink }}">
                    {{ translate('Product details') }}
                </a>
            </div>
        </div>
    </div>
    <!-- End Article -->
</article>
