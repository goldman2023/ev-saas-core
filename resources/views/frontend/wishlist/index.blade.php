@if($products->count() > 0)
<div class="card">
    <div class="card-header">

       <h5>
            {{ translate('Recently Viewed Products') }}
       </h5>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($products as $product)

            <div class="col-4">
                <x-default.products.cards.product-card :product="$product->product"
                    style="{{ ev_dynamic_translate('product-card', true)->value }}">
                </x-default.products.cards.product-card>
            </div>
            @endforeach

        </div>


    </div>
</div>
@endif
