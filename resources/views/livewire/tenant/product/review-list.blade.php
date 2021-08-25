<div class="mt-16 lg:mt-0 lg:col-start-6 lg:col-span-7">
    <h3 class="sr-only">
        {{ev_dynamic_translate('No reviews', true)}}
    </h3>
    @if(count($reviews)>0)
        @foreach($reviews as $key => $review)
            @livewire('tenant.product.review-card', ['review'=>$review])
        @endforeach
    @else
        <p class="mt-5">
            <x-label :label="ev_dynamic_translate('No reviews', true)">
            </x-label>
        </p>
    @endif
</div>