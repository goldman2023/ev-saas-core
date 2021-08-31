<!-- Breadcrumb -->
<ol class="breadcrumb breadcrumb-light breadcrumb-no-gutter mb-0">
    @foreach ($breadcrumbs as $key => $breadcrumb)
        <li class="breadcrumb-item @if($key+1 === $breadcrumbs->count()) active @endif"
            @if($key+1 === $breadcrumbs->count()) aria-current="page" @endif
        >
            @if($key+1 !== $breadcrumbs->count())
                <a href="{{ $breadcrumb->url }}" class="breadcrumb-item">
                    {{ $breadcrumb->title }}
                </a>
            @else
                {{ $breadcrumb->title }}
            @endif
        </li>
    @endforeach
</ol>
<!-- End Breadcrumb -->
