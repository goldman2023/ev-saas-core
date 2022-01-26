<div class="row">
    <div class="col-sm-8 col-6">
        <x-ev.label class="h3" :label="ev_dynamic_translate('Latest Products', true)"></x-ev.label>
    </div>
    <div class="col-sm-4  col-6 text-right">
        <a href="{{ route('search', ['content' => 'product']) }}">{{ translate('Explore All products >') }}</a>
    </div>
</div>

@php
    $products = App\Models\Product::orderBy('created_at', 'DESC')
        ->take('8')
        ->get();
@endphp
<div class="row align-content-stretch mb-7 ev-horizontal-slider flex-nowrap" style="overflow: scroll;">
    @foreach ($products as $key => $product)
        <div class="col-lg-3 col-10 mb-3">
            <x-default.products.cards.product-card :product="$product" class="product-card-detailed-2"
            style="{{ ev_dynamic_translate('product-card', true)->value }}">
        </x-default.products.cards.product-card>
        </div>
    @endforeach
</div>
