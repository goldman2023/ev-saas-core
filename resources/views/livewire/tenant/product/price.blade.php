<div class="flex items-center {{ $wrapperClass }}"
     x-cloak
>
    @if($withLabel)
        <h3 class="text-18 text-body font-semibold">{{ translate('Price:') }}</h3>
    @endif

    <div class="flex items-center ml-3">

        <span class="text-24 font-semibold line-through text-gray-400 {{ $originalPriceClass }} mb-0 mr-4" x-show="base_price !== total_price">
            <del x-text="base_price_display"></del>
        </span>

        <span class="text-24 font-semibold text-gray-900 {{ $totalPriceClass }} mb-0" x-text="total_price_display"> </span>
    

        @if($withDiscountLabel)
            <span x-data="{}"
                  class="badge-success px-2 py-2 ml-2 !text-14 items-center !font-semibold"
                  :class="{ 'flex': base_price !== total_price, 'hidden': base_price === total_price }">
                @svg('heroicon-s-tag', ['class' => 'w-4 h-4 mr-1'])
                <span x-text="'{{ translate('%x%%!') }}'.replace('%x%', (100-(100*total_price/base_price)).toFixed(2) )"></span>
            </span>
        @endif
    </div>

</div>
