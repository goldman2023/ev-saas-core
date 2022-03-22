@if($products->count() > 0)
<div class="card">
    <div class="card-header">
        <div class="grid grid-cols-3 py-3">
            <div class="col-span-2 card-header text-xl font-medium text-gray-900">
                <div class="h3 fw-600">{{ translate('Recently Viewed Products') }} </div>
            </div>

            <a href="#" class="text-right">
                {{ translate('View All') }}
            </a>
        </div>




    </div>
    <div class="card-body">
        <div class="flex flex-nowrap basis-20 we-horizontal-slider__desktop" style="overflow:scroll;">
            @foreach($products as $productActivity)

            @php
            $product = $productActivity->subject;
            @endphp

            @if($product)
            <div class="mb-3 min-w-[240px] mr-6">
                <x-default.products.cards.product-card
                class=""
                :product="$product"
                    style="{{ ev_dynamic_translate('product-card', true)->value }}">
                </x-default.products.cards.product-card>
            </div>
            @endif
            @endforeach
        </div>


    </div>
</div>
@endif
