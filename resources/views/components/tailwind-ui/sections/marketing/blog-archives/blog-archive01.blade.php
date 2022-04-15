<div class="relative bg-white py-16 sm:py-24 lg:py-32 {!! $getSectionSettingsClasses !!}">
    <div class="mx-auto max-w-md px-4 text-center sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @if($blog_posts->isNotEmpty())
                @foreach($blog_posts as $blog_post)
                    <a href="{{ $blog_post->getPermalink() }}" class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-4">
                        <div class="w-full">
                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md mb-5">
                                <img src="{{ $blog_post->getThumbnail(['h' => 300]) }}" alt="" class="w-full h-[220px] object-cover">
                            </div>

                            <div class="w-full text-left px-6">
                                @if(!empty($blog_post->primary_category))
                                    <div class="flex flex-row mb-2.5">
                                        <span class="badge-info !rounded">{{ $blog_post->primary_category->name }}</span>
                                    </div>
                                @endif

                                <h4 class="text-18 font-medium tracking-tight text-gray-900 line-clamp-1 mb-3">
                                    {{ $blog_post->getTranslation('name') }}
                                </h4>
        
                                <p class="text-14 text-gray-500 line-clamp-3 mb-5">
                                    {{ $blog_post->excerpt }}
                                </p>

                                <div class="w-full grid grid-cols-2">
                                    <div class="flex items-center">
                                        <img src="{{ $blog_post->authors->first()->getThumbnail(['w' => 100]) }}" class="rounded-full object-cover w-8 h-8 mr-2.5" />
                                        <span class="text-14 text-gray-500 line-clamp-1">{{ $blog_post->authors->first()->name.' '.$blog_post->authors->first()->surname }}</span>
                                    </div>
                                    <div class="flex items-center justify-end md:justify-center text-gray-500">
                                        @svg('heroicon-o-calendar', ['class' => 'w-4 h-4 mr-3'])
                                        <span class="text-14">{{ $blog_post->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div> 
</div>