{{-- TODO: Fix sticky bar behaviour , maybe it's not necessary must use the sticky thing, but would be nice
docs: https://htmlstream.com/front/documentation/sticky-block.html
--}}

<div class="js-sticky-block bg-dark" id="product-sticky-block"  data-hs-sticky-block-options='{
    "parentSelector": "body",
    "breakpoint": "lg",
    "startPoint": "#productDetailsContainer",
    "endPoint": "#stickyBlockEndPoint",
    "stickyOffsetBottom": 20
  }'>
  <div class="container py-3">
      <div class="row align-items-center
      ">
          <div class="col-6 text-white align-items-center
          ">
            <h4 class="text-white">{{ $product->getTranslation('name') }}</h4>
          </div>
          <div class="col-6 text-right">
            <a href="#" class="btn btn-secondary">  {{ svg('heroicon-o-heart', ['style' => 'width: 40px;']) }} </a>
             <a href="#" class="btn btn-primary"> {{ translate('Add To Cart') }} </a>

          </div>
      </div>
  </div>
</div>

@push('footer_scripts')
<div id="stickyBlockEndPoint"></div>

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
