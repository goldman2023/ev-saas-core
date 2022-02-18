<div class="ev-product-card card card-bordered shadow-none text-left h-100">
    <div class="position-relative">

        <a class="card-img-top" href="{{ $product->getPermalink() }}">
            <x-tenant.system.image alt="{{ $product->getTranslation('name') }}"
                class="card-img-top ev-product-card__img" fit="cover" :image="$product->getThumbnail()">
            </x-tenant.system.image>
        </a>


        <div class="position-absolute top-0 left-0 pt-3 pl-3">
            <span class="badge badge-success badge-pill">
                {{ translate('New arrival!') }}
            </span>
        </div>
        <div class="position-absolute top-0 right-0 pt-3 pr-3">
            <livewire:actions.wishlist-button :object="$product" />
        </div>
    </div>

    <div class="card-body pt-3 px-3 pb-0">
        <div class="mb-2">
            <a class="d-inline-block text-body small font-weight-bold mb-1" href="{{ $product->getPermalink() }}">
                {{ $product->getCondition() ?? '' }}

            </a>
            <span class="d-block h4 mb-0 font-weight-bold">
                <a class="text-inherit" href="{{ $product->getPermalink() }}">
                    {{ $product->getTranslation('name') }}
                </a>
            </span>

            <div class="mb-3">
                <a class="d-inline-flex align-items-center small" href="#">
                    <div class="text-warning mr-2">
                        <a class="d-inline-block text-body small font-weight-bold"
                            href="{{ $product->getPermalink() }}">
                            @if($product->brand)
                            <x-tenant.system.image class="ev-brand-image-small"
                                :image='$product->brand()->getThumbnail()'>
                            </x-tenant.system.image>

                            @endif

                            <div>
                                {{-- TODO: Fix Brand --}}
                               Brand {{ $product->brand_id }}
                            </div>


                        </a>
                    </div>
                </a>
            </div>

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
        {{-- <a href="{{ $product->getPermalink() }}" type="button"
            class="btn btn-sm btn-outline-primary btn-pill transition-3d-hover">
            {{ translate('Add to Cart') }}
        </a> --}}
        <div class="d-flex text-center mt-3">

            <a href="{{ $product->getPermalink() }}" type="button"
                class="btn btn-sm btn-outline-primary btn-pill transition-3d-hover">
                {{ translate('View Product') }}
            </a>

            <button href="{{ $product->getPermalink() }}" type="button"
                class="btn ml-1 btn-sm btn-outline-primary btn-pill transition-3d-hover">
                {{ translate('Add To Cart') }}
            </a>
        </div>
    </div>
</div>
