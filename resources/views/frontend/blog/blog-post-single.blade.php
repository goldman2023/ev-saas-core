@extends('frontend.layouts.app')

@section('content')
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
                        Before going digital, you might scribbling down some ideas in a sketchbook.
                    </p>
                </div>
                <div class="col-span-4 text-right">
                    <img class="rounded mb-8" src="{{ $blog_post->getThumbnail() }}" />
                </div>
           </div>

        </div>
    </header>
    <div class="flex relative z-20 justify-between p-6 -m-36 mx-4 max-w-screen-xl bg-white dark:bg-gray-800 rounded xl:-m-32 xl:p-9 xl:mx-auto">
        <article class="xl:w-[828px] w-full max-w-none format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
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
                <aside aria-label="Share social media">
                    <div class="not-format">
                        <button data-tooltip-target="tooltip-facebook" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" viewBox="0 0 18 18" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_13676_82298)">
                                <path d="M18 9C18 4.02943 13.9706 0 9 0C4.02943 0 0 4.02943 0 9C0 13.4921 3.29115 17.2155 7.59375 17.8907V11.6016H5.30859V9H7.59375V7.01719C7.59375 4.76156 8.93742 3.51562 10.9932 3.51562C11.9776 3.51562 13.0078 3.69141 13.0078 3.69141V5.90625H11.873C10.755 5.90625 10.4062 6.60006 10.4062 7.3125V9H12.9023L12.5033 11.6016H10.4062V17.8907C14.7088 17.2155 18 13.4921 18 9Z" />
                                </g>
                                <defs>
                                <clipPath id="clip0_13676_82298">
                                <rect width="18" height="18" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </button>
                        <div id="tooltip-facebook" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                            Share on Facebook
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>

                        <button data-tooltip-target="tooltip-twitter" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" viewBox="0 0 18 18" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.66064 16.3131C12.4531 16.3131 16.1683 10.6856 16.1683 5.80539C16.1683 5.64555 16.1683 5.48643 16.1575 5.32803C16.8803 4.80525 17.5042 4.15794 18 3.41643C17.326 3.71523 16.611 3.9111 15.8789 3.99747C16.6499 3.53599 17.2269 2.81006 17.5025 1.95483C16.7776 2.38504 15.9845 2.6882 15.1574 2.85123C14.6006 2.25916 13.8642 1.86711 13.0621 1.73574C12.2601 1.60438 11.4371 1.74102 10.7205 2.12452C10.0039 2.50802 9.43367 3.11701 9.09806 3.85724C8.76245 4.59747 8.68016 5.42768 8.86392 6.21939C7.39567 6.14574 5.95932 5.76416 4.64809 5.09943C3.33686 4.4347 2.18007 3.50168 1.2528 2.36091C0.780546 3.17391 0.635904 4.13633 0.848325 5.05223C1.06075 5.96812 1.61426 6.76863 2.39616 7.29075C1.80842 7.27353 1.23349 7.11498 0.72 6.82851V6.87531C0.720233 7.72795 1.01539 8.55426 1.5554 9.21409C2.09542 9.87391 2.84705 10.3266 3.6828 10.4955C3.13911 10.6438 2.56866 10.6654 2.01528 10.5588C2.25136 11.2926 2.71082 11.9342 3.32943 12.394C3.94804 12.8539 4.69487 13.1089 5.46552 13.1235C4.69983 13.7253 3.82299 14.1703 2.88516 14.433C1.94733 14.6956 0.966911 14.7708 0 14.6542C1.68887 15.738 3.65394 16.3128 5.66064 16.3102" />
                            </svg>
                        </button>
                        <div id="tooltip-twitter" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                            Share on Twitter
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>

                        <button data-tooltip-target="tooltip-reddit" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" viewBox="0 0 18 18" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_13676_82300)">
                                <path d="M9 18C13.9706 18 18 13.9706 18 9C18 4.02944 13.9706 0 9 0C4.02944 0 0 4.02944 0 9C0 13.9706 4.02944 18 9 18Z" />
                                <path d="M15.0004 8.99997C15.0004 8.27365 14.411 7.68418 13.6846 7.68418C13.3267 7.68418 13.011 7.82102 12.7794 8.0526C11.8846 7.41049 10.6425 6.98944 9.27412 6.93681L9.87412 4.12628L11.8215 4.53681C11.8425 5.03155 12.2531 5.43155 12.7583 5.43155C13.2741 5.43155 13.6952 5.01049 13.6952 4.4947C13.6952 3.97891 13.2741 3.55786 12.7583 3.55786C12.3899 3.55786 12.0741 3.76839 11.9267 4.08418L9.7478 3.62102C9.68464 3.61049 9.62148 3.62102 9.56885 3.6526C9.51622 3.68418 9.48464 3.73681 9.46359 3.79997L8.80043 6.93681C7.40043 6.97891 6.1478 7.38944 5.24254 8.0526C5.01096 7.83155 4.68464 7.68418 4.33727 7.68418C3.61096 7.68418 3.02148 8.27365 3.02148 8.99997C3.02148 9.53681 3.33727 9.98944 3.80043 10.2C3.77938 10.3263 3.76885 10.4631 3.76885 10.6C3.76885 12.621 6.11622 14.2526 9.02149 14.2526C11.9267 14.2526 14.2741 12.621 14.2741 10.6C14.2741 10.4631 14.2636 10.3368 14.2425 10.2105C14.6741 9.99997 15.0004 9.53681 15.0004 8.99997ZM6.00043 9.93681C6.00043 9.42102 6.42148 8.99997 6.93727 8.99997C7.45306 8.99997 7.87412 9.42102 7.87412 9.93681C7.87412 10.4526 7.45306 10.8737 6.93727 10.8737C6.42148 10.8737 6.00043 10.4526 6.00043 9.93681ZM11.232 12.4105C10.5899 13.0526 9.36885 13.0947 9.01096 13.0947C8.65306 13.0947 7.42148 13.0421 6.7899 12.4105C6.69517 12.3158 6.69517 12.1579 6.7899 12.0631C6.88464 11.9684 7.04254 11.9684 7.13727 12.0631C7.53727 12.4631 8.40043 12.6105 9.02149 12.6105C9.64254 12.6105 10.4952 12.4631 10.9057 12.0631C11.0004 11.9684 11.1583 11.9684 11.2531 12.0631C11.3267 12.1684 11.3267 12.3158 11.232 12.4105ZM11.0636 10.8737C10.5478 10.8737 10.1267 10.4526 10.1267 9.93681C10.1267 9.42102 10.5478 8.99997 11.0636 8.99997C11.5794 8.99997 12.0004 9.42102 12.0004 9.93681C12.0004 10.4526 11.5794 10.8737 11.0636 10.8737Z" fill="white"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_13676_82300">
                                <rect width="18" height="18" />
                                </clipPath>
                                </defs>
                            </svg>
                        </button>
                        <div id="tooltip-reddit" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                            Post on Reddit
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>

                        <button data-tooltip-target="tooltip-link" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </button>
                        <div id="tooltip-link" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                            Share link
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>

                        <button data-tooltip-target="tooltip-save" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true"  fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                        </button>
                        <div id="tooltip-save" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                            Save this article
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                        <button id="dropdownMenuIconHorizontalButton" data-dropdown-toggle="dropdownDotsHorizontal" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownDotsHorizontal" class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconHorizontalButton">
                                <li>
                                    <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Add to collection</a>
                                </li>
                                <li>
                                    <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
           <div id="content">
            {!! $blog_post->content !!}
           </div>

        </article>
        <aside class="hidden xl:block" aria-labelledby="sidebar-label">
            <div class="xl:w-[336px] sticky top-6">
                <h3 id="sidebar-label" class="sr-only">Sidebar</h3>
                <div class="mb-8">
                    <h4 class="mb-2 text-sm font-bold text-gray-900 dark:text-white uppercase">Flowbite News morning headlines</h4>
                    <p class="mb-4 text-sm font-light text-gray-500 dark:text-gray-400">Get all the stories you need-to-know from the most powerful name in news delivered first thing every morning to your inbox</p>
                    <button type="button" data-modal-toggle="newsletter-modal" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 text-center w-full">Subscribe</button>
                </div>
                <div class="mb-12">
                    <h4 class="mb-4 text-sm font-bold text-gray-900 dark:text-white uppercase">Latest news</h4>
                    <div class="mb-6 flex items-center">
                        <a href="#" class="shrink-0">
                            <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/articles/image-1.png" class="mr-4 max-w-full w-24 h-24 rounded-lg" alt="Image 1">
                        </a>
                        <div>
                            <h5 class="mb-2 text-lg font-bold leading-tight dark:text-white text-gray-900">Our first office</h5>
                            <p class="mb-2 font-light text-gray-500 dark:text-gray-400">Over the past year, Volosoft has undergone changes.</p>
                            <a href="#" class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                                Read in 9 minutes
                            </a>
                        </div>
                    </div>
                    <div class="mb-6 flex items-center">
                        <a href="#" class="shrink-0">
                            <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/articles/image-2.png" class="mr-4 max-w-full w-24 h-24 rounded-lg" alt="Image 2">
                        </a>
                        <div>
                            <h5 class="mb-2 text-lg font-bold leading-tight dark:text-white text-gray-900">Enterprise Design tips</h5>
                            <p class="mb-2 font-light text-gray-500 dark:text-gray-400">Over the past year, Volosoft has undergone changes.</p>
                            <a href="#" class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                                Read in 14 minutes
                            </a>
                        </div>
                    </div>
                    <div class="mb-6 flex items-center">
                        <a href="#" class="shrink-0">
                            <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/articles/image-3.png" class="mr-4 max-w-full w-24 h-24 rounded-lg" alt="Image 3">
                        </a>
                        <div>
                            <h5 class="mb-2 text-lg font-bold leading-tight dark:text-white text-gray-900">Partnered up with Google</h5>
                            <p class="mb-2 font-light text-gray-500 dark:text-gray-400">Over the past year, Volosoft has undergone changes.</p>
                            <a href="#" class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                                Read in 9 minutes
                            </a>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="#" class="flex justify-center items-center mb-3 w-full h-48 bg-gray-100 rounded-lg dark:bg-gray-700">
                        <svg aria-hidden="true" class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
                    </a>
                    <p class="mb-2 text-sm font-light text-gray-500 dark:text-gray-400">Students and Teachers, save up to 60% on Flowbite Creative Cloud.</p>
                    <p class="text-xs font-light text-gray-400 uppercase dark:text-gray-500">Ads placeholder</p>
                </div>
            </div>
        </aside>
    </div>
  </main>

  <aside aria-label="Related articles" class="py-8 lg:py-24 bg-white dark:bg-gray-900">
    <div class="px-4 mx-auto max-w-screen-xl">
        <h2 class="mb-6 lg:mb-8 text-2xl font-bold text-gray-900 dark:text-white">Related articles</h2>
        <div class="grid gap-6 lg:gap-12 md:grid-cols-2">
            @if($related_blog_posts->isNotEmpty())
            @foreach($related_blog_posts as $blog_post)
            <article class="flex flex-col xl:flex-row">
                <a href="#" class="mb-2 xl:mb-0">
                    <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-1.png" class="mr-5 max-w-sm" alt="Image 1">
                </a>
                <div class="flex flex-col justify-center">
                    <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                        <a href="#">Our first office</a>
                    </h2>
                    <p class="mb-4 font-light text-gray-500 dark:text-gray-400 max-w-sm">Over the past year, Volosoft has undergone many changes! After months of preparation.</p>
                    <a href="#" class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                        Read in 2 minutes
                    </a>
                </div>
            </article>
            @endforeach
            @endif


        </div>
    </div>
  </aside>



  <div id="newsletter-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-2xl h-full rounded-lg md:h-auto">
        <!-- Modal content -->
        <div class="flex relative items-center bg-white rounded-lg shadow dark:bg-gray-800">
            <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/newsletter/people-at-office.png" class="hidden h-64 rounded-l-lg md:flex" alt="office">
            <div>
                <button type="button" data-modal-toggle="newsletter-modal" class="text-gray-400 absolute top-3 right-3 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <!-- Modal body -->
                <div class="p-6 pt-4">
                    <h3 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                        Join our Newsletter
                    </h3>
                    <p class="mb-4 text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        Get started with our monthly newsletter for helpful tips on how to run your business smoothly.
                    </p>
                    <form action="#">
                        <div class="items-center mx-auto space-y-4 max-w-screen-sm sm:flex sm:space-y-0">
                            <div class="relative mr-3 w-full">
                                <label for="email" class="hidden mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Email address</label>
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                                </div>
                                <input class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Your email" type="email" id="email" required="">
                            </div>
                            <div>
                                <button type="submit" class="py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg cursor-pointer bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Subscribe</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
