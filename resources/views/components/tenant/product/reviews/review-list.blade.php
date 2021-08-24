<div class="mt-16 lg:mt-0 lg:col-start-6 lg:col-span-7">
    <h3 class="sr-only">
        Recent reviews
    </h3>
    @if(count($reviews)>0)
        @foreach($reviews as $key => $review)
            <x-tenant.product.reviews.review-card :review="$review "></x-tenant.product.reviews.review-card>
        @endforeach
    @else
        <p class="mt-5">
            <x-label :label="ev_dynamic_translate('No reviews', true)">
            </x-label>
        </p>
    @endif
</div>