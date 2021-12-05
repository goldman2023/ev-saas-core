<div class="d-block text-dark {{ $wrapperClass }}">

    @if($withLabel)
        <h3 class="w-100 text-14 text-body mb-0">{{ translate('Total price:') }}</h3>
    @endif

    <div class="w-100 d-inline">
        <span class="{{ $totalPriceClass }} mr-1 mb-0">
            {{ $model->getTotalPrice(true) }}
        </span>

        @if ($model->getBasePrice() !== $model->getTotalPrice())
            <span class="{{ $originalPriceClass }} mb-0">
                <del>{{ $model->getBasePrice(true) }}</del>
            </span>
        @endif
    </div>

</div>
