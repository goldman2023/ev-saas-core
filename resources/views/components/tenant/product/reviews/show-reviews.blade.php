<!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-white" x-data="{ 'open': false }" @keydown.escape="open = false">
    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:py-32 lg:px-8 lg:grid lg:grid-cols-12 lg:gap-x-8">
        <!-- Review Result Section  -->


        <x-tenant.product.reviews.result-reviews :reviews="$product->reviews"></x-tenant.product.reviews.result-reviews>
        <!-- End Review Result Section  -->

        <div class="mt-16 lg:mt-0 lg:col-start-6 lg:col-span-7">
            <h3 class="sr-only">
                Recent reviews
            </h3>
            @if(count($product->reviews)>0)
            @foreach($product->reviews as $key => $review)
            <x-tenant.product.reviews.review-card :review="$review "></x-tenant.product.reviews.review-card>
            @endforeach
            @else
            <p class="mt-5">
                {{-- Please use x-label with global parameter --}}
                <x-label :label="ev_dynamic_translate('No reviews', true)">
                </x-label>

            </p>
            @endif
        </div>
    </div>

    <div x-show="open">
        {{-- <x-modal> --}}
            {{-- TODO: Work with @vukasin to figure out correct syntax --}}
        {{-- </x-modal> --}}
        <x-tenant.product.reviews.add-review-modal :product="$product"></x-tenant.product.reviews.add-review-modal>
    </div>
</div>
