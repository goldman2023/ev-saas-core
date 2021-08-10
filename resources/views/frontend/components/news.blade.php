<div class="container space-top-2 space-top-lg-1">
    <!-- Title -->
    <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mb-md-5">
        <h2 class="h1">
            {{ translate('Latest wood industry news')  }}
        </h2>
        <p>We've helped some great companies brand, design and get to market.</p>
    </div>
    <!-- End Title -->

    <div class="row mx-n2 mb-5 mb-md-9">
        @for($i = 0; $i < 4; $i++)
        <div class="col-sm-6 col-lg-3 px-2 mb-3 mb-lg-0">
            <!-- Card -->
            <a class="card h-100 transition-3d-hover" href="#">
                <img class="card-img-top" src="https://www.timberindustrynews.com/wp-content/uploads/2018/05/Holzindustrie-Schweighofer-timber-310x220.jpg" alt="Image Description">
                <div class="card-body">
                    <span class="d-block small font-weight-bold text-cap mb-2 text-success">Sawmills</span>
                    <h5 class="mb-0">European countries are rapidly expanding market shares on China’s softwood import market</h5>
                </div>
            </a>
            <!-- End Card -->
        </div>
        @endfor

    </div>

    <!-- Info -->
    <div class="position-relative z-index-2 text-center">
        <div class="d-inline-block font-size-1 border bg-white text-center rounded-pill py-3 px-4">
            Want to read more? <a class="font-weight-bold ml-3" href="/blog/">Go here <span class="fas fa-angle-right ml-1"></span></a>
        </div>
    </div>
    <!-- End Info -->
</div>
