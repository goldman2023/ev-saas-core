<h3 class="sr-only">Categories</h3>
<ul role="list" class="text-sm font-medium text-gray-900 space-y-4 pb-6 border-b border-gray-200">
    @if (!isset($category_id))
        @foreach (\App\Models\Category::where('level', 0)->get() as $category)
            <li>
<!-- TODO: Why this route dos not work, investigatwe                 -->
                <a class=" href="{{ route('products.category', $category->slug) }}">
                {{ $category->getTranslation('name') }}
                </a>
            </li>
        @endforeach

    @else
    @endif
</ul>
