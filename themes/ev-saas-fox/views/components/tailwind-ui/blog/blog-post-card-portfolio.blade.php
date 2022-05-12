<a href="{{ !empty($blogPost->getCoreMeta('portfolio_link')) ? $blogPost->getCoreMeta('portfolio_link') : $blogPost->getPermalink() }}" 
    class="block bg-white rounded-xl border border-gray-200 hover:shadow-lg pb-4"
    target="_blank">
    <div class="w-full">
        <div class="w-full aspect-square inline-flex items-center justify-center rounded-t-xl mb-3 overflow-hidden">
            <img src="{{ $blogPost->getThumbnail(['h' => 300]) }}" alt="" class="w-full h-[140px] object-cover">
        </div>

        <div class="w-full text-left px-5">
            @if(!empty($blogPost->primary_category))
                <div class="flex flex-row mb-1">
                    <span class="text-12 text-blue-700">{{ $blogPost->primary_category->name }}</span>
                </div>
            @endif

            <h4 class="text-14 font-semibold tracking-tight text-typ-2 line-clamp-2 mb-2">
                {{ $blogPost->getTranslation('name') }}
            </h4>

            {{-- <p class="text-12 text-typ-2 line-clamp-3 mb-2">
                {{ $blogPost->excerpt }}
            </p> --}}

            <div class="w-full grid grid-cols-2">
                <div class="flex items-center">
                    <img src="{{ $blogPost->authors?->first()?->getThumbnail(['w' => 100]) ?? '' }}" class="border border-gray-200 rounded-full object-cover w-8 h-8 mr-2" />
                    <span class="text-14 text-gray-500 line-clamp-1">{{ ($blogPost->authors?->first()?->name ?? '').' '.($blogPost->authors?->first()?->surname ?? '') }}</span>
                </div>
                <div class="flex items-center justify-end text-typ-3">
                    @svg('heroicon-o-calendar', ['class' => 'w-4 h-4 mr-2'])
                    <span class="text-12">{{ $blogPost->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</a>