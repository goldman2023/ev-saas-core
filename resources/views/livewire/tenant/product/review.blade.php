<div class="bg-white" x-data="{ 'open': false }" @keydown.escape="open = false">
    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:py-32 lg:px-8 lg:grid lg:grid-cols-12 lg:gap-x-8">
        <x-tenant.product.reviews.review-summary :reviews="$reviews"></x-tenant.product.reviews.review-summary>

        @livewire('tenant.product.review-list', ['reviews'=>$reviews])
    </div>

    <div x-show="open">
        @livewire('tenant.add-review', ['product_id'=>$product_id])
    </div>
</div>
