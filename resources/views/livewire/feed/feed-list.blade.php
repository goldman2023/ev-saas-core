<div>

    @foreach($activities as $item)
        <x-feed.elements.feed-card :item="$item"></x-feed.elements.feed-card>
    @endforeach

    <div>
        {{ $activities->links() }}
    </div>
</div>
