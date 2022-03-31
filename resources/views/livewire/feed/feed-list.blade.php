<div>
    <div class="px-4 sm:px-0">
        <div class="hidden sm:hidden">
            <label for="question-tabs" class="sr-only">Select a tab</label>
            <select id="question-tabs"
                class="block w-full rounded-md border-gray-300 text-base font-medium text-gray-900 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                <option selected>Recent</option>

                <option>Most Liked</option>

                <option>Most Answers</option>
            </select>
        </div>
        <div class="hidden sm:block">
            <nav class="relative z-0 rounded-lg shadow flex divide-x divide-gray-200 mb-3" aria-label="Tabs">
                <!-- Current: "text-gray-900", Default: "text-gray-500 hover:text-gray-700" -->
                <a href="#" aria-current="page" wire:click="loadType('recent')"
                    class="@if($type == 'recent') text-gray-900 @else text-gray-500 hover:text-gray-700 @endif  rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-6 text-sm font-medium text-center hover:bg-gray-50 focus:z-10">
                    <span>Recent</span>
                    @if($type == 'recent')
                    <span aria-hidden="true" class="bg-indigo absolute inset-x-0 bottom-0 h-0.5"></span>
                    @else
                    <span aria-hidden="true" class="bg-transparent absolute inset-x-0 bottom-0 h-0.5"></span>
                    @endif
                </a>

                <button wire:click="loadType('trending')"
                    class="@if($type == 'trending') text-gray-900 @else text-gray-500 hover:text-gray-70 @endif group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-6 text-sm font-medium text-center hover:bg-gray-50 focus:z-10">
                    <span>{{ translate('Trending') }}</span>
                    @if($type == 'trending')
                    <span aria-hidden="true" class="bg-indigo absolute inset-x-0 bottom-0 h-0.5"></span>
                    @else
                    <span aria-hidden="true" class="bg-transparent absolute inset-x-0 bottom-0 h-0.5"></span>
                    @endif
                </button>

                <button disabled
                    class="opacity-50 text-gray-500 hover:text-gray-700 rounded-r-lg group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-6 text-sm font-medium text-center hover:bg-gray-50 focus:z-10">
                    <span>{{ translate('Most Answers') }}</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800"> {{ translate('Coming soon!') }} </span>

                    <span aria-hidden="true" class="bg-transparent absolute inset-x-0 bottom-0 h-0.5"></span>

                </button>
            </nav>
        </div>
    </div>
    <div wire:loading wire:target="loadInit" class="w-full">
        <div class="mb-3 bg-white px-4 py-6 shadow sm:p-6 sm:rounded-lg w-full">
            {{ translate('Loading Your Knowledge Feed...') }}
        </div>
    </div>
    <div wire:init="loadInit">
        @if($readyToLoad)
        @foreach($activities as $item)
        <livewire:feed.elements.feed-card wire:key="activity_{{ $item->id }}" :item="$item">
        </livewire:feed.elements.feed-card>
        @endforeach
        @endif
    </div>
    @if($readyToLoad)
    <div class="w-full" x-intersect:margin.-400px="$wire.loadMore()">
        @if($hasMorePages)

        <div class="mb-3 bg-white px-4 py-6 shadow sm:p-6 sm:rounded-lg w-full">
            {{ translate('Loading Your Knowledge Feed...') }}

        </div>
        @else
        <div class="mb-3 bg-white px-4 py-6 shadow sm:p-6 sm:rounded-lg w-full">
            {{ translate('You\'ve reache the end. Fancy Sharing something?') }}
        </div>
        <livewire:feed.elements.add-post></livewire:feed.elements.add-post>

        @endif
    </div>
    @endif

    <style>
        [data-f-id="pbf"] {
            display: none !important;
        }
    </style>
</div>
