@foreach($activities as $key => $item)
<x-feed.elements.feed-card :item="$item"></x-feed.elements.feed-card>
@endforeach
