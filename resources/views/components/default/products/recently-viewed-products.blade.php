@if($products->count() > 0)
<div class="card">
    <div class="card-header">

        <h5>
            {{ translate('Recently Viewed Products') }}
        </h5>

        <a href="#">
           {{ translate('View All') }}
        </a>
    </div>
    <div class="card-body">
        <div class="row flex-nowrap ev-horizontal-slider" style="overflow: scroll;   -ms-overflow-style: none; /* for Internet Explorer, Edge */
        scrollbar-width: none; /* for Firefox */
        overflow-y: scroll; ">
            @foreach($products as $productActivity)

            @php
            $product = $productActivity->subject;
            @endphp

            @if($product)
            <div class="col-10 col-sm-{{ $columns }} mb-3">
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
