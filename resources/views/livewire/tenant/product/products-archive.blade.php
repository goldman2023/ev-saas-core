<div class="w-full grid sm:grid-cols-12 gap-y-10 gap-x-6 lg:col-span-3 lg:gap-x-8 {{ $class }}">
    @foreach ($products as $item)
        @if($item instanceof \App\Models\Product)
            <x-default.products.product-card :product="$item"></x-default.products.product-card>
            {{-- <x-feed.elements.product-card :product="$item"></x-feed.elements.product-card> --}}
        @endif
    @endforeach

    @if($products->hasPages())
        <div class="w-full">
            {{ $products->onEachSide(3)->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    @endif
</div>