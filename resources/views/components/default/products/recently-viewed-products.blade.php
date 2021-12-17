@if($products->count() > 0)
<div class="card">
    <div class="card-header">

        <h5>
            {{ translate('Recently Viewed Products') }}
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($products as $productActivity)

            @php
            $product = $productActivity->subject;
            @endphp

            @if($product)
            <div class="col-4 mb-3">
                <x-default.products.cards.product-card :product="$product"
                    style="{{ ev_dynamic_translate('product-card', true)->value }}">
                </x-default.products.cards.product-card>
            </div>
            @endif
            @endforeach
        </div>


    </div>
</div>
@endif
