{{-- TODO: Fix sticky bar behaviour , maybe it's not necessary must use the sticky thing, but would be nice
docs: https://htmlstream.com/front/documentation/sticky-block.html
--}}

<div class=" bg-dark c-product-sticky-bar d-sm-none" id="product-sticky-block">
  <div class="container py-3">
      <div class="row align-items-center
      ">
          <div class="col-7 text-white align-items-center
          ">
            <h4 class="text-white">{{ $product->getTranslation('name') }}</h4>
          </div>
          <div class="col-5 text-right flex-nowrap">
            <a href="#" class="mr-2 text-secondary ">  {{ svg('heroicon-o-heart', ['class' => 'ev-icon__small']) }} </a>
             <a href="#" class="text-primary">
                {{-- TODO: Add price component --}}
                {{ svg('heroicon-o-shopping-cart', ['class' => 'ev-icon__small']) }} </a>

          </div>
      </div>
  </div>
</div>


