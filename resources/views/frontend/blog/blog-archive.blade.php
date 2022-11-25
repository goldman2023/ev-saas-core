@extends('frontend.layouts.app')
@section('meta_title')
@isset($category)
{{ $category->name }} | {{ get_site_name() }}
@else
{{ get_site_name() }} {{ translate('Blog') }}

@endisset
@stop

@section('meta_description')
@stop
@section('meta')
<meta property="og:title" content="{{ get_site_name() }} {{ translate('Blog') }}" />
<meta property="og:type" content="article" />
<meta property="og:url" content="{{  url()->current() }}" />
<meta property="og:locale" content="en_US" />
<meta property="og:image" content="{{ get_tenant_setting('seo_meta_image') }}" />
<meta property="og:site_name" content="{{ get_site_name() }}" />
@endsection
@section('content')
{{ Breadcrumbs::render('blog') }}
<!--
Install the "flowbite-typography" NPM package to apply styles and format the article content:

URL: https://flowbite.com/docs/components/typography/
-->



<main class="pt-8 pb-16 lg:pt-8 lg:pb-24 bg-white dark:bg-gray-900">
    <div class="flex justify-between px-4 mx-auto max-w-screen-xl mb-12">
        <div>
            <h1 class="text-4xl text-indigo-900 font-bold mb-4">{{ get_site_name() }} {{ translate('News') }} </h1>
            <p class="text-gray-800 max-w-3xl">
                {{ translate('Read latest news and updates from our team') }}
            </p>
        </div>
    </div>
    <div class="flex gap-10 justify-between px-4 mx-auto max-w-screen-xl ">

        <div class="mb-6 xl:block lg:w-52">
            <div class="sticky top-6">

                <aside aria-labelledby="categories-label">
                    <h3 id="categories-label" class="sr-only">Categories</h3>

                    <nav
                        class="p-4 mb-6 font-medium text-gray-500 rounded-lg border border-gray-200 dark:border-gray-700 dark:text-gray-400">
                        @empty($category)
                        @php
                        $category = null;
                        @endphp
                        @endempty
                        <div class="mb-6">
                            <x-blog.categories-list :category="$category"></x-blog.categories-list>

                        </div>
                        <h4 class="mb-4 text-gray-900 dark:text-white">Others</h4>
                        <ul class="space-y-4">
                            <li>
                                <a href="#"
                                    class="flex items-center hover:text-primary-600 dark:hover-text-primary-500"><svg
                                        class="mr-2 w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z">
                                        </path>
                                        <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"></path>
                                    </svg> Privacy policy</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center hover:text-primary-600 dark:hover-text-primary-500"><svg
                                        class="mr-2 w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z"
                                            clip-rule="evenodd"></path>
                                    </svg> Terms of use</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center hover:text-primary-600 dark:hover-text-primary-500"><svg
                                        class="mr-2 w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg> Contact</a>
                            </li>
                        </ul>
                    </nav>
                </aside>
                <aside>
                    <div
                        class="flex justify-center items-center mb-3 w-full h-32 bg-gray-100 rounded-lg dark:bg-gray-800">
                        <svg aria-hidden="true" class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <p class="mb-2 text-sm font-light text-gray-500 dark:text-gray-400">Students and Teachers, save up
                        to 60% on Flowbite Creative Cloud.</p>
                    <p class="text-xs font-light text-gray-400 uppercase dark:text-gray-500">Ads placeholder</p>
                </aside>
            </div>
        </div>
        <div
            class="mx-auto w-full max-w-3xl lg:max-w-3xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
            <div class="grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-2 @if($blog_posts->hasPages()) mb-8 @endif">
                @if($blog_posts->isNotEmpty())
                @foreach($blog_posts as $blog_post)
                @if($loop->first)
                <div class="col-span-2">
                    <x-tailwind-ui.blog.blog-post-card :blog-post="$blog_post" />

                </div>
                @else
                <x-tailwind-ui.blog.blog-post-card :blog-post="$blog_post" />

                @endif
                @endforeach
                @endif
            </div>

            @if($blog_posts->hasPages())
            <div class="w-full">
                {{ $blog_posts->onEachSide(3)->links('pagination::tailwind') }}
            </div>
            @endif
        </div>
        <aside class="hidden lg:block lg:w-72" aria-labelledby="sidebar-label">
            <div class="sticky top-6">
                <h3 id="sidebar-label" class="sr-only">Sidebar</h3>

                <div
                    class="p-6 mb-6 font-medium text-gray-500 rounded-lg border border-gray-200 dark:border-gray-700 dark:text-gray-400">
                    <form class="mb-6">
                        <label for="default-search"
                            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search</label>
                        <div class="relative">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="search" id="default-search"
                                class="block py-2.5 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Search..." required>
                        </div>
                    </form>
                    <h4 class="mb-6 font-bold text-gray-900 uppercase dark:text-white">Recommended topics</h4>
                    {{-- TODO Show Top Categories by post count, to increase number of links to relevant categories --}}
                    <div class="flex flex-wrap">
                        <a href="#"
                            class="bg-primary-100 text-primary-800 text-sm font-medium mr-3 px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800 mb-3">Technology</a>
                        <a href="#"
                            class="bg-primary-100 text-primary-800 text-sm font-medium mr-3 px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800 mb-3">Money</a>
                        <a href="#"
                            class="bg-primary-100 text-primary-800 text-sm font-medium mr-3 px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800 mb-3">Art</a>
                    </div>
                </div>
                <div
                    class="p-6 font-medium text-gray-500 bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                    <x-blog.newsletter-form></x-blog.newsletter-form>

                </div>
            </div>
        </aside>
    </div>
</main>

<x-blog.trending-articles></x-blog.trending-articles>
</section>

@include('components.custom.full-width-cta')

@endsection
