<div class="card text-left h-100 w-100">
    <div class="position-relative">
        @if($product->getThumbnail())
        <a class="card-img-top" href="{{ $product->getPermalink() }}">
            <x-tenant.system.image alt="{{ $product->getTranslation('name') }}"
                class="card-img-top ev-product-card__img" fit="cover" :image="$product->getThumbnail()">
            </x-tenant.system.image>
        </a>
        @endif


        <div class="position-absolute top-0 left-0 pt-3 pl-3">
            <span class="badge badge-success badge-pill">
                {{ $product->getCondition() ?? '' }}
            </span>
        </div>
        <div class="position-absolute top-0 right-0 pt-3 pr-3">
            <livewire:actions.wishlist-button :object="$product" />
        </div>
    </div>

    <div class="card-body pt-3 px-3 pb-0">
        <div class="mb-2">
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

                            {{ $product->brand->name }}
                            <x-tenant.system.image class="ev-brand-image-small"
                                :image='$product->brand->getThumbnail()'>
                            </x-tenant.system.image>
                            @endif


                            <div>
                                {{-- TODO: Fix Brand --}}

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
                {{ $product->getTotalPrice() }} €
            </span>
        </div>

        {{-- TODO: Make an option to manage what buttons are visible --}}
        {{-- <a href="{{ $product->getPermalink() }}" type="button"
            class="btn btn-sm btn-outline-primary btn-pill transition-3d-hover">
            {{ translate('Add to Cart') }}
        </a> --}}

    </div>
</div>
