<p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider" id="communities-headline">
    {{ translate('Pages') }}
</p>
<div class="mt-3 space-y-2" aria-labelledby="communities-headline">
    {{-- TODO: Order by views --}}
    @foreach (\App\Models\Page::all() as $key => $page)
        <a href="{{ route('custom-pages.show_custom_page', $page->slug) }}"
            class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
            <span class="truncate">
                {{ $page->title }}
            </span>


        </a>
    @endforeach
