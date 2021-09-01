<!-- Main Slider -->
<div class="border rounded-lg">

    <div id="heroSlider"  class="js-slick-carousel slick " data-hs-slick-carousel-options='{
        "prevArrow": "<span class=\"fas fa-arrow-left slick-arrow slick-arrow-primary-white slick-arrow-left slick-arrow-centered-y shadow-soft rounded-circle ml-n3 ml-sm-2 ml-xl-4\"></span>",
        "nextArrow": "<span class=\"fas fa-arrow-right slick-arrow slick-arrow-primary-white slick-arrow-right slick-arrow-centered-y shadow-soft rounded-circle mr-n3 mr-sm-2 mr-xl-4\"></span>",
        "fade": false,
        "infinite": false,
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
    <div id="heroSliderNav" class="js-slick-carousel slick slick-gutters-1 slick-transform-off max-w-27rem mx-auto"
        data-hs-slick-carousel-options='{
            "infinite": false,
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
            <div class="js-slide p-1 d-block avatar avatar-circle border">
                <a class="js-slick-thumb-progress position-relative d-block avatar border rounded-circle p-1" href="javascript:;">
                    <x-tenant.system.image class="avatar-img" :image="$photo">
                    </x-tenant.system.image>
                </a>

            </div>

        @endforeach


    </div>
</div>
