<div class="d-flex align-items-center">
    <span class="text-dark font-size-2 font-weight-bold">
        {{ $product->getTotalPriceAttribute() }}

        @if (!empty($product->unit))
            <span class="o-70">/
                {{ $product->getTranslation('unit') }}
            </span>
        @endif
    </span>

    <span class="text-body ml-2"><del>{{ home_price($product->id) }}</del></span>
    @if (home_price($product->id) != home_discounted_price($product->id))

    @endif
</div>




