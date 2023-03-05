<a href="{{ $blogPost->getPermalink() }}" class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-4">
    <div class="w-full">
        <div class="w-full aspect-[350/130] inline-flex items-center justify-center rounded-t-md border-b border-gray-200 mb-5 overflow-hidden">
            <img src="{{ $blogPost->getThumbnail() }}" width="350px" height="131" alt="{{ $blogPost->name }}" loading="lazy" class="w-full h-auto object-contain">
        </div>

        <div class="w-full text-left px-6">
            @if(!empty($blogPost->primary_category ?? null))
                <div class="flex flex-row mb-2.5">
                    <span class="badge-info !rounded">{{ $blogPost->primary_category->name }}</span>
                </div>
            @endif

            <h4 class="text-18 font-medium tracking-tight text-gray-900 line-clamp-3 mb-3">
                {{ $blogPost->name }}
            </h4>

            <p class="text-14 text-gray-500 line-clamp-3 mb-5">
                {{ $blogPost->excerpt }}
            </p>

            @if(!empty($blogPost->authors?->first() ?? null))
                <div class="w-full grid grid-cols-2">
                    <div class="flex items-center">
                        <img src="{{ $blogPost->authors->first()->getThumbnail(['w' => 100]) }}" alt="Pixpro author avatar" class="rounded-full object-cover w-8 h-8 mr-2.5" />
                        <span class="text-14 text-gray-500 line-clamp-1">{{ $blogPost->authors->first()->name.' '.$blogPost->authors->first()->surname }}</span>
                    </div>
                    <div class="flex items-center justify-end md:justify-center text-gray-500">
                        @svg('heroicon-o-calendar', ['class' => 'w-4 h-4 mr-2'])
                        <span class="text-14">{{ $blogPost->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</a>
