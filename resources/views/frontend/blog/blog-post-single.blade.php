@extends('frontend.layouts.app')

@section('content')
{{ Breadcrumbs::render('blog', $blog_post) }}

<!--
Install the "flowbite-typography" NPM package to apply styles and format the article content:

URL: https://flowbite.com/docs/components/typography/
-->

<main class="pb-16 lg:pb-24 bg-white dark:bg-gray-900">
    <header class="bg-[url('{{ $blog_post->getThumbnail() }}')] w-full h-[460px] xl:h-[537px] bg-no-repeat bg-cover bg-center bg-blend-darken relative">
        <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-50"></div>
        <div class="absolute top-20 left-1/2 px-4 mx-auto w-full max-w-screen-xl -translate-x-1/2 xl:top-1/2 xl:-translate-y-1/2 xl:px-0">
           <div class="grid grid-cols-12 gap-8">
                <div class="col-span-8">
                    <span class="block mb-4 text-gray-300">Published in <a href="#" class="font-semibold text-white hover:underline">World News</a></span>
                    <h1 class="mb-4 max-w-4xl text-2xl font-extrabold leading-none text-white sm:text-3xl lg:text-4xl">
                        {{ $blog_post->name }}
                    </h1>
                    <p class="text-lg font-normal text-gray-300">
                        {{ $blog_post->excerpt }}
                    </p>
                </div>
                <div class="col-span-4 text-right">
                    <img class="rounded mb-8" src="{{ $blog_post->getThumbnail() }}" />
                </div>
           </div>

        </div>
    </header>
    <div class="flex gap-8 relative z-20 justify-between p-6 -m-36 mx-4 max-w-screen-xl bg-white dark:bg-gray-800 rounded xl:-m-32 xl:p-9 xl:mx-auto">
        <article class="xl:w-[700px] w-full max-w-none format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
            <div class="flex flex-col lg:flex-row justify-between lg:items-center">
                <div class="flex items-center space-x-3 text-gray-500 dark:text-gray-400 text-base mb-2 lg:mb-0">
                    <span>By
                        <a href="#" class="text-gray-900 dark:text-white hover:underline no-underline font-semibold">
                        {{ get_site_name() }}
                    </a></span>
                    <span class="bg-gray-300 dark:bg-gray-400 w-2 h-2 rounded-full"></span>
                    <span><time class="font-normal text-gray-500 dark:text-gray-400" pubdate class="uppercase" datetime="2022-03-08" title="August 3rd, 2022">
                        {{ $blog_post->created_at }}
                    </time></span>
                </div>
                <x-blog.share-buttons :item="$blog_post"></x-blog.share-buttons>
            </div>
           <div id="blog_post_single_content">
            {{-- {!! $blog_post->content !!} --}}
            {!! $html !!}
           </div>
           <footer>
            <div class="mt-8">
                <hr class="mb-8">
                <livewire:actions.social-comments :item="$blog_post" />

            </div>
           </footer>

        </article>
        <aside class="hidden sm:block" aria-labelledby="sidebar-label">
            <x-blog.newsletter-form></x-blog.newsletter-form>


        </aside>
    </div>
  </main>

  <x-blog.trending-articles></x-blog.trending-articles>





@endsection
