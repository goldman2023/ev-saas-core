<div>
    <div class="px-4 sm:px-0">
        {{-- <div class="hidden sm:hidden">
            <label for="question-tabs" class="sr-only">Select a tab</label>
            <select id="question-tabs"
                class="block w-full rounded-md border-gray-300 text-base font-medium text-gray-900 shadow-sm focus:border-rose-500 focus:ring-rose-500">

                <option selected>{{ translate('Recent') }}</option>
                <option>{{ translate('Trending') }}</option>

                <option>{{ translate('Most Answers') }}</option>
            </select>
        </div> --}}

        {{-- <div class="hidden sm:block">
            <nav class="relative grid grid-cols-12 gap-3 mb-3">
                <button wire:click="loadType('recent')"
                    class="@if($type == 'recent') text-primary @else text-gray-500 hover:text-gray-700 @endif
                    col-span-4 bg-white rounded-xl shadow p-4 flex items-center justify-center">

                    <div class="rounded-full mr-2">
                        @svg('heroicon-o-clock', ['class' => 'w-5 h-5'])
                    </div>

                    <span class="text-14">{{ translate('Recent') }}</span>
                </button>

                <button wire:click="loadType('trending')"
                    class="@if($type == 'trending') text-primary @else text-gray-500 hover:text-gray-700 @endif
                    col-span-4 bg-white rounded-xl shadow p-4 flex items-center justify-center">

                    <div class="rounded-full mr-2">
                        @svg('heroicon-o-fire', ['class' => 'w-5 h-5'])
                    </div>

                    <span class="text-14">{{ translate('Trending') }}</span>
                </button>

                <button disabled
                    class="relative opacity-50 text-gray-500 col-span-4 bg-white rounded-xl shadow p-4 flex items-center justify-center">

                    <div class="rounded-full mr-2">
                        @svg('heroicon-o-chat-bubble-left-right', ['class' => 'w-5 h-5'])
                    </div>

                    <span class="text-14">{{ translate('Most Answers') }}</span>

                    {{-- <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        {{ translate('Coming soon!') }} </span>
                </button>
            </nav>
        </div> --}}
    </div>

    @if(!$readyToLoad)
        <livewire:feed.elements.feed-card-empty-state>
        </livewire:feed.elements.feed-card-empty-state>
    @endif

    <div wire:loading wire:target="loadInit" class="w-full">
        <livewire:feed.elements.feed-card-empty-state>
        </livewire:feed.elements.feed-card-empty-state>
    </div>

    <div wire:init="loadInit">
        @if(!empty($my_new_post))
            <livewire:feed.elements.feed-card wire:key="activity_{{ time().'_'.$my_new_post->id }}" :item="$my_new_post">
            </livewire:feed.elements.feed-card>
        @endif

        @if($readyToLoad)
            @foreach($activities as $item)
                <livewire:feed.elements.feed-card wire:key="activity_{{ time().'_'.$item->id }}" :item="$item">
                </livewire:feed.elements.feed-card>
            @endforeach
        @endif
    </div>

    @if($readyToLoad)
        <div class="w-full" x-intersect:margin.-400px="$wire.loadActivities()">
            @if($hasMorePages)

            <div class="mb-3 bg-white px-4 py-6 shadow sm:p-6 sm:rounded-lg w-full">
                {{ translate('Loading More Posts...') }}

            </div>
            @else
            <div class="mb-3 bg-white px-4 py-6 shadow sm:p-6 sm:rounded-lg w-full">
                {{ translate('You\'ve reached the end. Fancy Sharing something?') }}
            </div>
            @auth
            <livewire:feed.elements.add-post></livewire:feed.elements.add-post>
            @endauth

            @endif
        </div>
    @endif

    <style>
        [data-f-id="pbf"] {
            display: none !important;
        }
    </style>
</div>
