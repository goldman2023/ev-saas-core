<div class="card card-bordered shadow-none text-center h-100">
    <div class="position-relative">

      <x-tenant.system.image alt="{{ $product->getTranslation('name') }}"
        class="card-img-top"
        :image="$product->thumbnail_img"></x-tenant.system.image>

      <div class="position-absolute top-0 left-0 pt-3 pl-3">
        <span class="badge badge-success badge-pill">New arrival</span>
      </div>
      <div class="position-absolute top-0 right-0 pt-3 pr-3">
        <button type="button" class="btn btn-xs btn-icon btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="top" title="Save for later">
          <i class="fas fa-heart"></i>
        </button>
      </div>
    </div>

    <div class="card-body pt-4 px-4 pb-0">
      <div class="mb-2">
        <a class="d-inline-block text-body small font-weight-bold mb-1" href="{{ route('product', $product->slug) }}">
          {{ $product->brand->name ?? '' }}
        </a>
        <span class="d-block font-size-1">
          <a class="text-inherit" href="{{ route('product', $product->slug) }}">
            {{ $product->getTranslation('name') }}
          </a>
        </span>
        <div class="d-block">

          <span class="text-dark font-weight-bold">
            @if (home_base_price($product->id) != home_discounted_base_price($product->id))
            <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product->id) }}</del>
        @endif
        <span class="fw-700 text-primary">{{ home_discounted_base_price($product->id) }}</span>
      </span>
        </div>
      </div>
    </div>

    <div class="card-footer border-0 pt-0 pb-4 px-4">
      <div class="mb-3">
        <a class="d-inline-flex align-items-center small" href="#">
          <div class="text-warning mr-2">
            <a class="d-inline-block text-body small font-weight-bold mb-1" href="{{ route('product', $product->slug) }}">
              {{ $product->brand->name ?? '' }}

              <x-tenant.system.image :image='uploaded_asset($product->brand->logo ?? "")'>
              </x-tenant.system.image>
            </a>
          </div>
        </a>
      </div>
      <a href="{{ route('product', $product->slug) }}" type="button" class="btn btn-sm btn-outline-primary btn-pill transition-3d-hover">
        {{ translate('Add to Cart') }}
      </a>
    </div>
  </div>
