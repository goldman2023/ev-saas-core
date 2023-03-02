<div class="w-full grid sm:grid-cols-12 gap-y-10 gap-x-6 lg:col-span-3 lg:gap-x-8 {{ $class }}">
    @if($products->isNotEmpty())
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
    @else
        <div class="text-center">
            @svg('heroicon-o-rectangle-stack', ['class' => 'mx-auto h-12 w-12 text-gray-400'])
            <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ translate('No products') }}</h3>
            <p class="mt-1 text-sm text-gray-500">{{ translate('There are curently no products under specified parameters.') }}</p>
        </div>      
    @endif
</div>