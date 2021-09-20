<h3 class="font-semibold text-gray-900 space-y-4">Categories</h3>
<ul role="list" class="text-sm font-normal text-gray-900 pb-6 border-b border-gray-200">
    @if (!isset($category_id))
        @foreach (\App\Models\Category::where('level', 0)->get() as $category)
            <li class="pt-3">
                <a class="" href="{{ route('products.category', $category->slug) }}">
                    {{ $category->getTranslation('name') }}
                </a>
            </li>
        @endforeach

    @else
    @endif
</ul>
