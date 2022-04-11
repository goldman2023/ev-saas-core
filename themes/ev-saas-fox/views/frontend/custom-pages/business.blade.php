@extends('frontend.layouts.app')

@section('content')

<div class="">

    <section class="relative bg-white overflow-hidden"
        style="background-image: url('/flex-ui-assets/elements/pattern-white.svg'); background-position: center;">
        <div class="bg-transparent">

            <div class="navbar-menu hidden fixed top-0 left-0 z-50 w-full h-full bg-coolGray-900 bg-opacity-50">
                <div class="fixed top-0 left-0 bottom-0 w-full w-4/6 max-w-xs bg-white">

                    <a class="navbar-close absolute top-5 p-4 right-3" href="#">
                        <svg width="12" height="12" viewbox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.94004 6L11.14 1.80667C11.2656 1.68113 11.3361 1.51087 11.3361 1.33333C11.3361 1.1558 11.2656 0.985537 11.14 0.860002C11.0145 0.734466 10.8442 0.66394 10.6667 0.66394C10.4892 0.66394 10.3189 0.734466 10.1934 0.860002L6.00004 5.06L1.80671 0.860002C1.68117 0.734466 1.51091 0.663941 1.33337 0.663941C1.15584 0.663941 0.985576 0.734466 0.860041 0.860002C0.734505 0.985537 0.66398 1.1558 0.66398 1.33333C0.66398 1.51087 0.734505 1.68113 0.860041 1.80667L5.06004 6L0.860041 10.1933C0.797555 10.2553 0.747959 10.329 0.714113 10.4103C0.680267 10.4915 0.662842 10.5787 0.662842 10.6667C0.662842 10.7547 0.680267 10.8418 0.714113 10.9231C0.747959 11.0043 0.797555 11.078 0.860041 11.14C0.922016 11.2025 0.99575 11.2521 1.07699 11.2859C1.15823 11.3198 1.24537 11.3372 1.33337 11.3372C1.42138 11.3372 1.50852 11.3198 1.58976 11.2859C1.671 11.2521 1.74473 11.2025 1.80671 11.14L6.00004 6.94L10.1934 11.14C10.2554 11.2025 10.3291 11.2521 10.4103 11.2859C10.4916 11.3198 10.5787 11.3372 10.6667 11.3372C10.7547 11.3372 10.8419 11.3198 10.9231 11.2859C11.0043 11.2521 11.0781 11.2025 11.14 11.14C11.2025 11.078 11.2521 11.0043 11.286 10.9231C11.3198 10.8418 11.3372 10.7547 11.3372 10.6667C11.3372 10.5787 11.3198 10.4915 11.286 10.4103C11.2521 10.329 11.2025 10.2553 11.14 10.1933L6.94004 6Z"
                                fill="#556987"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="relative pt-16 md:pt-24 pb-20 md:pb-28 lg:pb-56">
            <div class="container px-4 mx-auto">
                <div class="relative z-10 flex flex-wrap -mx-4">
                    <div class="w-full md:w-1/2 px-4 mb-12 md:mb-0">
                        <span
                            class="inline-block py-px px-2 mb-4 text-xs leading-5 text-white bg-blue-500 uppercase rounded-9xl">Header</span>
                        <h1
                            class="mb-6 text-3xl md:text-5xl lg:text-6xl leading-tight text-coolGray-900 font-bold tracking-tight">
                            FoxAsk Business</h1>
                        <p class="mb-8 text-lg md:text-xl text-coolGray-500 font-medium">Unlock your business potential
                            with FoxAsk solutions for consultants, coaches and education industry</p>
                        <div class="flex flex-wrap mb-8 md:mb-16">
                            <div class="w-full md:w-auto py-1 md:py-0 md:mr-4"><a
                                    class="inline-block py-5 px-7 w-full text-base md:text-lg leading-4 text-blue-50 font-medium text-center bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm"
                                    target="_blank  "
                                    href="https://demo.foxask.com">
                                    {{ translate('Request a Demo') }}
                                </a></div>
                            <div class="w-full md:w-auto py-1 md:py-0"><a
                                    class="inline-block py-5 px-7 w-full text-base md:text-lg leading-4 text-coolGray-800 font-medium text-center bg-white hover:bg-coolGray-100 focus:ring-2 focus:ring-coolGray-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    href="#">Sign Up</a></div>
                        </div>
                        <p class="mb-6 md:mb-4 text-sm text-coolGray-400 font-medium text-center md:text-left">Trusted
                            by brands all around the world</p>
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full md:w-auto px-3 mb-6 lg:mb-0">
                                <img class="mx-auto" src="flex-ui-assets/brands/welytics-light.svg" alt="">
                            </div>
                            <div class="w-full md:w-auto px-3 mb-6 lg:mb-0">
                                <img class="mx-auto" src="flex-ui-assets/brands/jiggle-light.svg" alt="">
                            </div>
                            <div class="w-full md:w-auto px-3 mb-6 lg:mb-0">
                                <img class="mx-auto" src="flex-ui-assets/brands/wishelp-light.svg" alt="">
                            </div>
                            <div class="w-full md:w-auto px-3">
                                <img class="mx-auto" src="flex-ui-assets/brands/resecurb-light.svg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:hidden px-4">
                        <div class="relative max-w-max mx-auto">
                            <img class="absolute p-1 ml-11 top-1 left-0 z-10 h-52 object-cover"
                                src="flex-ui-assets/elements/dashboard.png">
                            <img class="h-56 mx-auto object-cover" src="flex-ui-assets/images/headers/mockup-light1.png"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="md:absolute md:-right-80 md:top-1/2 md:transform md:-translate-y-1/2 md:translate-x-64 lg:translate-x-32 xl:-translate-x-7 md:mt-12 hidden md:block">
                <img class="absolute left-12 top-1/2 transform -translate-y-64"
                    src="flex-ui-assets/elements/circle4-violet.svg" alt="">
                <img class="relative z-10" src="flex-ui-assets/images/headers/mockup-light2.png" alt="">
                <img class="absolute z-20 top-6 left-36 transform translate-x-4"
                    src="flex-ui-assets/elements/dashboard.png">
            </div>
        </div>
    </section>

    <section class="py-24 bg-white overflow-hidden"
        style="background-image: url('flex-ui-assets/elements/pattern-white.svg'); background-position: center;">
        <div class="container px-4 mx-auto">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full md:w-1/2 px-4 mb-16 md:mb-0">
                    <div class="relative mx-auto md:ml-0 max-w-max">
                        <img class="absolute z-10 -right-8 -top-8 w-28 md:w-auto"
                            src="flex-ui-assets/elements/circle3-violet.svg" alt="">
                        <img class="absolute z-10 -left-10 -bottom-8 w-28 md:w-auto"
                            src="flex-ui-assets/elements/dots3-red.svg" alt="">
                        <img src="flex-ui-assets/images/how-it-works/stock.png" alt="">
                    </div>
                </div>
                <div class="w-full md:w-1/2 px-4">
                    <span
                        class="inline-block py-px px-2 mb-4 text-xs leading-5 text-blue-500 bg-blue-100 font-medium uppercase rounded-full shadow-sm">How
                        it works</span>
                    <h2 class="mb-12 text-4xl md:text-5xl leading-tight font-bold tracking-tighter">Gain more insight
                        into how people use your</h2>
                    <div class="flex flex-wrap -mx-4 text-center md:text-left">
                        <div class="w-full md:w-1/2 px-4 mb-8">
                            <div
                                class="inline-flex items-center justify-center mb-4 w-12 h-12 text-xl text-white bg-blue-500 font-semibold rounded-full">
                                1</div>
                            <h3 class="mb-2 text-xl font-bold">Custom analytics</h3>
                            <p class="font-medium text-coolGray-500">Get a complete sales dashboard in the cloud. See
                                activity, revenue and social metrics all in one place.</p>
                        </div>
                        <div class="w-full md:w-1/2 px-4 mb-8">
                            <div
                                class="inline-flex items-center justify-center mb-4 w-12 h-12 text-xl text-white bg-blue-500 font-semibold rounded-full">
                                2</div>
                            <h3 class="mb-2 text-xl font-bold">Team Management</h3>
                            <p class="font-medium text-coolGray-500">Our calendar lets you know what is happening with
                                customer and projects so you are able to control process.</p>
                        </div>
                        <div class="w-full md:w-1/2 px-4 mb-8">
                            <div
                                class="inline-flex items-center justify-center mb-4 w-12 h-12 text-xl text-white bg-blue-500 font-semibold rounded-full">
                                3</div>
                            <h3 class="mb-2 text-xl font-bold">Easy setup</h3>
                            <p class="font-medium text-coolGray-500">End to End Business Platform, Sales Management,
                                Marketing Automation, Help Desk and many more</p>
                        </div>
                        <div class="w-full md:w-1/2 px-4">
                            <div
                                class="inline-flex items-center justify-center mb-4 w-12 h-12 text-xl text-white bg-blue-500 font-semibold rounded-full">
                                4</div>
                            <h3 class="mb-2 text-xl font-bold">Build your website</h3>
                            <p class="font-medium text-coolGray-500">A tool that lets you build a dream website even if
                                you know nothing about web design or programming.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 xl:py-24 bg-white"
        style="background-image: url('flex-ui-assets/elements/pattern-white.svg'); background-position: center;">
        <div class="container px-4 mx-auto">
            <div class="text-center">
                <span
                    class="inline-block py-px px-2 mb-4 text-xs leading-5 text-blue-500 bg-blue-100 font-medium uppercase rounded-9xl">FoxAsk
                    PRO PRICING</span>
                <h3 class="mb-6 text-3xl md:text-5xl text-coolGray-900 font-bold tracking-tighter">Choose FoxAsk be
                    smart!</h3>
                <div class="flex items-center justify-center w-full mb-12">
                    <a class="inline-block mr-4 text-lg md:text-xl text-coolGray-400 font-medium" href="#">Billed
                        Monthly</a>
                    <label class="flex items-center cursor-pointer rounded-full shadow-lg" for="toggle">
                        <div class="relative">
                            <input class="sr-only" id="toggleB" type="checkbox">
                            <div class="block bg-blue-500 w-20 h-9 rounded-full"></div>
                            <div class="dot absolute right-1 top-1 bg-white w-7 h-7 rounded-full shadow-lg"></div>
                        </div>
                    </label>
                    <a class="inline-block ml-4 text-lg md:text-xl text-coolGray-800 font-medium" href="#">Billed
                        Annually</a>
                </div>
            </div>
            <div class="flex flex-wrap justify-center -mx-4">
                <div class="w-full md:w-1/2 lg:w-1/3 p-4">
                    <div
                        class="flex flex-col pt-8 pb-8 h-full bg-coolGray-50 rounded-md shadow-md hover:scale-105 transition duration-500">
                        <div class="px-8 text-center">
                            <h3 class="mb-2 text-3xl md:text-4xl text-coolGray-800 font-semibold tracking-tighter">Free
                            </h3>
                            <p class="mb-6 text-coolGray-400 font-medium">For Individual Users</p>
                            <div class="mb-6">
                                <span class="relative -top-10 right-1 text-3xl text-coolGray-900 font-bold">€</span>
                                <span
                                    class="text-6xl md:text-7xl text-coolGray-900 font-semibold tracking-tighter">10</span>
                                <span class="inline-block ml-1 text-coolGray-500 font-semibold">/forever</span>
                            </div>
                            <a class="inline-block py-4 px-7 mb-8 w-full text-base md:text-lg leading-6 text-blue-50 font-medium text-center bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm"
                                href="#">Get Started Now</a>
                        </div>
                        <ul class="self-start px-8">
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Unlimited products</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Personal verified profile</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Access to FoxAsk Social Marketplace</span>
                            </li>
                            <li class="flex items-center text-coolGray-500 font-medium">
                                <img class="mr-3" src="flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Sell Digital and Physical products</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 p-4">
                    <div
                        class="flex flex-col pt-8 pb-8 h-full bg-coolGray-50 rounded-md shadow-md hover:scale-105 transition duration-500">
                        <div class="px-8 text-center">
                            <h3 class="mb-2 text-3xl md:text-4xl text-coolGray-800 font-semibold tracking-tighter">Pro
                            </h3>
                            <p class="mb-6 text-coolGray-400 font-medium">For individuals</p>
                            <div class="mb-6">
                                <span class="relative -top-10 right-1 text-3xl text-coolGray-900 font-bold">€</span>
                                <span
                                    class="text-6xl md:text-7xl text-coolGray-900 font-semibold tracking-tighter">99</span>
                                <span class="inline-block ml-1 text-coolGray-500 font-semibold">/mo</span>
                            </div>
                            <a class="inline-block py-4 px-7 mb-8 w-full text-base md:text-lg leading-6 text-blue-50 font-medium text-center bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm"
                                href="#">Get Started Now</a>
                        </div>
                        <ul class="self-start px-8">
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Custom payment options</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Meetings Booking (Calendly integration)</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Manage leads and subscribers</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Boosted performance and engagement</span>
                            </li>
                            <li class="flex items-center text-coolGray-500 font-medium">
                                <img class="mr-3" src="flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Social Commerce Integration (Facebook + Instagram)</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 p-4">
                    <div
                        class="flex flex-col pt-8 pb-8 h-full bg-coolGray-50 rounded-md shadow-md hover:scale-105 transition duration-500">
                        <div class="px-8 text-center">
                            <h3 class="mb-2 text-3xl md:text-4xl text-coolGray-800 font-semibold tracking-tighter">
                                Business</h3>
                            <p class="mb-6 text-coolGray-400 font-medium">For Business and Education institutions</p>
                            <div class="mb-6">
                                <span class="relative -top-10 right-1 text-3xl text-coolGray-900 font-bold">€</span>
                                <span
                                    class="text-6xl md:text-7xl text-coolGray-900 font-semibold tracking-tighter">799</span>
                                <span class="inline-block ml-1 text-coolGray-500 font-semibold">/mo</span>
                            </div>
                            <a class="inline-block py-4 px-7 mb-8 w-full text-base md:text-lg leading-6 text-blue-50 font-medium text-center bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm"
                                href="#">Get Started Now</a>
                        </div>
                        <ul class="self-start px-8">
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>White-Label EShop</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Multiple Social-Commerce Channels</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Product and Data migration</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>12 hrs SLA TIME</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Advanced bookings</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Sell Courses</span>
                            </li>
                            <li class="flex items-center text-coolGray-500 font-medium">
                                <img class="mr-3" src="flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Manage Students and Customers</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



@endsection
