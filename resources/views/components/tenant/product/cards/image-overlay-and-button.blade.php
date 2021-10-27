<div>
    <div class="relative">
        <div class="relative w-full h-72 rounded-lg overflow-hidden">
            <a href="{{ route('product', $product->slug) }}">
                <x-tenant.system.image alt="{{  $product->getTranslation('name') }}"
                                       class="w-full h-full object-center object-cover"
                                       :image="$product->thumbnail_img">
                </x-tenant.system.image>
            </a>

        </div>
        <div class="relative mt-4">
            <h3 class="text-sm font-medium text-gray-900">
                <a href="{{ route('product', $product->slug) }}">
                    {{ $product->getTranslation('name') }}
                </a>
            </h3>
            <!--  TODO: What should be this?           -->
            <p class="mt-1 text-sm text-gray-500">White and black</p>
        </div>
        <div class="absolute top-0 inset-x-0 h-72 rounded-lg p-4 flex items-end justify-end overflow-hidden">
            <a href="{{ route('product', $product->slug) }}" class="absolute top-0 left-0 h-full w-full z-20">
            </a>
            <div aria-hidden="true"
                 class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50"></div>
            <p class="relative text-lg font-semibold text-white">
                @if($product->getBasePrice() != $product->getTotalPrice())
                    <del class="opacity-50 mr-1">{{ $product->getBasePrice(true) }}</del>
                @endif
                <span class="opacity-100">{{ $product->getTotalPrice(true) }}</span>
            </p>
        </div>
    </div>
    <div class="mt-6">

        <a href="{{ route('product', $product->slug) }}"
           class="relative flex bg-gray-100 border border-transparent rounded-md py-2 px-8 items-center justify-center text-sm font-medium text-gray-900 hover:bg-gray-200">
            {{ __('Add To Cart') }}
            <span class="sr-only">, {{ $product->getTranslation('name') }}</span>
        </a>
    </div>
</div>
