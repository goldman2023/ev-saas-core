<!-- Products Section -->
<div class="container space-2">
    <!-- Title -->
    <div class="w-md-80 w-lg-40 text-center mx-md-auto mb-5 mb-md-9">
        <x-ev::label tag="h2" :label="ev_dynamic_translate('Products List Title', true)">
        </x-ev::label>
    </div>
    <!-- End Title -->

    <!-- Products -->
    <div class="row d-block mx-n2 mx-sm-n3 mb-3 @if ($slider) ev-slick @endif">
        <!-- Product -->
        @foreach ($products as $product)
            <div class="col-md-4 px-2 px-sm-3 mb-3 mb-sm-5">
                <x-default.products.cards.product-card :product="$product" style="product-card">
                </x-default.products.cards.product-card>
            </div>
        @endforeach
        <!-- End Product -->

    </div>
    <!-- End Products -->

    <div class="text-center">
        <a class="btn btn-primary btn-pill transition-3d-hover px-5" href="#">
            {{ translate('View Products') }}
        </a>
    </div>
</div>
<!-- End Products Section -->

@push('footer_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" rel="stylesheet" />
    <script>
        $(document).ready(function() {
            $('.ev-slick').slick({
                infinite: false,
                slidesToShow: 3,
                slidesToScroll: 1,
                arrows: true,
                responsive: [{
                    breakpoint: 1024,
                    settings: {
                        centerMode: true,
                        centerPadding: '60px',
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                }],
            });
        });
    </script>
@endpush
