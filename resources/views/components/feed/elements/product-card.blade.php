<div class="relative">
    <a href="{{ $product->getPermalink() }}" class="group text-sm">

        {{-- Out of stock badge --}}
        @if(!$product->isInStock())
        <span
            class="absolute top-[10px] right-[10px] px-2 py-1 text-gray-100 text-xs font-medium bg-danger rounded-full">
            {{ translate('Out of stock') }} 📦
        </span>
        @endif

        @if($product->created_at->diffInDays() < 3)
        <div class="we-badges-left absolute z-100 top-[-10px] left-[-10px]">
            {{-- New Badge --}}
            {{-- TODO: Add new item threshold --}}
            <div
                class="mb-2 px-2 py-2 text-gray-100 text-sm font-semibold bg-indigo-700 rounded-full">
                {{ translate('New!') }} 🔖
        </div>
        @endif

        {{-- Popular bade --}}
        @if($product->public_view_count() > 20)
        <div class=" we-badges-left absolute top-[-10px] left-[-10px] px-2 py-2 text-gray-100 text-sm font-semibold bg-green-700 rounded-full">
            {{ translate('Trending!') }} 🔥
        </div>
        @endif
        <div class="aspect-w-5 aspect-h-3 cover w-full overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
            <img loading="lazy" class="object-contain" src="{{ $product->getThumbnail() }}" alt="{{ $product->name }}">
        </div>
        <div class="div">
             <h3 class="mt-4 font-medium text-gray-900">
            {{ $product->name }}
        </h3>
        <livewire:actions.social-action-button wire:key="product_{{ $product->id }}" :object="$product"
            action="reaction" type="like">
        </livewire:actions.social-action-button>
        </div>

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
</div>
