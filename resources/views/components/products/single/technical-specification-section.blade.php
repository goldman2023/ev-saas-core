<div class="bg-white mt-9">
    <div
        class="mx-auto grid max-w-2xl grid-cols-1 items-center gap-y-8 gap-x-8 py-24 px-4 sm:px-6 sm:py-12 lg:max-w-7xl lg:grid-cols-2 lg:px-8">
        <div>
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                {{ translate('Technical Specifications') }}
            </h2>
            <p class="mt-4 text-gray-500">
                {{ translate('Lorem Ipsum dolor amet') }}
            </p>

            <dl class="mt-16 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 sm:gap-y-16 lg:gap-x-8">
                <div class="border-t border-gray-200 pt-4">
                    <dt class="font-medium text-gray-900">Origin</dt>
                    <dd class="mt-2 text-sm text-gray-500">Designed by Good Goods, Inc.</dd>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <dt class="font-medium text-gray-900">Material</dt>
                    <dd class="mt-2 text-sm text-gray-500">Solid walnut base with rare earth magnets and
                        powder coated steel card cover</dd>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <dt class="font-medium text-gray-900">{{ translate('Dimensions') }}</dt>
                    <dd class="mt-2 text-sm text-gray-500">6.25&quot; x 3.55&quot; x 1.15&quot;</dd>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <dt class="font-medium text-gray-900">Finish</dt>
                    <dd class="mt-2 text-sm text-gray-500">Hand sanded and finished with natural oil</dd>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <dt class="font-medium text-gray-900">Includes</dt>
                    <dd class="mt-2 text-sm text-gray-500">Wood card tray and 3 refill packs</dd>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <dt class="font-medium text-gray-900">Considerations</dt>
                    <dd class="mt-2 text-sm text-gray-500">Made from natural materials. Grain and color vary
                        with each item.</dd>
                </div>
            </dl>
        </div>
        <div class="grid grid-cols-1 grid-rows-1 gap-4 sm:gap-6 lg:gap-8">
            <img src="https://cdn.shopify.com/s/files/1/0052/2941/2425/products/trailer_plan_1106.jpg?v=1655331045&width=533"
                alt="{{ $product->title }}"
                class="rounded-lg bg-gray-100">
            {{-- <img src="{{ $product->getThumbnail() }}"
                alt="Top down view of walnut card tray with embedded magnets and card groove."
                class="rounded-lg bg-gray-100"> --}}

        </div>
    </div>
</div>
