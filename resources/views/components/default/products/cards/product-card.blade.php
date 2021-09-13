<div class="ev-product-card card card-bordered shadow-none text-left h-100">
    <div class="position-relative">

        <x-tenant.system.image alt="{{ $product->getTranslation('name') }}" class="card-img-top ev-product-card__img"
            :image="$product->thumbnail_img"></x-tenant.system.image>

        <div class="position-absolute top-0 left-0 pt-3 pl-3">
            <span class="badge badge-success badge-pill">New arrival</span>
        </div>
        <div class="position-absolute top-0 right-0 pt-3 pr-3">
            <button type="button" class="btn btn-xs btn-icon btn-outline-secondary rounded-circle" data-toggle="tooltip"
                data-placement="top" title="Save for later">
                <i class="fas fa-heart"></i>
            </button>
        </div>
    </div>

    <div class="card-body pt-3 px-3 pb-0">
        <div class="mb-2">
            <a class="d-inline-block text-body small font-weight-bold mb-1"
                href="{{ route('product', $product->slug) }}">
                {{ $product->getCondition() ?? '' }}

            </a>
            <span class="d-block h4 font-weight-bold">
                <a class="text-inherit" href="{{ route('product', $product->slug) }}">
                    {{ $product->getTranslation('name') }}
                </a>
            </span>

            <div class="mb-3">
                <a class="d-inline-flex align-items-center small" href="#">
                    <div class="text-warning mr-2">
                        <a class="d-inline-block text-body small font-weight-bold"
                            href="{{ route('product', $product->slug) }}">

                            <x-tenant.system.image class="ev-brand-image-small"
                                :image='uploaded_asset($product->brand->logo ?? "")'>
                            </x-tenant.system.image>
                            <br>
                            {{ $product->brand->name ?? '' }}

                        </a>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <div class="card-footer border-0 pt-0 pb-4 px-4">
        <div class="d-block text-left">

            <span class="text-dark font-weight-bold">
                @if (home_base_price($product->id) != home_discounted_base_price($product->id))
                    <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product->id) }}</del>
                @endif
                <span class="fw-700 text-primary">{{ home_discounted_base_price($product->id) }}</span>
            </span>
        </div>

        {{-- TODO: Make an option to manage what buttons are visible --}}
        {{-- <a href="{{ route('product', $product->slug) }}" type="button" class="btn btn-sm btn-outline-primary btn-pill transition-3d-hover">
        {{ translate('Add to Cart') }}
      </a> --}}
        <div class="hover-only">

            <a href="{{ route('product', $product->slug) }}" type="button"
                class="ml-1 btn btn-sm btn-primary btn-pill transition-3d-hover">
                {{ translate('View Product') }}
            </a>
        </div>
    </div>
</div>
