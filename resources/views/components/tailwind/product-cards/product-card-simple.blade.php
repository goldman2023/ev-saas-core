<a href="{{ $product->getPermalink() }}" class="group">
    <div
        class="w-full aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden xl:aspect-w-7 xl:aspect-h-8">

        <x-tenant.system.image alt="{{ $product->getTranslation('name') }} image"
        class="w-full h-full object-center object-cover group-hover:opacity-75"
        :image="$product->getThumbnail()">
    </x-tenant.system.image>

    </div>
    <h3 class="mt-4 text-sm text-gray-700">
        {{ $product->getTranslation('name') }}
    </h3>
    <p class="mt-1 text-lg font-medium text-gray-900">
        {{ $product->getBasePrice(true) }}
    </p>
</a>
