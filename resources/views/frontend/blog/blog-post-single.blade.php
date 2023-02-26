@extends('frontend.layouts.app')

@section('content')
{{ Breadcrumbs::render('blog', $blog_post) }}

<!--
Install the "flowbite-typography" NPM package to apply styles and format the article content:

URL: https://flowbite.com/docs/components/typography/
-->

<main class="pb-16 lg:pb-24 bg-white dark:bg-gray-900">
    <header
        class="bg-[url('{{ $blog_post->getThumbnail() }}')] w-full h-[460px] xl:h-[537px] bg-no-repeat bg-cover bg-center bg-blend-darken relative">
        <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-50"></div>
        <div
            class="absolute top-20 left-1/2 !px-6 mx-auto w-full container -translate-x-1/2 xl:top-1/2 xl:-translate-y-1/2 xl:px-0">
            <div class="grid grid-cols-12 gap-8">
                <div class="col-span-8">
                    @isset($blog_post->categories[0])
                    <span class="block mb-4 text-gray-300">{{ translate('Category:') }}
                        <a href="{{ $blog_post->categories[0]->getPermalink() }}" class="font-semibold text-white hover:underline">
                            {{ $blog_post->categories[0]->name }}
                        </a>
                    </span>
                    @endisset
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
    <div
        class="shadow-lg container flex gap-8 relative z-20 justify-between p-6 -m-36 mx-4 max-w-screen-xl bg-white dark:bg-gray-800 rounded xl:-m-32 xl:p-9 xl:mx-auto">
        <article
            class="xl:w-[700px] w-full max-w-none format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
            <div class="flex flex-col lg:flex-row justify-between lg:items-center">
                <div class="flex items-center space-x-3 text-gray-500 dark:text-gray-400 text-base mb-2 lg:mb-0">
                    <span>{{ translate('By: ') }}
                        <a href="#" class="text-gray-900 dark:text-white hover:underline no-underline font-semibold">
                            {{ get_site_name() }}
                        </a></span>
                    <span class="bg-gray-300 dark:bg-gray-400 w-2 h-2 rounded-full"></span>
                    <span><time class="font-normal text-gray-500 dark:text-gray-400" pubdate class="uppercase"
                            datetime="2022-03-08" title="August 3rd, 2022">
                            {{ $blog_post->created_at }}
                        </time></span>
                </div>
                <div class="hidden">

                    <x-blog.share-buttons :item="$blog_post"></x-blog.share-buttons>
                </div>
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
            {{-- <x-blog.newsletter-form></x-blog.newsletter-form> --}}
            <div class="lg:mt-6 lg:w-80 lg:flex-none">
                <img class="h-12 w-auto" src="{{ get_site_logo() }}" alt="{{ get_site_name() }}">
                <figure class="mt-10">
                    <blockquote class="text-lg font-semibold leading-8 text-gray-900">
                        <p>
                            {{ get_tenant_setting('company_name') }}

                        </p>
                    </blockquote>
                    <p>
                        {{ get_tenant_setting('company_email') }}
                    </p>
                    <p>
                        {{ get_tenant_setting('company_address') }}, {{ get_tenant_setting('company_city') }}, {{
                        get_tenant_setting('company_country') }} <br>
                        {{ translate('Company Code') }}: {{ get_tenant_setting('company_number') }} <br>
                        {{ translate('Company VAT Code') }}: {{ get_tenant_setting('company_vat') }}

                    </p>
                    <figcaption class="mt-10 flex gap-x-6 mb-6">
                        <img src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=96&h=96&q=80"
                            alt="" class="h-12 w-12 flex-none rounded-full bg-gray-50">
                        <div>
                            <div class="text-base font-semibold text-gray-900">{{ translate('Customer Support') }}</div>
                            <div class="text-sm leading-6 text-gray-600">{{ get_tenant_setting('company_phone') }}</div>
                            {{-- TODO: Add tenant setting for opening hours --}}
                            <small>{{ get_tenant_setting('company_working_hours') }}</small>
                        </div>
                    </figcaption>

                    <div>
                        <a target="_blank" class="btn-primary w-full" href="/dashboard/">
                            {{ translate('Customer portal') }}
                        </a>
                    </div>
                </figure>
            </div>

        </aside>
    </div>
</main>

<x-blog.trending-articles></x-blog.trending-articles>
@endsection
