<div class="ev-product-card ev-product-card-list card card-bordered shadow-none text-left">
    <div class="row">
        <div class="col-5 position-relative">
            <a class="card-img-top" href="{{ $product->getPermalink() }}">
                <x-tenant.system.image alt="{{ $product->getTranslation('name') }}"
                    class="card-img-top ev-product-card__img" fit="cover" :image="$product->getThumbnail()">
                </x-tenant.system.image>
            </a>

            <div class="position-absolute top-0 left-3 pt-2 pl-2">
                <livewire:actions.wishlist-button :object="$product" />
            </div>
        </div>

        <div class="col-7">
            <div class="">

                <a class="d-inline-block text-body small font-weight-bold" href="{{ $product->getPermalink() }}">
                    {{ $product->getCondition() ?? '' }}

                </a>
                <span class="d-block h5 mb-0">
                    <a class="text-inherit" href="{{ $product->getPermalink() }}">
                        {{ $product->getTranslation('name') }}
                    </a>
                </span>

                <div class="">
                    <a class="small" href="#">
                        <div class="text-warning mr-2">
                            <a class="d-inline-block text-body small font-weight-bold"
                                href="{{ $product->getPermalink() }}">
                                @if($product->brand)
                                <x-tenant.system.image class="ev-brand-image-small"
                                    :image='$product->brand->getThumbnail()'>
                                </x-tenant.system.image>
                                @endif
                            </a>
                        </div>
                    </a>
                </div>

            </div>

            <div class="d-block text-left mb-2">
                <span class="text-dark font-weight-bold">
                    @if ($product->getBasePrice() != $product->getTotalPrice())
                    <del class="fw-600 opacity-50 mr-1">{{ $product->getBasePrice(true) }}</del>
                    @endif
                    <span class="fw-700 text-primary">{{ $product->getTotalPrice(true) }}</span>
                </span>
            </div>
        </div>






    </div>
</div>
