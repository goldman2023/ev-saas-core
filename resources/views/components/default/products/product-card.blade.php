@if($product)
<a href="{{ $product->getPermalink() }}" class="group text-sm">
    <div class="aspect-w-5 aspect-h-3 cover w-full overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
        <img loading="lazy" class="object-contain" src="{{ $product->getThumbnail() }}" alt="{{ $product->name }}">
    </div>
    <h3 class="mt-4 font-medium text-gray-900">
        {{ $product->name }}
    </h3>
    <p class="italic text-gray-500">
        @if(!$product->isInStock())
        <span class="text-red-600 text-sm">
            {{ translate('Out of stock') }}
        </span>
        @else
        <div class="text-sm">
            {{ translate('In stock') }}
        </div>
        @endif
    </p>
    <p class="mt-2 font-medium text-gray-900">
        {{ $product->getTotalPrice(true) }}
    </p>
</a>
@endif
