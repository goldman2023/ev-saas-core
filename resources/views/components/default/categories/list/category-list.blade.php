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
        <div class="grid gap-8 sm:grid-cols-6">
            @foreach ($categories as $category)
            <article>
                <a href="{{ $category->getPermalink() }}">
                    <img src="{{ $category->getThumbnail() }}" alt="" class="mb-5 w-full max-w-full rounded-lg">
                    {{-- <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/articles/wordpress/image-1.jpg"
                        class="" alt="Image 1"> --}}
                </a>
                <h3 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                    <a href="{{ $category->getPermalink() }}">
                        {{ $category->name }}
                    </a>
                </h3>
                <a href="{{ $category->getPermalink() }}"
                    class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                    {{ translate('Peržiūrėti') }}
                </a>
            </article>
            @endforeach
            <a href="{{ translate('/priekabu-gamyba') }}" type="button"
                class="relative bg-white block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <img class="mx-auto h-24 text-gray-400" loading="lazy"
                    src="https://businesspress.fra1.digitaloceanspaces.com/uploads/fff40500-0cca-4b32-8500-92dbfff35e36/1677768657_priekabu-gamyba.gif" />
                <span class="mt-2 block text-sm font-semibold text-gray-900">
                    {{ translate('Individualūs užsakymai') }}
                </span>
            </a>

        </div>
    </div>
</aside>
