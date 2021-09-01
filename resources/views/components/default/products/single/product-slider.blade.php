<!-- Main Slider -->
<div id="heroSlider" class="border rounded-lg">

    <div class="js-slick-carousel slick " data-hs-slick-carousel-options='{
        "fade": true,
        "infinite": true,
        "autoplay": true,
        "autoplaySpeed": 7000,
        "asNavFor": "#heroSliderNav"
        }'>
        @foreach ($photos as $photo)
            <div class="ev-product-image js-slide">
                <x-tenant.system.image class="img-fluid w-100 rounded-lg" :image="$photo">
                </x-tenant.system.image>
            </div>
        @endforeach
    </div>

</div>
<!-- End Main Slider -->

<!-- Slider Nav -->
<div class="position-absolute bottom-0 right-0 left-0 px-4 py-3">
    <div id="heroSliderNav"
        class="js-slick-carousel slick slick-gutters-1 slick-transform-off max-w-27rem mx-auto"
        data-hs-slick-carousel-options='{
            "infinite": true,
            "autoplaySpeed": 7000,
            "slidesToShow": 3,
            "isThumbs": true,
            "isThumbsProgressCircle": true,
            "thumbsProgressOptions": {
              "color": "#377DFF",
              "width": 8
            },
            "thumbsProgressContainer": ".js-slick-thumb-progress",
            "asNavFor": "#heroSlider"
          }'>
        @foreach ($photos as $photo)
            <div class="js-slide p-1">
                <a class="d-block avatar avatar-circle border p-1" href="javascript:;">
                    <x-tenant.system.image class="avatar-img" :image="$photo">
                    </x-tenant.system.image>
                </a>

            </div>

        @endforeach


    </div>
</div>
