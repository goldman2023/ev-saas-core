<section aria-labelledby="related-heading" class="mt-10 border-t border-gray-200 py-16 px-4 sm:px-0">
    <h2 id="related-heading" class="text-xl font-bold text-gray-900">
        {{ translate('Related products') }}
    </h2>

    <div class="mt-8 grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
        @foreach($relatedProducts as $product)
        <a href="{{ $product->getPermalink() }}">
            <div class="relative">
                <div class="relative h-52 w-full overflow-hidden rounded-lg">
                    <img class="w-full h-full object-cover" src="{{ $product->getThumbnail() }}" alt="{{ $product->name }}">
                </div>
                <div class="relative mt-4">
                    <h3 class="text-sm font-medium text-gray-900">
                        {{ $product->name }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ translate('Available in warehouse') }}
                    </p>
                </div>
                <div
                    class="absolute inset-x-0 top-0 flex h-52 items-end justify-end overflow-hidden rounded-lg p-4">
                    <div aria-hidden="true"
                        class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50">
                    </div>
                    <p class="relative text-lg font-semibold text-white">
                        {{ FX::formatPrice($product->getBasePrice()) }}
                    </p>
                </div>
            </div>

        </a>
        @endforeach

        <!-- More products... -->
    </div>
</section>
