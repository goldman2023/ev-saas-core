<!-- Property Item -->
<div class="border-bottom pb-5 mb-5">
    <div class="row">
        <div id="fancyboxGallery1"
            class="js-fancybox col-md-4 d-md-flex align-items-md-start flex-md-column mb-5 mb-md-0"
            data-hs-fancybox-options='{
             "selector": "#fancyboxGallery1 .js-fancybox-item"
           }'>
            <!-- Gallery -->
            <a class="js-fancybox-item media-viewer mb-3" href="javascript:;"
                data-src="../assets/img/1920x1080/img12.jpg" data-caption="Front in frames - image #01">
                <x-tenant.system.image alt="{{ $product->getTranslation('name') }}" class="img-fluid w-100 rounded-lg"
                    :image="$product->thumbnail_img"></x-tenant.system.image>
                <div class="position-absolute top-0 left-0 p-4">
                    <span class="badge badge-success">New</span>
                </div>

                <div class="position-absolute bottom-0 right-0 pb-2 pr-2">
                    <span class="btn btn-xs btn-icon btn-light">
                        <i class="fas fa-images"></i>
                    </span>
                </div>
            </a>

            <img class="js-fancybox-item d-none" alt="Image Description" data-src="../assets/img/1920x1080/img11.jpg"
                data-caption="Front in frames - image #02">
            <img class="js-fancybox-item d-none" alt="Image Description" data-src="../assets/img/1920x1080/img14.jpg"
                data-caption="Front in frames - image #03">
            <!-- End Gallery -->
        </div>

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-7">
                    <h3 class="mb-1">
                        <a class="text-dark" href="{{ $product->permalink }}">
                            {{ $product->getTranslation('name') }}
                        </a>
                    </h3>
                </div>
                <div class="col-md-5 text-md-right">
                    <h3 class="mb-1">
                        <a href="#">£689,000</a>
                    </h3>
                </div>
            </div>
            <!-- End Row -->

            <!-- Location -->
            <div class="mb-3">
                <a class="font-size-1 text-body d-flex align-items-center" href="#">
                    <span style="width: 30px; display: block;" class="mr-1">
                    @svg('lineawesome-ruler-combined-solid')
                    </span>
                    Nuo 30x10 iki 70x35
                </a>
            </div>
            <!-- End Location -->

            <!-- Icon Blocks -->
            <ul class="list-inline list-separator font-size-1 mb-3">
                <li class="list-inline-item">
                    <i class="fas fa-bed text-muted mr-1"></i> 1
                </li>
                <li class="list-inline-item">
                    <i class="fas fa-bath text-muted mr-1"></i> 1
                </li>
                <li class="list-inline-item">
                    <i class="fas fa-couch text-muted mr-1"></i> 1
                </li>
                <li class="list-inline-item">
                    <i class="fas fa-ruler-combined text-muted mr-1"></i> 1,428 sqft
                </li>
            </ul>
            <!-- End Icon Blocks -->

            <p class="font-size-1">This superb one bedroom flat rests a stones throw from Kennington tube station and
                Elephant and Castle train station as well as the leafy Paisley Park. The large hatch in the kitchen
                opens out to a light and open plan living space, perfect for...</p>

            <div class="row align-items-center">
                <div class="col-lg mb-2 mb-lg-0">
                    <!-- Media -->
                    <div class="media align-items-center mt-auto">
                        <div class="avatar avatar-xs avatar-circle mr-2">
                            <img class="avatar-img" src="../assets/img/100x100/img1.jpg" alt="Image Description"
                                title="Monica Fox">
                        </div>
                        <div class="media-body">
                            <small class="d-block text-muted">Listed on Jan 4, 2019 by</small>
                            <a class="text-dark" href="#">Monica Fox</a>
                        </div>
                    </div>
                    <!-- End Media -->
                </div>

                <div class="col-lg-auto">
                    <!-- Contacts -->
                    <div class="font-size-1">
                        <a class="d-inline-block text-body mb-2 mr-4" href="javascript:;">
                            <i class="fas fa-phone mr-1"></i> (0161) 347 8854
                        </a>
                        <a class="d-inline-block text-body mb-2 mr-4" href="javascript:;">
                            <i class="fas fa-envelope mr-1"></i> Contact
                        </a>
                        <a class="d-inline-block text-body mb-2 mr-4" href="javascript:;">
                            <i class="fas fa-star mr-1"></i> Save
                        </a>
                    </div>
                    <!-- End Contacts -->
                </div>
            </div>
            <!-- End Row -->
        </div>
    </div>
</div>
<!-- End Property Item -->
