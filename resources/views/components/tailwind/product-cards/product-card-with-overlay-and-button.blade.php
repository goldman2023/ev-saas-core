<!-- This example requires Tailwind CSS v2.0+ -->


<div>
    <div class="relative">
        <div class="relative w-full h-72 rounded-lg overflow-hidden">
            <x-tenant.system.image alt="{{ $product->getTranslation('name') }} image"
                class="w-full h-full object-center object-cover" :image="$product->getThumbnail()">
            </x-tenant.system.image>
        </div>
        <div class="relative mt-4">
            <h3 class="text-sm font-medium text-gray-900">
                {{ $product->getTranslation('name') }}
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                {{ $product->brand->name }}
            </p>
        </div>
        <div class="absolute top-0 inset-x-0 h-72 rounded-lg p-4 flex items-end justify-end overflow-hidden">
            <div aria-hidden="true" class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50">
            </div>
            <p class="relative text-lg font-semibold text-white">
                {{ $product->getBasePrice(true) }}
            </p>
        </div>
    </div>
    <div class="mt-6">
        <a href="#"
            class="relative flex bg-gray-100 border border-transparent rounded-md py-2 px-8 items-center justify-center text-sm font-medium text-gray-900 hover:bg-gray-200">
            Add to bag<span class="sr-only">, Zip Tote Basket</span>
        </a>
    </div>
</div>
