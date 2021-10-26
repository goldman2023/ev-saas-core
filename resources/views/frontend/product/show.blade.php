@extends('frontend.layouts.' . $globalLayout)

@section('meta_title'){{ $detailedProduct->meta_title }}@stop

@section('meta_description'){{ $detailedProduct->meta_description }}@stop

@section('meta_keywords'){{ $detailedProduct->tags }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
    <meta itemprop="description" content="{{ $detailedProduct->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
    <meta name="twitter:description" content="{{ $detailedProduct->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($detailedProduct->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $detailedProduct->meta_title }}" />
    <meta property="og:type" content="og:product" />
    <meta property="og:url" content="{{ route('product', $detailedProduct->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}" />
    <meta property="og:description" content="{{ $detailedProduct->meta_description }}" />
    <meta property="og:site_name" content="{{ get_setting('meta_title') }}" />
    <meta property="og:price:amount" content="{{ single_price($detailedProduct->unit_price) }}" />
    <meta property="product:price:currency"
        content="{{ \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code }}" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
@endsection

@section('content')
    <div class="container position-relative mb-5">
        <div id="fancyboxGallery" class="js-fancybox" data-hs-fancybox-options="{
                    'selector': '#fancyboxGallery .js-fancybox-item'
                }">
            <div class="rounded-lg overflow-hidden rounded-lg">
                <div class="row ">
                    <div class="col-md-8" style="max-height: 400px; overflow: hidden;">
                        <div class="row">
                            <div class="col-8">
                                <!-- Gallery -->
                                @php
                                    $photos = explode(',', $product->photos);
                                @endphp
                                <a class="js-fancybox-item d-block" href="javascript:;"
                                    data-src="../assets/img/1920x1080/img27.jpg" data-caption="Front in frames - image #01">
                                    <x-tenant.system.image class="img-fluid w-100" :image="$photos[0]">
                                    </x-tenant.system.image>

                                    <div class="position-absolute bottom-10 right-0 pb-3 pr-3">
                                        <span class="d-md-none btn btn-sm btn-light">
                                            {{ svg('heroicon-o-arrows-expand', ['class' => 'ev-icon__xs']) }}
                                            {{ translate('View Photos') }}
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-4">
                                <!-- Gallery -->
                                <x-tenant.system.image class="img-fluid w-100" :image="$photos[0]">
                                </x-tenant.system.image>
                                </a>

                                <!-- End Gallery -->

                                <!-- Gallery -->
                                <a class="js-fancybox-item d-block" href="javascript:;"
                                    data-src="../assets/img/1920x1080/img14.jpg" data-caption="Front in frames - image #04">
                                    <x-tenant.system.image class="img-fluid w-100 mb-3" :image="$photos[1]">
                                    </x-tenant.system.image>

                                    <div
                                        class="position-absolute bottom-0 mb-3 mr-3 right-0 pb-3 pr-3 d-flex align-items-center">
                                        <span class="d-none d-md-inline-block btn btn-sm btn-light">
                                            {{ svg('heroicon-o-arrows-expand', ['class' => 'ev-icon__xs']) }}
                                            {{ translate('View Photos') }}
                                        </span>
                                    </div>
                                </a>
                                <!-- End Gallery -->

                                <img class="js-fancybox-item d-none" alt="Image Description"
                                    data-src="../assets/img/1920x1080/img24.jpg" data-caption="Front in frames - image #05">
                                <img class="js-fancybox-item d-none" alt="Image Description"
                                    data-src="../assets/img/1920x1080/img20.jpg" data-caption="Front in frames - image #06">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4" id="stickyBlockStartPoint2">
                        <div class="js-sticky-block" data-hs-sticky-block-options='{
                                                                    "parentSelector": "#stickyBlockStartPoint2",
                                                                    "breakpoint": "lg",
                                                                    "startPoint": "#stickyBlockStartPoint2",
                                                                    "endPoint": "#stickyBlockEndPoint2",
                                                                    "stickyOffsetBottom": 20,
                                                                    "stickyOffsetTop": 85
                                                                  }'>

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 d-flex flex-column">
                                            <h2 class="h3">{{ $product->getTranslation('name') }}</h1>

                                                <x-default.products.single.product-brand-box :product="$product">
                                                </x-default.products.single.product-brand-box>
                                        </div>
                                        <div class="col-12 mt-2 mb-2">
                                            <span class="text-dark font-weight-bold">
                                                <div>
                                                    {{ translate('Price:') }}

                                                </div>
                                                @if (home_base_price($product->id) != home_discounted_base_price($product->id))
                                                    <del
                                                        class="h3 fw-600 opacity-50 mr-1">{{ home_base_price($product->id) }}</del>
                                                @endif
                                                <span
                                                    class="h2 fw-700 text-primary">{{ home_discounted_base_price($product->id) }}</span>
                                            </span>

                                        </div>

                                        <div class="col-12">
                                            <?php echo $product->getTranslation('short_description'); ?>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-8">
                                                    <a class="btn btn btn-primary d-flex justify-content-center align-items-center">
                                                        {{ svg('heroicon-o-shopping-cart', ['class' => 'ev-icon__xs mr-2']) }}
                                                        {{ translate('Add To Cart') }}</a>

                                                </div>
                                                <div class="col-4">
                                                    <a class="btn btn-secondary align-items-center d-flex justify-content-center align-items-center">
                                                        {{ svg('heroicon-o-heart', ['class' => 'ev-icon__xs mr-2']) }}
                                                        Like
                                                    </a>
                                                </div>
                                            </div>



                                            <a
                                                class="btn btn-sm d-flex mt-3 btn-dark justify-content-center text-center align-items-center">
                                                {{ svg('heroicon-o-key', ['class' => 'ev-icon__xs mr-2']) }}
                                                {{ translate('Join GunOB') }}

                                            </a>
                                            <div class="text-center">
                                                <small>{{ translate('Gun Enthusiast Marketplace and social network') }}</small>
                                                <br>
                                            </div>
                                            <div class="text-center mt-3 d-flex align-items-center justify-content-center">
                                                <div class="badge badge-soft-success mr-2 w-auto d-flex align-items-center">
                                                    {{ svg('heroicon-o-shield-check', ['class' => 'ev-icon__xs text-success mr-2']) }}

                                                    {{ translate('GunOB Buyers Protection + Escrow') }}
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                </div>

            </div>

            @push('footer_scripts')

                <script src="{{ static_asset('vendor/hs-sticky-block/dist/hs-sticky-block.min.js', false, true) }}"></script>
                <!-- JS Plugins Init. -->
                <script>
                    $(function() {

                        // INITIALIZATION OF STICKY BLOCK
                        $('.js-sticky-block').each(function() {
                            var stickyBlock = new HSStickyBlock($(this)).init();
                        });

                    });
                </script>

            @endpush
            {{-- <x-default.products.single.product-sticky-bar :product="$product">
    </x-default.products.single.product-sticky-bar> --}}




            <div class="container">
                <div class="row">
                    <div class="col-lg-8 bg-white rounded card">
                        <x-default.products.single.product-details-tabs :product="$product">
                        </x-default.products.single.product-details-tabs>
                    </div>
                </div>
            </div>

            <div id="stickyBlockEndPoint2"></div>


            {{-- @include('frontend.components.benefits') --}}


            <section class="mt-3">
                @php
                    //$relatedProducts = filter_products(\App\Models\Product::where('category_id', $product->category_id)->where('id', '!=', $product->id))->limit(10)->get();
                    $relatedProducts = null;
                @endphp

                <x-default.products.product-list :products="$relatedProducts" class="products-slider" slider="true">
                </x-default.products.product-list>
            </section>


            {{-- Put all refactored product page parts inside here --}}
            <section class="" id="productMainWrapper">
                @php
                    $product = $detailedProduct;
                @endphp
                {{-- <x-default.products.single.product-details :product="$product"></x-default.products.single.product-details> --}}
            </section>


            <section class="mb-4 d-none">
                <div class="container">
                    <div class="row gutters-10">
                        <div class="col-xl-3 order-1 order-xl-0">
                            <div class="bg-white shadow-sm mb-3 card">
                                <div class="position-relative p-3 text-left">
                                    @if ($detailedProduct->added_by == 'seller' && get_setting('vendor_system_activation') == 1 && $detailedProduct->user->seller->verification_status == 1)
                                        <div class="absolute-top-right p-2 bg-white z-1">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve"
                                                viewBox="0 0 287.5 442.2" width="22" height="34">
                                                <polygon style="fill:#F8B517;"
                                                    points="223.4,442.2 143.8,376.7 64.1,442.2 64.1,215.3 223.4,215.3 " />
                                                <circle style="fill:#FBD303;" cx="143.8" cy="143.8" r="143.8" />
                                                <circle style="fill:#F8B517;" cx="143.8" cy="143.8" r="93.6" />
                                                <polygon style="fill:#FCFCFD;"
                                                    points="143.8,55.9 163.4,116.6 227.5,116.6 175.6,154.3 195.6,215.3 143.8,177.7 91.9,215.3 111.9,154.3
                                                                                                                                    60,116.6 124.1,116.6 " />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="opacity-50 fs-12 border-bottom">{{ translate('Sold By') }}</div>
                                    @if ($detailedProduct->added_by == 'seller' && get_setting('vendor_system_activation') == 1)
                                        <a href="{{ route('shop.visit', $detailedProduct->user->shop->slug) }}"
                                            class="text-reset d-block fw-600">
                                            {{ $detailedProduct->user->shop->name }}
                                            @if ($detailedProduct->user->seller->verification_status == 1)
                                                <span class="ml-2"><i class="fa fa-check-circle"
                                                        style="color:green"></i></span>
                                            @else
                                                <span class="ml-2"><i class="fa fa-times-circle"
                                                        style="color:red"></i></span>
                                            @endif
                                        </a>
                                        <div class="location opacity-70">{{ $detailedProduct->user->shop->address }}
                                        </div>
                                    @else
                                        <div class="fw-600">{{ env('APP_NAME') }}</div>
                                    @endif
                                    @php
                                        $total = 0;
                                        $rating = 0;
                                        // foreach ($detailedProduct->user->products as $key => $seller_product) {
                                        //    $total += $seller_product->reviews->count();
                                        //    $rating += $seller_product->reviews->sum('rating');
                                        //}
                                    @endphp

                                    <div class="text-center border rounded p-2 mt-3">
                                        <div class="rating">
                                            @if ($total > 0)
                                                {{ renderStarRating($rating / $total) }}
                                            @else
                                                {{ renderStarRating(0) }}
                                            @endif
                                        </div>
                                        <div class="opacity-60 fs-12">({{ $total }}
                                            {{ translate('customer reviews') }})
                                        </div>
                                    </div>
                                </div>
                                @if ($detailedProduct->added_by == 'seller' && get_setting('vendor_system_activation') == 1)
                                    <div class="row no-gutters align-items-center border-top">
                                        <div class="col">
                                            <a href="{{ route('shop.visit', $detailedProduct->user->shop->slug) }}"
                                                class="d-block btn btn-soft-primary rounded-0">{{ translate('Visit Store') }}</a>
                                        </div>
                                        <div class="col">
                                            <ul class="social list-inline mb-0">
                                                <li class="list-inline-item mr-0">
                                                    <a href="{{ $detailedProduct->user->shop->facebook }}"
                                                        class="facebook" target="_blank">
                                                        <i class="lab la-facebook-f opacity-60"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item mr-0">
                                                    <a href="{{ $detailedProduct->user->shop->google }}"
                                                        class="google" target="_blank">
                                                        <i class="lab la-google opacity-60"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item mr-0">
                                                    <a href="{{ $detailedProduct->user->shop->twitter }}"
                                                        class="twitter" target="_blank">
                                                        <i class="lab la-twitter opacity-60"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ $detailedProduct->user->shop->youtube }}"
                                                        class="youtube" target="_blank">
                                                        <i class="lab la-youtube opacity-60"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="bg-white rounded shadow-sm mb-3 ">
                                <div class="p-3 border-bottom font-weight-bold section-title position-relative">
                                    {{ translate('Top Selling Products') }}
                                </div>

                                <div class="p-3">
                                    @php
                                        /* TODO: Move this logic and this whole component to separate blade component logic */
                                        $top_products = filter_products(\App\Models\Product::where('user_id', $detailedProduct->user_id)->orderBy('num_of_sale', 'desc'))
                                            ->limit(6)
                                            ->get();
                                    @endphp
                                    <section>
                                        <section class="space-1">
                                            <x-default.products.product-list style="top-products-slider" slider="true">
                                            </x-default.products.product-list>
                                        </section>
                                    </section>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 order-0 order-xl-1">
                            <div class="bg-white mb-3 shadow-sm rounded">
                                <div class="nav border-bottom aiz-nav-tabs">
                                    <a href="#tab_product_details" data-toggle="tab"
                                        class="p-3 fs-16 fw-600 text-reset active show">{{ translate('Product Specification') }}</a>
                                    <a href="#tab_default_1" data-toggle="tab"
                                        class="p-3 fs-16 fw-600 text-reset">{{ translate('Description') }}</a>
                                    @if ($detailedProduct->video_link != null)
                                        <a href="#tab_default_2" data-toggle="tab"
                                            class="p-3 fs-16 fw-600 text-reset">{{ translate('Video') }}</a>
                                    @endif
                                    @if ($detailedProduct->pdf != null)
                                        <a href="#tab_default_3" data-toggle="tab"
                                            class="p-3 fs-16 fw-600 text-reset">{{ translate('Downloads') }}</a>
                                    @endif
                                    <a href="#tab_default_4" data-toggle="tab"
                                        class="p-3 fs-16 fw-600 text-reset">{{ translate('Reviews') }}</a>
                                </div>

                                <div class="tab-content pt-0">

                                    <div class="tab-pane fade active show" id="tab_product_details">
                                        <div class="p-4">
                                            <div class="mw-100 overflow-hidden text-left">
                                                <x-default.products.single.product-specification-table :product="$product">
                                                </x-default.products.single.product-specification-table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="tab_default_1">
                                        <div class="p-4">
                                            <div class="mw-100 overflow-hidden text-left">
                                                <?php echo $detailedProduct->getTranslation('description'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="tab_default_2">
                                        <div class="p-4">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                @if ($detailedProduct->video_provider == 'youtube' && isset(explode('=', $detailedProduct->video_link)[1]))
                                                    <iframe class="embed-responsive-item"
                                                        src="https://www.youtube.com/embed/{{ explode('=', $detailedProduct->video_link)[1] }}"></iframe>
                                                @elseif ($detailedProduct->video_provider == 'dailymotion' &&
                                                    isset(explode('video/', $detailedProduct->video_link)[1]))
                                                    <iframe class="embed-responsive-item"
                                                        src="https://www.dailymotion.com/embed/video/{{ explode('video/', $detailedProduct->video_link)[1] }}"></iframe>
                                                @elseif ($detailedProduct->video_provider == 'vimeo' &&
                                                    isset(explode('vimeo.com/', $detailedProduct->video_link)[1]))
                                                    <iframe
                                                        src="https://player.vimeo.com/video/{{ explode('vimeo.com/', $detailedProduct->video_link)[1] }}"
                                                        width="500" height="281" frameborder="0" webkitallowfullscreen
                                                        mozallowfullscreen allowfullscreen></iframe>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab_default_3">
                                        <div class="p-4 text-center ">
                                            <a href="{{ uploaded_asset($detailedProduct->pdf) }}"
                                                class="btn btn-primary">{{ translate('Download') }}</a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab_default_4">
                                        <div class="p-4">
                                            <ul class="list-group list-group-flush">
                                                {{-- @foreach ($detailedProduct->reviews as $key => $review)
                                            @if ($review->user != null)
                                            <li class="media list-group-item d-flex">
                                                <span class="avatar avatar-md mr-3">
                                                    <img
                                                        class="lazyload"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                        @if ($review->user->avatar_original != null)
                                                            data-src="{{ uploaded_asset($review->user->avatar_original) }}"
                                                        @else
                                                            data-src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        @endif
                                                    >
                                                </span>
                                                <div class="media-body text-left">
                                                    <div class="d-flex justify-content-between">
                                                        <h3 class="fs-15 fw-600 mb-0">{{ $review->user->name }}</h3>
                                                        <span class="rating rating-sm">
                                                            @for ($i = 0; $i < $review->rating; $i++)
                                                                <i class="las la-star active"></i>
                                                            @endfor
                                                            @for ($i = 0; $i < 5 - $review->rating; $i++)
                                                                <i class="las la-star"></i>
                                                            @endfor
                                                        </span>
                                                    </div>
                                                    <div class="opacity-60 mb-2">{{ date('d-m-Y', strtotime($review->created_at)) }}</div>
                                                    <p class="comment-text">
                                                        {{ $review->comment }}
                                                    </p>
                                                </div>
                                            </li>
                                            @endif
                                        @endforeach --}}
                                            </ul>

                                            {{-- @if (count($detailedProduct->reviews) <= 0)
                                        <div class="text-center fs-18 opacity-70">
                                            {{  translate('There have been no reviews for this product yet.') }}
                                        </div>
                                    @endif --}}

                                            @if (Auth::check())
                                                @php
                                                    $commentable = false;
                                                @endphp
                                                @foreach ($detailedProduct->orderDetails as $key => $orderDetail)
                                                    @if ($orderDetail->order != null &&
        $orderDetail->order->user_id == auth()->user()->id &&
        $orderDetail->delivery_status == 'delivered' &&
        \App\Models\Review::where('user_id', auth()->user()->id)->where('product_id', $detailedProduct->id)->first() == null)
                                                        @php
                                                            $commentable = true;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if ($commentable)
                                                    <div class="pt-4">
                                                        <div class="border-bottom mb-4">
                                                            <h3 class="fs-17 fw-600">
                                                                {{ translate('Write a review') }}
                                                            </h3>
                                                        </div>
                                                        <form class="form-default" role="form"
                                                            action="{{ route('reviews.store') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $detailedProduct->id }}">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for=""
                                                                            class="text-uppercase c-gray-light">{{ translate('Your name') }}</label>
                                                                        <input type="text" name="name"
                                                                            value="{{ auth()->user()->name }}"
                                                                            class="form-control" disabled required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for=""
                                                                            class="text-uppercase c-gray-light">{{ translate('Email') }}</label>
                                                                        <input type="text" name="email"
                                                                            value="{{ auth()->user()->email }}"
                                                                            class="form-control" required disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label
                                                                    class="opacity-60">{{ translate('Rating') }}</label>
                                                                <div class="rating rating-input">
                                                                    <label>
                                                                        <input type="radio" name="rating" value="1">
                                                                        <i class="las la-star"></i>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="rating" value="2">
                                                                        <i class="las la-star"></i>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="rating" value="3">
                                                                        <i class="las la-star"></i>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="rating" value="4">
                                                                        <i class="las la-star"></i>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="rating" value="5">
                                                                        <i class="las la-star"></i>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label
                                                                    class="opacity-60">{{ translate('Comment') }}</label>
                                                                <textarea class="form-control" rows="4" name="comment"
                                                                    placeholder="{{ translate('Your review') }}"
                                                                    required></textarea>
                                                            </div>

                                                            <div class="text-right">
                                                                <button type="submit" class="btn btn-primary mt-3">
                                                                    {{ translate('Submit review') }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="bg-white rounded shadow-sm">
                                <div class="border-bottom p-3">
                                    <h3 class="fs-16 fw-600 mb-0">
                                        <span class="mr-4">{{ translate('Related products') }}</span>
                                    </h3>



                                </div>
                                <div class="p-3">
                                    <section>
                                        @php
                                            //$relatedProducts = filter_products(\App\Models\Product::where('category_id', $product->category_id)->where('id', '!=', $product->id))->limit(10)->get();
                                            $relatedProducts = null;
                                        @endphp

                                        <x-default.products.product-list :products="$relatedProducts"
                                            class="products-slider" slider="true">
                                        </x-default.products.product-list>
                                    </section>
                                    <div class="aiz-carousel gutters-5 half-outside-arrow" data-items="5" data-xl-items="3"
                                        data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2"
                                        data-arrows='true' data-infinite='true'>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        @endsection

        @section('modal')
            <div class="modal fade" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size"
                    role="document">
                    <div class="modal-content position-relative">
                        <div class="modal-header">
                            <h5 class="modal-title fw-600 h5">{{ translate('Any query about this product') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="___class_+?114___" action="{{ route('conversations.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                            <div class="modal-body gry-bg px-3 pt-3">
                                <div class="form-group">
                                    <input type="text" class="form-control mb-3" name="title"
                                        value="{{ $detailedProduct->name }}"
                                        placeholder="{{ translate('Product Name') }}" required>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" rows="8" name="message" required
                                        placeholder="{{ translate('Your Question') }}">{{ route('product', $detailedProduct->slug) }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-primary fw-600"
                                    data-dismiss="modal">{{ translate('Cancel') }}</button>
                                <button type="submit" class="btn btn-primary fw-600">{{ translate('Send') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-zoom" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title fw-600">{{ translate('Login') }}</h6>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="p-3">
                                <form class="form-default" role="form" action="{{ route('cart.login.submit') }}"
                                    method="POST">
                                    @csrf
                                    <div class="form-group">
                                        @if (\App\Models\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Models\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                            <input type="text"
                                                class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                value="{{ old('email') }}"
                                                placeholder="{{ translate('Email Or Phone') }}" name="email" id="email">
                                        @else
                                            <input type="email"
                                                class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                value="{{ old('email') }}" placeholder="{{ translate('Email') }}"
                                                name="email">
                                        @endif
                                        @if (\App\Models\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Models\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                            <span
                                                class="opacity-60">{{ translate('Use country code before number') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control h-auto form-control-lg"
                                            placeholder="{{ translate('Password') }}">
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label class="aiz-checkbox">
                                                <input type="checkbox" name="remember"
                                                    {{ old('remember') ? 'checked' : '' }}>
                                                <span class=opacity-60>{{ translate('Remember Me') }}</span>
                                                <span class="aiz-square-check"></span>
                                            </label>
                                        </div>
                                        <div class="col-6 text-right">
                                            <a href="{{ route('password.request') }}"
                                                class="text-reset opacity-60 fs-14">{{ translate('Forgot password?') }}</a>
                                        </div>
                                    </div>

                                    <div class="mb-5">
                                        <button type="submit"
                                            class="btn btn-primary btn-block fw-600">{{ translate('Login') }}</button>
                                    </div>
                                </form>

                                <div class="text-center mb-3">
                                    <p class="text-muted mb-0">{{ translate('Dont have an account?') }}</p>
                                    <a href="{{ route('user.registration') }}">{{ translate('Register Now') }}</a>
                                </div>
                                @if (get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1)
                                    <div class="separator mb-3">
                                        <span class="bg-white px-3 opacity-60">{{ translate('Or Login With') }}</span>
                                    </div>
                                    <ul class="list-inline social colored text-center mb-5">
                                        @if (get_setting('facebook_login') == 1)
                                            <li class="list-inline-item">
                                                <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
                                                    class="facebook">
                                                    <i class="lab la-facebook-f"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if (get_setting('google_login') == 1)
                                            <li class="list-inline-item">
                                                <a href="{{ route('social.login', ['provider' => 'google']) }}"
                                                    class="google">
                                                    <i class="lab la-google"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if (get_setting('twitter_login') == 1)
                                            <li class="list-inline-item">
                                                <a href="{{ route('social.login', ['provider' => 'twitter']) }}"
                                                    class="twitter">
                                                    <i class="lab la-twitter"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection

        @section('script')
            <script type="text/javascript">
                $(document).ready(function() {
                    getVariantPrice();
                });

                function CopyToClipboard(e) {
                    var url = $(e).data('url');
                    var $temp = $("<input>");
                    $("body").append($temp);
                    $temp.val(url).select();
                    try {
                        document.execCommand("copy");
                        AIZ.plugins.notify('success', '{{ translate('Link copied to clipboard') }}');
                    } catch (err) {
                        AIZ.plugins.notify('danger', '{{ translate('Oops, unable to copy') }}');
                    }
                    $temp.remove();
                    // if (document.selection) {
                    //     var range = document.body.createTextRange();
                    //     range.moveToElementText(document.getElementById(containerid));
                    //     range.select().createTextRange();
                    //     document.execCommand("Copy");

                    // } else if (window.getSelection) {
                    //     var range = document.createRange();
                    //     document.getElementById(containerid).style.display = "block";
                    //     range.selectNode(document.getElementById(containerid));
                    //     window.getSelection().addRange(range);
                    //     document.execCommand("Copy");
                    //     document.getElementById(containerid).style.display = "none";

                    // }
                    // AIZ.plugins.notify('success', 'Copied');
                }

                function show_chat_modal() {
                    @if (Auth::check())
                        $('#chat_modal').modal('show');
                    @else
                        $('#login_modal').modal('show');
                    @endif
                }
            </script>
        @endsection
