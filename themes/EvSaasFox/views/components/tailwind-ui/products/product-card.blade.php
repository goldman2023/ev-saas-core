<a href="{{ $product->getPermalink() }}" class="block bg-white rounded-xl border border-gray-200 hover:shadow-lg pb-4">
    <div class="w-full">
        <div class="w-full aspect-square inline-flex items-center justify-center rounded-t-xl mb-4 overflow-hidden">
            <img src="{{ $product->getThumbnail(['h' => 300]) }}" alt="" class="w-full h-[140px] object-cover">
        </div>

        <div class="w-full text-left px-5">
            @if(!empty($product->primary_category))
                <div class="flex flex-row mb-2">
                    <span class="badge-primary !rounded-xl">{{ $product->primary_category->name }}</span>
                </div>
            @endif

            <h4 class="text-14 font-semibold tracking-tight text-typ-2 line-clamp-2 mb-2">
                {{ $product->getTranslation('name') }}
            </h4>

            <p class="text-14 text-primary font-semibold line-clamp-3 mb-2">
                {{ $product->getTotalPrice() == 0 ? translate('Free') : $product->getTotalPrice(true) }}
            </p>

            <div class="w-full grid grid-cols-2">
                {{-- <div class="flex items-center">
                    <img src="{{ $blogPost->authors?->first()?->getThumbnail(['w' => 100]) ?? '' }}" class="border border-gray-200 rounded-full object-cover w-8 h-8 mr-2" />
                    <span class="text-14 text-gray-500 line-clamp-1">{{ ($blogPost->authors?->first()?->name ?? '').' '.($blogPost->authors?->first()?->surname ?? '') }}</span>
                </div> --}}
                <div class="col-span-2 flex items-center justify-end text-typ-3">
                    @svg('heroicon-o-calendar', ['class' => 'w-4 h-4 mr-2'])
                    <span class="text-12">{{ $product->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</a>