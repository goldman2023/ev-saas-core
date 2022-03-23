<div>
    @foreach($activities as $item)
        <x-feed.elements.feed-card :key="$item->id" :item="$item"></x-feed.elements.feed-card>
    @endforeach

    {{ $activities->links() }}
</div>
