<div id="fancyboxGallery" class="js-fancybox" data-hs-fancybox-options="{
    'selector': '#fancyboxGallery .js-fancybox-item'
}">
    <div id="product-gallery-hero" class="bg-dark">
        <div class="container">
            <div class="row ">
                <div class="col-md-8 rounded-lg pl-sm-0 position-relative mb-3 mb-sm-0"
                    style="height: 400px; overflow: hidden;">
                    <div class="row ">
                        <div class="col-sm-12 px-sm-1 bg-white">
                            <iframe title="Carlsberg beer bottle VR ready" width="800px" height="600px"
                                style="min-height: 600px;" style="background:white;" frameborder="0" allowfullscreen
                                mozallowfullscreen="true" webkitallowfullscreen="true"
                                allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking
                                execution-while-out-of-viewport execution-while-not-rendered web-share
                                src="https://sketchfab.com/models/56ecb3b7f8034167a411b694458b3df3/embed?autostart=1&transparent=1&ui_infos=0&ui_watermark_link=0&ui_watermark=0&ui_help=0&ui_theme=dark">
                            </iframe>
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
                                                    "stickyOffsetTop": 20
                                                  }'>

                        <x-default.products.single.product-checkout-card :product="$product">
                        </x-default.products.single.product-checkout-card>
                    </div>
                    <!-- End Row -->
                </div>
            </div>
        </div>


    </div>


    @endpush
