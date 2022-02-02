@unless ($breadcrumbs->isEmpty())
    <ol class="breadcrumb mb-0">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!is_null($breadcrumb->url) && !$loop->last)
                <li class="breadcrumb-item">
                    <a href="{{ $breadcrumb->url }}" class="text-primary">{{ $breadcrumb->title }}</a>
                </li>
            @else
                <li class="breadcrumb-item active text-white">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ol>
@endunless
