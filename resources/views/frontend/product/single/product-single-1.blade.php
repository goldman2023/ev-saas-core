@extends('frontend.layouts.' . $globalLayout)

@section('meta')
<x-default.products.single.head-meta-tags :product="$product"></x-default.products.single.head-meta-tags>
@endsection

@section('content')
<main id="content" role="main">
    <!-- Hero Section -->
    <div class="container space-top-1 space-top-sm-2">
        <div class="row">
            <div class="col-lg-6 mb-7 mb-lg-0">
                <div class="pr-lg-4">
                    <div class="position-relative">
                        <!-- Main Slider -->
                        <x-tenant.system.image class="img-fluid w-100 mb-3"
                            :image="$product->getThumbnail(['w'=>600]) ?? ''">
                        </x-tenant.system.image>

                        <div class="row">
                            @foreach($product->getGallery(['w' => 300]) as $item)
                            <div class="col-4 mb-3">
                                <x-tenant.system.image class="img-fluid" fit="cover" :image="$item ?? ''">
                                </x-tenant.system.image>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Description -->
            <div class="col-lg-6">
                <!-- Rating -->
                <div class="align-items-center small mb-2">
                    <div class="mr-2">
                        @for ($i = 0; $i < 5; $i++) @svg('heroicon-s-star', ["class"=> 'text-success ev-icon__xs'])
                            @endfor
                    </div>
                    <a class="link-underline" href="#reviewSection">
                        Read all 287 reviews
                    </a>
                </div>
                <!-- End Rating -->

                <!-- Title -->
                <div class="mb-5">
                    <h1 class="h2">{{ $product->getTranslation('name') }}</h1>

                    <p>
                        {!! $product->getTranslation('excerpt') !!}
                    </p>
                </div>
                <!-- End Title -->
                <div class="mb-3">
                    <x-default.products.single.product-checkout-card :product="$product">
                    </x-default.products.single.product-checkout-card>
                </div>

                <!-- Accordion -->
                <div id="shopCartAccordion" class="accordion mb-5">
                    <!-- Card -->
                    <div class="card card-bordered shadow-none">
                        <div class="card-body card-collapse" id="shopCardHeadingOne">
                            <a class="btn btn-link btn-block card-btn collapsed" href="javascript:;" role="button"
                                data-toggle="collapse" data-target="#shopCardOne" aria-expanded="false"
                                aria-controls="shopCardOne">
                                <span class="row align-items-center">
                                    <span class="col-9">
                                        <span class="media align-items-center">
                                            <span class="w-100 max-w-6rem mr-3">
                                                <img class="img-fluid" src="/assets/svg/icons/icon-65.svg" alt="SVG">
                                            </span>
                                            <span class="media-body">
                                                <span class="d-block font-size-1 font-weight-bold">
                                                    {{ translate('Shipping') }}
                                                </span>
                                            </span>
                                        </span>
                                    </span>
                                    <span class="col-3 text-right">
                                        <span class="card-btn-toggle">
                                            <span class="card-btn-toggle-default">+</span>
                                            <span class="card-btn-toggle-active">−</span>
                                        </span>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div id="shopCardOne" class="collapse" aria-labelledby="shopCardHeadingOne"
                            data-parent="#shopCartAccordion">
                            <div class="card-body">
                                <p class="small mb-0">We offer free shipping anywhere in the U.S. A skilled delivery
                                    team will bring the boxes into your office.</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div class="card card-bordered shadow-none">
                        <div class="card-body card-collapse" id="shopCardHeadingTwo">
                            <a class="btn btn-link btn-block card-btn collapsed" href="javascript:;" role="button"
                                data-toggle="collapse" data-target="#shopCardTwo" aria-expanded="false"
                                aria-controls="shopCardTwo">
                                <span class="row align-items-center">
                                    <span class="col-9">
                                        <span class="media align-items-center">
                                            <span class="w-100 max-w-6rem mr-3">
                                                <img class="img-fluid" src="/assets/svg/icons/icon-64.svg" alt="SVG">
                                            </span>
                                            <span class="media-body">
                                                <span class="d-block font-size-1 font-weight-bold">
                                                    {{ translate('Returns and buyers protection') }}
                                                </span>
                                            </span>
                                        </span>
                                    </span>
                                    <span class="col-3 text-right">
                                        <span class="card-btn-toggle">
                                            <span class="card-btn-toggle-default">+</span>
                                            <span class="card-btn-toggle-active">−</span>
                                        </span>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div id="shopCardTwo" class="collapse" aria-labelledby="shopCardHeadingTwo"
                            data-parent="#shopCartAccordion">
                            <div class="card-body">
                                <p class="small mb-0">If you're not satisfied, return it for a full refund. We'll take
                                    care of disassembly and return shipping.</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Card -->
                </div>
                <!-- End Accordion -->

                {{-- Views and stats --}}
                <div class="mb-3">
                    <span class="link-underline small">
                        {{ translate('Views: ') }} {{ $product->public_view_count() }}
                    </span>
                </div>
                {{-- End views and stats --}}

                <!-- Help Link -->
                <div class="media align-items-center">
                    <span class="w-100 max-w-6rem mr-2">
                        <img class="img-fluid" src="/assets/svg/icons/icon-4.svg" alt="SVG">
                    </span>
                    <div class="media-body text-body small">
                        <span class="font-weight-bold mr-1">Need Help?</span>
                        <a class="link-underline" href="#">Chat now</a>
                    </div>
                </div>
                <!-- End Help Link -->
            </div>
            <!-- End Product Description -->
        </div>
    </div>
    <!-- End Hero Section -->

    <!-- Product Description Section -->
    <div class="container space-1">
        <div class="row">
            <div class="col-md-6 mb-5 mb-md-0">
                <div class="pr-lg-4">
                    <h4>{{ translate('Details') }}</h4>
                    <p>
                        {!! $product->getTranslation('description') !!}
                    </p>
                </div>
            </div>

            <div class="col-md-6 mb-5 mb-md-0">
                <h4>{{ translate('Product specification') }}</h4>
                <div class="row">
                    <div class="col-12">
                        <x-default.products.single.product-specification-table :product="$product">
                        </x-default.products.single.product-specification-table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Product Description Section -->





    {{-- <x-default.products.reviews></x-default.products.reviews> --}}

    <!-- Related Products Section -->
    <div class="container space-1">
        <!-- Title -->
        <div class="w-md-80 w-lg-40 text-center mx-md-auto mb-5 mb-md-9">
            <h2>Just for you</h2>
        </div>
        <!-- End Title -->

        <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products>
    </div>
    <!-- End Related Products Section -->
</main>
@endsection
