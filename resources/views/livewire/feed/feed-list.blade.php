<div>
    <div wire:loading wire:target="loadInit" class="w-full">
        <div class="mb-3 bg-white px-4 py-6 shadow sm:p-6 sm:rounded-lg w-full">
            {{ translate('Loading Your Knowledge Feed...') }}
        </div>
    </div>
    <div wire:init="loadInit">
        @if($readyToLoad)
            @foreach($activities as $item)
                <x-feed.elements.feed-card :key="$item->id" :item="$item"></x-feed.elements.feed-card>
            @endforeach
        @endif
    </div>
    <div class="w-full" x-intersect:margin.-400px="$wire.loadMore()">
        <div class="mb-3 bg-white px-4 py-6 shadow sm:p-6 sm:rounded-lg w-full">
            {{ translate('Loading Your Knowledge Feed...') }}
        </div>
    </div>




</div>
