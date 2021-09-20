<!-- Hero Section -->

<div class="container space-2">
    <div class="row">
        <div class="col-lg-7 mb-7 mb-lg-0">
            <div class="pr-lg-4">
                <div class="position-relative">
                    <x-default.products.single.product-slider :product="$product">
                    </x-default.products.single.product-slider>
                    <!-- End Slider Nav -->
                </div>
            </div>
        </div>

        <!-- Product Description -->
        <div class="col-lg-5">
            <!-- Rating -->
            <div class="d-flex align-items-center small mb-2">
                <div class="text-warning mr-2">
                    @for ($i = 0; $i < 5; $i++)
                        @svg('heroicon-s-star', ['style' => 'width: 16px;'])
                    @endfor
                </div>
                <a class="link-underline" href="#reviewSection">
                    {{ translate('Read all') }} {{ $product->reviews()->count() }} {{ translate('reviews') }}
                </a>
            </div>
            <!-- End Rating -->

            <!-- Title -->
            <div class="mb-5">
                <h1 class="h2">{{ $product->getTranslation('name') }}</h1>
                <p>
                    {!! $product->short_description !!}
                </p>
            </div>

            <!-- End Title -->
            <div class="product-description mb-3">
                {{ $product->getTranslation('description'); }}
            </div>

            <!-- Price -->
            <div class="mb-5">
                <h2 class="font-size-1 text-body mb-0">{{ translate('Price:') }}</h2>

                <span class="text-dark font-size-2 font-weight-bold">
                    {{ home_discounted_price($product->id) }}
                    @if ($product->unit != null)
                        <span class="opacity-70">/
                            {{ $product->getTranslation('unit') }}
                        </span>
                    @endif
                </span>
                @if (home_price($product->id) != home_discounted_price($product->id))
                    <span class="text-body ml-2"><del>{{ home_price($product->id) }}</del></span>
                @endif
            </div>
            <!-- End Price -->

            {{-- Brand --}}
            <div class="mb-5">
                <div class="row">
                    <div class="col-sm-6">
                        <small class="mr-2 opacity-50">{{ translate('Sold by') }}: </small><br>
                        @if ($product->added_by == 'seller' && get_setting('vendor_system_activation') == 1)
                            <a href="{{ route('shop.visit', $product->user->shop->slug) }}" class="text-reset">
                                {{ $product->user->shop->name }}
                            </a>
                        @else
                            {{-- {{ translate('Inhouse product') }} --}}
                            {{ get_site_name() }}
                            <br>
                        @endif

                        @if (get_setting('conversation_system') == 1)
                            <button class="mt-2 btn btn-sm btn-soft-primary" onclick="show_chat_modal()">
                                {{ translate('Message Seller') }}
                            </button>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <small class="mr-2 opacity-50">{{ translate('Manufacturer:') }} </small><br>

                        @if ($product->brand != null)
                            <a href="{{ route('products.brand', $product->brand->slug) }}">
                                <img class="mt-3" src="{{ uploaded_asset($product->brand->logo ?? '') }}"
                                    alt="{{ $product->brand->getTranslation('name') }}" height="60">
                            </a>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Seller Info --}}
            <div class="mb-5">

            </div>

            {{-- End Seller Info --}}
            {{-- End Brand --}}

            <!-- Quantity -->
            <div class="border rounded-lg py-2 px-3 mb-3">
                <div class="js-quantity-counter row align-items-center">
                    <div class="col-7">
                        <small class="d-block text-body font-weight-bold">
                            {{ translate('Select quantity') }}
                        </small>
                        <input class="js-result form-control h-auto border-0 rounded-lg p-0" type="text" value="1">
                    </div>
                    <div class="col-5 text-right">
                        <a class="js-minus btn btn-xs btn-icon btn-outline-secondary rounded-circle"
                            href="javascript:;">
                            <span class="card-btn-toggle-active">+</span>
                        </a>
                        <a class="js-plus btn btn-xs btn-icon btn-outline-secondary rounded-circle" href="javascript:;">
                            <i class="la la-plus"></i>
                            <span class="card-btn-toggle-active">−</span>

                        </a>
                    </div>
                </div>
            </div>
            <!-- End Quantity -->

            <!-- Accordion -->
            <x-default.products.single.product-benefits> </x-default.products.single.product-benefits>
            <!-- End Accordion -->

            <div class="mb-4">
                <button type="button"
                onClick="buyNow()"
                class="btn btn-block btn-primary btn-pill transition-3d-hover">

                    Add to
                    Cart</button>
            </div>

            <form id="option-choice-form">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">

                <!-- Quantity + Add to cart -->
                @if($product->digital !=1)
                    @if ($product->choice_options)
                        @foreach ($product->choice_options as $key => $choice)

                            <div class="row no-gutters">
                                <div class="col-2">
                                    <div class="opacity-50 mt-2 ">{{ \App\Models\Attribute::find($choice->attribute_id)->getTranslation('name') }}:</div>
                                </div>
                                <div class="col-10">
                                    <div class="aiz-radio-inline">
                                        @foreach ($choice->values as $key => $value)
                                        <label class="aiz-megabox pl-0 mr-2">
                                            <input
                                                type="radio"
                                                name="attribute_id_{{ $choice->attribute_id }}"
                                                value="{{ $value }}"
                                                @if($key == 0) checked @endif
                                            >
                                            <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center py-2 px-3 mb-2">
                                                {{ $value }}
                                            </span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    @endif

                    @if (count($product->colors) > 0)
                        <div class="row no-gutters">
                            <div class="col-2">
                                <div class="opacity-50 mt-2">{{ translate('Color')}}:</div>
                            </div>
                            <div class="col-10">
                                <div class="aiz-radio-inline">
                                    @if($product->colors)
                                        @foreach ($product->colors as $key => $color)
                                            <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip" data-title="{{ \App\Models\Color::where('code', $color)->first()->name }}">
                                                <input
                                                    type="radio"
                                                    name="color"
                                                    value="{{ \App\Models\Color::where('code', $color)->first()->name }}"
                                                    @if($key == 0) checked @endif
                                                >
                                                <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                            <span class="size-30px d-inline-block rounded" style="background: {{ $color }};"></span>
                                        </span>
                                            </label>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <hr>
                    @endif

                    <div class="row no-gutters">
                        <div class="col-2">
                            <div class="opacity-50 mt-2">{{ translate('Quantity')}}:</div>
                        </div>
                        <div class="col-10">
                            <div class="product-quantity d-flex align-items-center">
                                <div class="row no-gutters align-items-center aiz-plus-minus mr-3" style="width: 130px;">
                                    <button class="btn col-auto btn-icon btn-sm btn-circle btn-light" type="button" data-type="minus" data-field="quantity" disabled="">
                                        <i class="las la-minus"></i>
                                    </button>
                                    <input type="text" name="quantity" class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1" value="{{ $product->min_qty }}" min="{{ $product->min_qty }}" max="10" readonly>
                                    <button class="btn  col-auto btn-icon btn-sm btn-circle btn-light" type="button" data-type="plus" data-field="quantity">
                                        <i class="las la-plus"></i>
                                    </button>
                                </div>
                                @if($product->stock_visibility_state != 'hide')
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr>
                @endif

                <div class="row no-gutters pb-3 d-none" id="chosen_price_div">
                    <div class="col-2">
                        <div class="opacity-50">{{ translate('Total Price')}}:</div>
                    </div>
                    <div class="col-10">
                        <div class="product-price">
                            <strong id="chosen_price" class="h4 fw-600 text-primary">

                            </strong>
                        </div>
                    </div>
                </div>

            </form>

            <!-- Help Link -->
            <div class="media align-items-center">
                <span class="w-100 max-w-6rem mr-2">
                    <img class="img-fluid" src="https://htmlstream.com/front/assets/svg/icons/icon-4.svg"
                        alt="SVG">
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

@push('footer_scripts')


    <!-- JS Plugins Init. -->
    <script>
        $(function() {
            // INITIALIZATION OF QUANTITY COUNTER
            // =======================================================
            $('.js-quantity-counter').each(function() {
                // var quantityCounter = new HSQuantityCounter($(this)).init();
            });
        });
    </script>
@endpush
