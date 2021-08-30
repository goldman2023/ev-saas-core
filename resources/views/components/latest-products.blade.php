<div class="row">
    <div class="col-8">
        <x-ev.label class="h3" :label="ev_dynamic_translate('Latest Products', true)"></x-ev.label>
    </div>
    <div class="col-4 text-right">
        <a href="{{ route('search', ['content' => 'product']) }}">{{ translate('Explore All products >') }}</a>
    </div>
</div>

@php
    $products = App\Models\Product::whereIn('user_id', verified_sellers_id())
        ->orderBy('created_at', 'DESC')
        ->take('4')
        ->get();
@endphp
<div class="row align-content-stretch mb-7">
    @foreach ($products as $key => $product)
        <div class="col-lg-3 mb-3">
            <x-product-grid-card :product="$product"></x-product-grid-card>
        </div>
    @endforeach
</div>
