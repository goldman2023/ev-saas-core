@if($products->count() > 0)
dadsadsa
<div class="flex flex-nowrap">
    @foreach($products as $productActivity)

    @php
    $product = $productActivity->subject;
    @endphp

    @if($product)
    <div class="col-span-2 mb-3">
        <x-default.products.cards.product-card :product="$product" style="list">
        </x-default.products.cards.product-card>
    </div>
    @endif
    @endforeach
</div>
@endif
