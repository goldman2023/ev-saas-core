<div class="row">
    <!-- Category List With Left Tabs -->
    <div class="col-lg-4 mb-7 mb-lg-0">
      <!-- Nav -->
      <ul class="nav nav-box" role="tablist">
        @foreach ($categories as $key => $category)
        <li class="nav-item w-100 mx-0 mb-3">
          <a class="nav-link p-4 @if($key === 0) show active @endif" id="category-tabs-{{ $key }}-tab" data-toggle="pill" href="#category-tabs-{{ $key }}" role="tab">
            <div class="media align-items-center align-items-lg-start">
              <figure class="w-100 max-w-6rem mt-2 mr-4">
                <x-tenant.system.image class="img-fluid" :image="$category->icon">
                </x-tenant.system.image>
              </figure>
              <div class="media-body">
                <h4 class="mb-0">
                    {{ $category->name }}
                </h4>
                <div class="d-none d-lg-block mt-2">
                  <p class="text-body mb-0">{{ translate('Explore ') }} {{ $category->products_count }}  {{ translate('Products') }}</p>
                </div>
              </div>
            </div>
          </a>
        </li>
        @endforeach



      </ul>
      <!-- End Nav -->
    </div>

    <div class="col-lg-8">
      <!-- Tab Content -->
      <div class="tab-content">
        @foreach ($categories as $key => $category)
        <div class="tab-pane fade pt-0 p-4 tab-pane fade @if($key === 0) show active @endif" id="category-tabs-{{ $key }}" role="tabpanel"
        style="padding-top: 0 !important;"
        >
          {{-- <h3 class="h4">{{ $category->name }}</h3> --}}
          <div class="row">
              @if($category->products->isNotEmpty())
                  @foreach ($category->products as $product)
                      <div class="col-sm-6 mb-3">
                          @if($product)
                              <x-default.products.cards.product-card :product="$product"
                                                                     style="{{ ev_dynamic_translate('product-card', true)->value }}">
                              </x-default.products.cards.product-card>
                          @endif
                      </div>
                  @endforeach
              @endif
          </div>

        </div>

        @endforeach


      </div>
      <!-- End Tab Content -->
    </div>
  </div>
