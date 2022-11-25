<aside aria-label="Related articles" class="py-8 lg:py-24 bg-gray-50 dark:bg-gray-800">
    <div class="px-4 mx-auto max-w-screen-xl">
        <h2 class="mb-8 text-2xl font-bold text-gray-900 dark:text-white">
            {{ translate('Trending Articles') }}
        </h2>
        <div class="grid gap-12 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($posts as $post)
            <article class="max-w-xs">
                <a href="{{ $post->getPermalink() }}">
                    <img src="{{ $post->getThumbnail() }}"
                        class="mb-5 rounded-lg" alt="{{ $post->name }}">
                </a>
                <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                    <a href="{{ $post->getPermalink() }}">{{ $post->name }}</a>
                </h2>
                <p class="mb-4 font-light text-gray-500 dark:text-gray-400">
                    {{ $post->excerpt }}
                </p>
                <a href="#"
                    class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                    {{ Str::readDuration($post->content) }} {{ translate('min read') }}

                </a>
            </article>
            @endforeach


        </div>
    </div>
</aside>
