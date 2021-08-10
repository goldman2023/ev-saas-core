<div class="mb-4">
    <h1>
        {{ $blog->title }}
    </h1>
    @if ($blog->category != null)
        <div class="mb-2 opacity-50">
            <i>{{ $blog->category->name }}</i>
        </div>
    @endif
</div>
