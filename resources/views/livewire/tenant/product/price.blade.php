<div class="d-block text-dark {{ $wrapperClass }}"
     x-cloak
>

    @if($withLabel)
        <h3 class="w-100 text-14 text-body mb-0">{{ translate('Total price:') }}</h3>
    @endif

    <div class="w-100 d-inline">
        <span class="{{ $totalPriceClass }} mr-1 mb-0" x-text="total_price_display"> </span>

        <span class="{{ $originalPriceClass }} mb-0" x-show="base_price !== total_price">
            <del x-text="base_price_display"></del>
        </span>

        @if($withDiscountLabel)
            <span x-data="{}"
                  class="badge badge-soft-success rounded text-success align-items-center px-2 py-2 ml-2 text-12"
                  :class="{ 'd-inline-flex': base_price !== total_price, 'd-none': base_price === total_price }">
                @svg('heroicon-s-tag', ['class' => 'square-16 mr-1'])
                <span x-text="'{{ translate('Discount %x%%!') }}'.replace('%x%', 100-(100*total_price/base_price))"></span>
            </span>
        @endif
    </div>

</div>
