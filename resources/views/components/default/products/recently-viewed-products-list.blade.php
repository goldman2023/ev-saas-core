@if($products->count() > 0)

<div class="row">
    @foreach($products as $productActivity)

    @php
    $product = $productActivity->subject;
    @endphp

    @if($product)
    <div class="col-10 col-sm-{{ $columns }} mb-3">
        <x-default.products.cards.product-card :product="$product" style="list">
        </x-default.products.cards.product-card>
    </div>
    @endif
    @endforeach
</div>
@endif
