<!-- Products Section -->
<div class="container space-2">
    <!-- Title -->
    <div class="w-md-80 w-lg-40 text-center mx-md-auto mb-5 mb-md-9">
      <x-ev::label
      tag="h2"
      :label="ev_dynamic_translate('Products List Title', true)">
      </x-ev::label>
    </div>
    <!-- End Title -->

    <!-- Products -->
    <div class="row mx-n2 mx-sm-n3 mb-3">
        <!-- Product -->
        @foreach ($products as $product)
      <div class="col-sm-6 col-lg-3 px-2 px-sm-3 mb-3 mb-sm-5">

        <x-default.products.cards.product-card :product="$product">
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
