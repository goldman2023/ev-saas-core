<section class="mx-auto max-w-7xl  mt-3">
    <div class="mb-3 text-gray-600 font-bold text-lg uppercase">
        {{ translate('Categories') }}
    </div>
    <div class="gap-3 overflow-x-auto no-scrollbar">
        <div class="whitespace-nowrap text-center
        inline-flex items-center mb-4 w-full rounded-xl text-sm font-medium hover:bg-indigo-700 hover:text-white bg-gray-100 text-indigo-800">
            <a class="px-3 py-2" href="{{ route('blog.archive') }}">
                {{ translate('All posts') }}
            </a>
        </div>

        {{-- Show Current category --}}

        @isset($category)
        <div class="whitespace-nowrap text-center
        inline-flex mb-4 items-center rounded-xl text-sm font-medium bg-indigo-700 text-white">
            <a class="px-3 py-2" href="{{ route('blog.category.archive', $category->slug) }}">
                {{  $category->name }}
            </a>
        </div>
        @else
            @php
                $category = new \App\Models\Category();
            @endphp
        @endif

        @php
        @endphp
        @foreach($all_categories as $cat)
            @if($cat->posts()->published()->count() > 0 && $cat->id != $category->id)
                <div class="hover:bg-indigo-700 hover:text-white whitespace-nowrap text-center
                inline-flex mb-4 items-center rounded-xl text-sm font-medium bg-gray-100 w-full text-indigo-900">
                    <a class="px-3 py-2 " href="{{ route('blog.category.archive', $cat->slug) }}">
                        {{ $cat->name }}
                    </a>
                </div>
                @endif
            @endforeach
    </div>
</section>
