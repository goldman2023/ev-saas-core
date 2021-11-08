<div class="ev-product-card card card-bordered shadow-none text-left h-100">
    <div class="position-relative">

        <x-tenant.system.image alt="{{ $product->getTranslation('name') }}" class="card-img-top ev-product-card__img"
            :image="$product->thumbnail_img"></x-tenant.system.image>

        <div class="position-absolute top-0 right-0 pt-3 pr-3">
            <span class="badge badge-success badge-pill">
                {{ translate('Badge Text') }}
            </span>
        </div>

    </div>

    <div class="card-body pt-3 px-3 pb-0">
        <div class="mb-2">
            <a class="d-inline-block text-body small font-weight-bold mb-1"
                href="{{ $product->permalink }}">


            </a>
            <span class="d-block h4 font-weight-bold">
                <a class="text-inherit" href="{{ $product->permalink }}">
                    {{ $product->getTranslation('name') }}
                </a>
            </span>


        </div>
    </div>

    <div class="card-footer border-0 pt-0 pb-4 px-4">
        <div class="d-block text-left">

            <span class="text-dark font-weight-bold">
                @if ($product->getBasePrice() != $product->getTotalPrice())
                    <del class="fw-600 opacity-50 mr-1">{{ $product->getBasePrice(true) }}</del>
                @endif
                <span class="fw-700 text-primary">{{ $product->getTotalPrice(true) }}</span>
            </span>
        </div>

        {{-- TODO: Make an option to manage what buttons are visible --}}
        {{-- <a href="{{ $product->permalink }}" type="button" class="btn btn-sm btn-outline-primary btn-pill transition-3d-hover">
        {{ translate('Add to Cart') }}
      </a> --}}
        <div class="w-100 text-center mt-3">

            <a href="{{ $product->permalink }}" type="button"
                class="ml-1 btn btn-sm btn-primary btn-pill transition-3d-hover">
                {{ translate('View Details') }}
            </a>
        </div>
    </div>
</div>
