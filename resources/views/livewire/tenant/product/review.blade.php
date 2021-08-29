<div class="bg-white" x-data="{ 'open': false }" @keydown.escape="open = false">

    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:py-32 lg:px-8 lg:grid lg:grid-cols-12 lg:gap-x-8">
        <x-tenant.product.reviews.review-summary :reviews="$reviews"></x-tenant.product.reviews.review-summary>

        <div class="mt-16 lg:mt-0 lg:col-start-6 lg:col-span-7">
            <h3 class="sr-only">
                {{ev_dynamic_translate('No reviews', true)}}
            </h3>
            @if(count($reviews)>0)
            @foreach($reviews as $key => $review)
            <livewire:tenant.product.review-card :review="$review" :key="$key"/>
            @endforeach
            @else
            <p class="mt-5">
                <x-ev::label :label="ev_dynamic_translate('No reviews', true)">
                </x-ev::label>
            </p>
            @endif
        </div>
    </div>

    @livewire('tenant.add-review', ['product_id'=>$product_id])
</div>
