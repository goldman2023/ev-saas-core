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

        <div class="w-full">
            @if(!empty($item->subject->hasThumbnail()))
                <a class="block w-full" href="{{ $item->subject?->getPermalink() ?? '#' }}">
                    <img src="{{ $item->subject->getThumbnail(['w' => 600]) }}" class="w-full h-[205px] object-cover rounded-xl"/>
                </a>
            @endif

            <a href="{{ $item->subject?->getPermalink() ?? '#' }}" target="_blank" class="flex text-22 mt-5 mb-3 text-typ-2 leading-none font-semibold">
                {{ $item->subject->name }}
            </a>

            <p class="text-14 text-typ-3 font-normal line-clamp-10">
                {{ empty(trim($item->subject->excerpt)) ? $item->subject->excerpt : $item->subject->excerpt }}
            </p>
        </div>

        <div class="py-4 @if($showComments) my-4 @else mt-4 mb-0 @endif px-3 flex justify-between border-y border-gray-100">
            @if(method_exists($item->subject, 'likes'))
                <livewire:actions.social-action-button wire:key="post_{{ $item->id }}" :object="$item->subject" action="reaction" type="like">
                </livewire:actions.social-action-button>
            @endif
            @if(method_exists($item->subject, 'comments'))
                <div class="inline-flex items-center text-sm cursor-pointer">
                    <button type="button" class="inline-flex items-center" wire:click="toggle_comments()">
                        @svg('heroicon-s-chat-alt', ['class' => 'w-5 h-5 text-typ-3 mr-2'])
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