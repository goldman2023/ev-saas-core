
    <span class="text-dark font-size-2 font-weight-bold">
                    {{ home_discounted_price($price) }}
        @if ($product->unit != null)
            <span class="opacity-70">/
                            {{ $product->getTranslation('unit') }}
                        </span>
        @endif
    </span>
    @if (home_price($product->id) != home_discounted_price($product->id))
        <span class="text-body ml-2"><del>{{ home_price($product->id) }}</del></span>
    @endif
