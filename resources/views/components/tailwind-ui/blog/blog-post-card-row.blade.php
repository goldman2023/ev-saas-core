<div class="w-full pb-3 mb-4 border-b border-gray-20 last:border-none last:pb-0 last:mb-0">
    <div class="flex space-x-4">
        <div class="flex-shrink-0">
            <div class="inline-block relative">
                <a href="{{ $blogPost->getPermalink() }}">
                    <x-tenant.system.image
                        class="h-11 w-11 rounded-xl border-3 ring-2 ring-gray-200" fit="cover"
                        :image="$blogPost->getThumbnail()">
                    </x-tenant.system.image>
                </a>
            </div>
        </div>
        <div class="min-w-0 flex-1">
            <div class="w-full flex flex-row ">
                <div class="w-full flex flex-col pr-4">
                    <a href="{{ $blogPost->getPermalink() }}" class="text-14 text-typ-2 font-medium block hover:underline mb-1 leading-tight line-clamp-2">
                        {{ $blogPost->name }}
                    </a>
                    <p class="text-12 text-typ-3 line-clamp-2 mb-2">
                        {{ $blogPost->excerpt }}
                    </p>
                </div>
            </div>
            
        </div>
        
    </div>
</div>