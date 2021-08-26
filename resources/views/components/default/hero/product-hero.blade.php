<style>
    .hero-v1 {
        position: absolute;
        top: 0;
        right: 0;
        width: 40%;
        height: 100%;
        z-index: 1;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: top center;
    }

</style>

<div class="position-relative">
    <div class="container space-lg-3 position-relative z-index-2">
        <div class="row align-items-center">
            <div class="col-12 col-lg-9 mb-7 mb-md-0">
                <div class="w-md-60 mb-7">
                    <x-ev.label tag="h2" class="h1" :label="ev_dynamic_translate('Product Heading')">
                    </x-ev.label>

                    <p>
                        <x-ev.label :label="ev_dynamic_translate('Product Description')">
                        </x-ev.label>

                    </p>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <!-- Card -->
                        <div class="card h-100">
                            <div class="card-body">
                                <figure class="max-w-8rem mb-3">
                                    <img class="img-fluid"
                                        src="https://htmlstream.com/front/assets/svg/icons/icon-13.svg" alt="SVG">
                                </figure>
                                <h4>Find homes for sale</h4>
                                <p>Over 1 million+ homes for sale available on the website.</p>
                                <a href="#">Properties for sale <i class="fas fa-angle-right align-middle ml-1"></i></a>
                            </div>
                        </div>
                        <!-- End Card -->
                    </div>

                    <div class="col-md-4 mb-3 mb-md-0">
                        <!-- Card -->
                        <div class="card h-100">
                            <div class="card-body">
                                <figure class="max-w-8rem mb-3">
                                    <img class="img-fluid"
                                        src="https://htmlstream.com/front/assets/svg/icons/icon-1.svg" alt="SVG">
                                </figure>
                                <h4>Find rental properties</h4>
                                <p>Fina a home or apartment with 35+ filters and custom keyword search.</p>
                                <a href="#">Properties for rent <i class="fas fa-angle-right align-middle ml-1"></i></a>
                            </div>
                        </div>
                        <!-- End Card -->
                    </div>

                    <div class="col-md-4">
                        <!-- Card -->
                        <div class="card h-100">
                            <div class="card-body">
                                <figure class="max-w-8rem mb-3">
                                    <img class="img-fluid"
                                        src="https://htmlstream.com/front/assets/svg/icons/icon-31.svg" alt="SVG">
                                </figure>
                                <h4>Sell properties</h4>
                                <p>Wanting to find a sold property price or see what sold on the weekend?</p>
                                <a href="#">Sell properties <i class="fas fa-angle-right align-middle ml-1"></i></a>
                            </div>
                        </div>
                        <!-- End Card -->
                    </div>
                </div>
                <!-- End Row -->
            </div>
        </div>
        <!-- End Row -->
    </div>

    <div class="hero-v1 d-none d-md-block"
        style="background-image: url(https://www.montanstahl.com/wp-content/uploads/2018/01/Assy1.jpg);"></div>
</div>
