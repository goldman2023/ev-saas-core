<div id="fancyboxGallery" class="js-fancybox" data-hs-fancybox-options="{
    'selector': '#fancyboxGallery .js-fancybox-item'
}">
    <div id="product-gallery-hero" class="overflow-hidden bg-dark">
        <div class="container">
            <div class="row ">
                <div class="col-md-8 rounded-lg pl-sm-0 position-relative mb-3 mb-sm-0"
                     style="overflow: hidden;">
                    <div class="row ">
                        <div class="col-sm-8 px-sm-1 position-static">
                            <!-- Gallery -->
                            <a class="js-fancybox-item d-block" href="javascript:;" style="height: 400px;">
                                <x-tenant.system.image class="img-fluid w-100 h-100" fit="cover" :image="$product->getThumbnail(['w'=>600]) ?? ''">
                                </x-tenant.system.image>
                            </a>
                        </div>
                        <div class="col-md-4 d-none d-md-inline-block px-1">
                            <!-- Gallery -->
                            <a class="js-fancybox-item d-block mb-2" href="javascript:;" style="height: 196px;">
                                @foreach($product->getGallery(['w' => 300]) as $item)
                                <x-tenant.system.image class="img-fluid w-100 h-100" fit="cover" :image="$item ?? ''">
                                </x-tenant.system.image>
                                @endforeach
                            </a>
                            <!-- End Gallery -->
                        </div>
                    </div>
                </div>


                <div class="col-md-4 " id="stickyBlockStartPoint2">
                    <div class="js-sticky-block" data-hs-sticky-block-options='{
                                                    "parentSelector": "#stickyBlockStartPoint2",
                                                    "breakpoint": "xl",
                                                    "startPoint": "#stickyBlockStartPoint2",
                                                    "endPoint": "#stickyBlockEndPoint2",
                                                    "stickyOffsetBottom": 20,
                                                    "stickyOffsetTop": 20
                                                  }'>


                    </div>
                    <!-- End Row -->
                </div>
            </div>
        </div>


    </div>

@push('footer_scripts')

@endpush
