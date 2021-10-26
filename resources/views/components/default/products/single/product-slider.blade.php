<div id="fancyboxGallery" class="js-fancybox" data-hs-fancybox-options="{
    'selector': '#fancyboxGallery .js-fancybox-item'
}">
    <div id="product-gallery-hero" class="overflow-hidden bg-dark">
        <div class="container">
            <div class="row ">
                <div class="col-md-8 rounded-lg pl-sm-0 position-relative mb-3 mb-sm-0"
                    style="max-height: 400px; overflow: hidden;">
                    <div class="row ">
                        <div class="col-sm-8 pr-sm-0 position-static">
                            <!-- Gallery -->
                            <a class="js-fancybox-item d-block" href="javascript:;">
                                <x-tenant.system.image class="img-fluid w-100" :image="$photos[0]">
                                </x-tenant.system.image>

                                <div class="position-absolute bottom-0 right-0 pb-3 pr-3">
                                    <span class="d-md-none btn btn-sm btn-light">
                                        {{ svg('heroicon-o-arrows-expand', ['class' => 'ev-icon__xs']) }}
                                        {{ translate('View Photos') }}
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-4 pr-0 d-sm-block d-none position-static">
                            <!-- Gallery -->
                            <x-tenant.system.image class="img-fluid w-100" :image="$photos[1]">
                            </x-tenant.system.image>

                            <!-- End Gallery -->

                            <!-- Gallery -->
                            <a class="js-fancybox-item d-block mt-3" href="javascript:;">
                                <x-tenant.system.image :image="$photos[2]">
                                </x-tenant.system.image>

                                <div
                                    class="position-absolute bottom-0 mr-3 right-0 pb-3 pr-3 d-flex align-items-center">
                                    <span class="d-none d-md-inline-block btn btn-sm btn-light">
                                        {{ svg('heroicon-o-arrows-expand', ['class' => 'ev-icon__xs']) }}
                                        {{ translate('View Photos') }}
                                    </span>
                                </div>
                            </a>
                            <!-- End Gallery -->
                            @foreach($photos as $key => $photo)
                                @if($key > 2)
                                    <x-tenant.system.image class="js-fancybox-item d-none" :image="$photos[1]">
                                    </x-tenant.system.image>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>


                <div class="col-md-4 " id="stickyBlockStartPoint2">
                    <div class="js-sticky-block" data-hs-sticky-block-options='{
                                                    "parentSelector": "#stickyBlockStartPoint2",
                                                    "breakpoint": "lg",
                                                    "startPoint": "#stickyBlockStartPoint2",
                                                    "endPoint": "#stickyBlockEndPoint2",
                                                    "stickyOffsetBottom": 20,
                                                    "stickyOffsetTop": 95
                                                  }'>

                        <x-default.products.single.product-checkout-card :product="$product">
                        </x-default.products.single.product-checkout-card>
                    </div>
                    <!-- End Row -->
                </div>
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
