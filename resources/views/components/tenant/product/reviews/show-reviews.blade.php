<!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-white" x-data="{ 'open': false }" @keydown.escape="open = false">
    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:py-32 lg:px-8 lg:grid lg:grid-cols-12 lg:gap-x-8">
        <!-- Review Result Section  -->
        <x-tenant.product.reviews.review-summary :reviews="$product->reviews"></x-tenant.product.reviews.review-summary>
        <!-- End Review Result Section  -->

        <!-- Review List Section  -->
        <x-tenant.product.reviews.review-list :reviews="$product->reviews"></x-tenant.product.reviews.review-list>
        <!-- End Review List Section  -->
    </div>

    <div x-show="open">
        @livewire('tenant.add-review', ['product_id'=>$product->id])
    </div>
</div>
