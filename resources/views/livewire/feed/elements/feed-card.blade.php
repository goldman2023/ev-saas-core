<article class="mb-5 p-6 bg-white rounded-xl shadow" x-data="{
        id: 'feed-activity-{{ $item->id }}',
        comment_count: {{ $item->comments_count ?? 0 }},
        'isModalOpen': false,
    }" x-on:keydown.escape="isModalOpen=false"
    @change-activity-comment-count.window="
        if(id == 'feed-activity-'+$event.detail.item_id) {
            comment_count = Number(comment_count) + 1;
        }
    ">
    @if(!$ignore)
    <div class="w-full">
        <x-feed.elements.card-header-user-info :item="$item">
        </x-feed.elements.card-header-user-info>

        <div class="w-full flex flex-col">


            @if($item->subject::class !== \App\Models\SocialPost::class)
                <div class="w-full mb-3 flex">
                    @if($item->subject::class === \App\Models\Product::class && $item->subject->isEvent())
                        <span class="badge-success">{{ translate('Event') }}</span>
                    @elseif($item->subject::class === \App\Models\Product::class && $item->subject->isCourse())
                        <span class="badge-dark">{{ translate('Course') }}</span>
                    @elseif($item->subject::class === \App\Models\BlogPost::class && $item->subject->isPortfolio())
                        <span class="badge-warning">{{ translate('Portfolio') }}</span>
                    @else
                        <span class="badge-primary">{{ \App\Enums\ContentTypeEnum::class_to_label($item->subject::class) }}</span>
                    @endif
                </div>
            @endif

            @if(!empty($item->subject?->name ?? null))
                <a href="{{ $item->subject?->getPermalink() ?? '#' }}" target="_blank" class="flex text-22 mb-3 text-typ-2 leading-none font-semibold">
                    {{ $item->subject->name }}
                </a>
            @endif

            <p class="text-16 text-gray-900 font-normal line-clamp-10 ">
                @if(!empty($item->subject?->excerpt ?? null))
                    {{ empty(trim($item->subject->excerpt)) ? strip_tags($item->subject->content) : $item->subject->excerpt }}
                @else
                    {{ $item->subject->content }}
                @endif
            </p>

            @if(!empty($item->subject->hasThumbnail()))
                <a class="block w-full mb-3 mt-3" href="{{ $item->subject?->getPermalink() ?? '#' }}">
                    <img loading="lazy" src="{{ $item->subject->getThumbnail(['w' => 800]) }}" class="border w-full max-h-[400px] object-contain rounded-xl"/>
                </a>
            @endif

            @if(!empty($item->subject?->tags ?? null))
                <div class="w-full mt-3 flex flex-wrap space-x-2">
                    @foreach($item->subject?->tags as $tag)
                        <span class="text-12 text-typ-3 py-1 px-2 border border-gray-200 rounded-xl">#{{ $tag }}</span>
                    @endforeach
                </div>
            @endif

            @if($item->subject::class === \App\Models\SocialPost::class)
                <div class="w-full flex justify-end">
                    <a href="{{ $item->subject->getPermalink() }}" class="text-typ-3 text-12">
                        {{ translate('View full post') }}
                    </a>
                </div>
            @endif
        </div>

        <div class="py-4 @if($showComments) my-4 @else mt-4 mb-0 @endif px-3 flex justify-between border-y border-gray-100">
            @if(method_exists($item->subject, 'likes'))
                <livewire:actions.social-action-button wire:key="post_{{ $item->id }}" :object="$item->subject" action="reaction" type="like">
                </livewire:actions.social-action-button>
            @endif
            @if(method_exists($item->subject, 'comments'))
                <div class="inline-flex items-center text-sm cursor-pointer">
                    <button type="button" class="inline-flex items-center" wire:click="toggle_comments()">
                        @svg('heroicon-s-chat-bubble-left', ['class' => 'w-5 h-5 text-typ-3 mr-2'])
                        <span class="font-medium text-typ-3 text-14" x-text="comment_count+' {{ 'Comments' }}'"></span>
                    </button>
                </div>
            @endif

            <div class="inline-flex items-center text-sm cursor-pointer">
                <button type="button" class="inline-flex items-center" >
                    @svg('heroicon-s-eye', ['class' => 'w-5 h-5 text-typ-3 mr-2'])
                    <span class="font-medium text-typ-3 text-14">{{ $item->impressions }} {{ translate('Views') }}</span>
                </button>
            </div>
        </div>

        @if($showComments)
            <livewire:actions.social-comments :item="$item">
            </livewire:actions.social-comments>
        @endif
    </div>
    @endif
</article>
