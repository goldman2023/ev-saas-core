@if($products->count() > 0)
<div {{ $attributes->merge(['class' => 'p-3']) }}>
    <div class="card-header">
        <div class="grid grid-cols-3 py-3">
            <div class="col-span-2 card-header text-xl font-semibold text-gray-900">
                <div class="h3 fw-600">{{ translate('Recently Viewed Products') }} </div>
            </div>

            <a href="#" class=" hidden text-right">
                {{ translate('View All') }}
            </a>
        </div>




    </div>
    <div class="card-body">
        <div class="flex flex-nowrap basis-20 we-horizontal-slider__desktop pt-5" style="overflow:scroll;">
            @foreach($products as $productActivity)

            @php
            $product = $productActivity->subject;
            @endphp

            @if($product)
            <div class="mb-3 min-w-[240px] mr-6">
                <livewire:feed.elements.product-card :product="$product"></livewire:feed.elements.product-card>
            </div>
            @endif
            @endforeach
        </div>


    </div>
</div>
@endif
