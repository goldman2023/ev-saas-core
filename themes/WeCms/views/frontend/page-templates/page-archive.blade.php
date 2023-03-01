@php
    $pages = \App\Models\Page::published()->get();
@endphp
<aside aria-label="Related articles" class="bg-white dark:bg-gray-900 py-8 lg:py-12">
    <div class="px-4 mx-auto max-w-screen-xl">
        <h1 class="mb-6 lg:mb-8 text-4xl font-bold text-gray-900 dark:text-white">
            {{ translate('All pages') }}
        </h1>
        <div class="grid gap-6 lg:gap-12 md:grid-cols-2">
           @foreach($pages as $page)
            <article class="flex flex-col xl:flex-row">
                <a href="{{ $page->getPermalink() }}" class="mb-2 xl:mb-0">
                    <img src="{{ $page->getThumbnail() }}" class="mr-5 max-w-xs" alt="{{ $page->name }}">
                </a>
                <div class="flex flex-col justify-center">
                    <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                        <a href="{{  $page->getPermalink() }}">
                            {{ $page->name }}
                        </a>
                    </h2>
                    <p class="mb-4 font-light text-gray-500 dark:text-gray-400 max-w-sm">
                        {{ $page->meta_description }}
                    </p>
                    <a href="{{  $page->getPermalink() }}" class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                        {{ translate('Learn more') }}
                    </a>
                </div>
            </article>
            @endforeach

        </div>
    </div>
  </aside>
