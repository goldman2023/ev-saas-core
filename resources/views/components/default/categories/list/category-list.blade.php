<aside aria-label="Related articles" class="py-8 bg-gray-50 lg:py-16 dark:bg-gray-900">
    <div class="px-4 mx-auto container">
        <div class="flex">
            <h2 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">
                {{ translate('Our products') }}
            </h2>
            <div class="mt-6 px-4 sm:hidden">
                <a href="{{ route('products.all') }}"
                    class="block text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                    {{ translate('Browse all categories') }}
                    <span aria-hidden="true"> &rarr;</span>
                </a>
            </div>
        </div>
        <div class="grid gap-3 sm:grid-cols-4">
            @foreach ($categories as $category)
            @if($category->products()->count() > 0)
            <article class="bg-white shadow-lg border border-3 border-gray-600 rounded-lg p-6 hover:opacity-70">
                <a href="{{ $category->getPermalink() }}">
                    <img src="{{ $category->getThumbnail() }}" alt="" class="h-36 object-contain mb-5 w-full max-w-full rounded-lg">
                    {{-- <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/articles/wordpress/image-1.jpg"
                        class="" alt="Image 1"> --}}
                </a>
                <h3 class="w-full mb-6 text-xl font-bold text-gray-900 dark:text-white">
                    <a href="{{ $category->getPermalink() }}">
                        {{ $category->name }}
                        <small class="block no-underline font-medium">
                        {{ translate('Products') }}:    ({{ $category->products()->count() }})
                       </small>
                    </a>

                </h3>
                <a href="{{ $category->getPermalink() }}"
                    class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                    {{ translate('Peržiūrėti') }}
                </a>
            </article>
            @endif
            @endforeach
            <a href="{{ translate('/priekabu-gamyba') }}" type="button"
                class="relative bg-white text-left block w-full rounded-lg border-2 border-dashed border-gray-300 p-12  hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <img class="h-36 object-contain mb-5 w-full max-w-full rounded-lg" loading="lazy"

                    src="https://businesspress.fra1.digitaloceanspaces.com/uploads/fff40500-0cca-4b32-8500-92dbfff35e36/1677768657_priekabu-gamyba.gif" />
                <span class="mt-2 block text-xl font-bold text-gray-900">
                    {{ translate('Individualūs užsakymai') }}
                </span>
            </a>

        </div>
    </div>
</aside>
