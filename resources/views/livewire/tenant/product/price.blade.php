<div class="d-flex align-items-center">
    <span class="text-dark font-size-2 font-weight-bold">
        {{ $product->getTotalPrice(true) }}

        @if (!empty($product->unit))
            <span class="o-70">/
                {{ $product->getTranslation('unit') }}
            </span>
        @endif
    </span>

    @if ($product->getOriginalPrice() !== $product->getTotalPrice())
        <span class="text-body ml-2"><del>{{ $product->getOriginalPrice(true) }}</del></span>
    @endif
</div>




