@extends('frontend.layouts.app')

@section('content')

<div class="bg-gray-200">

    <section class="relative bg-gray-200 overflow-hidden"
        style="background-image: url('/flex-ui-assets/elements/pattern-white.svg'); background-position: center;">
        <div class="bg-transparent">


        </div>
        <div class="relative pt-16 md:pt-24 pb-20 md:pb-28 lg:pb-56">
            <div class="container px-4 mx-auto">
                <div class="relative z-10 flex flex-wrap -mx-4">
                    <div class="w-full md:w-1/2 px-4 mb-12 md:mb-0">
                        <span
                            class="inline-block py-px px-3 mb-4 text-xs leading-5 text-white bg-purple-600 uppercase rounded-3xl">
                           {{ translate('Join') }} {{  get_site_name() }} {{ translate('Business') }}
                        </span>
                        <h1
                            class="mb-6 text-3xl md:text-5xl lg:text-6xl leading-tight text-coolGray-900 font-bold tracking-tight">
                            FoxAsk Business</h1>
                        <p class="mb-8 text-lg md:text-xl text-coolGray-500 font-medium">Unlock your business potential
                            with FoxAsk solutions for consultants, coaches and education industry</p>
                        <div class="flex flex-wrap mb-8 md:mb-16">
                            <div class="w-full md:w-auto py-1 md:py-0 md:mr-4"><a
                                    class="inline-block py-5 px-7 w-full text-base md:text-lg leading-4 text-blue-50 font-medium text-center bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm"
                                    target="_blank  " href="https://demo.foxask.com">
                                    {{ translate('Request a Demo') }}
                                </a></div>
                            <div class="w-full md:w-auto py-1 md:py-0"><a
                                    class="inline-block py-5 px-7 w-full text-base md:text-lg leading-4 text-coolGray-800 font-medium text-center bg-white hover:bg-coolGray-100 focus:ring-2 focus:ring-coolGray-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    href="#pricing">
                                    {{ translate('Pricing & Features') }}
                                </a></div>
                        </div>
                        <p class="mb-6 md:mb-4 text-sm text-coolGray-400 font-medium text-center md:text-left">
                            Used
                            by brands all around the world</p>
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full md:w-auto px-3 mb-6 lg:mb-0">
                                <a href="https://eim.academy" target="_blank">
                                    <img class="mx-auto h-6"
                                        src="https://www.eim.academy/wp-content/uploads/2021/07/eimacademy-logos_black-e1627349764656.png"
                                        alt="">
                                </a>
                            </div>
                            <div class="w-full md:w-auto px-3 mb-6 lg:mb-0">
                                <a href="https://motherk.lt" target="_blank">
                                <img class="mx-auto h-6" src="https://www.motherk.eu/wp-content/uploads/2018/02/logo.gif" alt="">
                                </a>
                            </div>
                            <div class="w-full md:w-auto px-3 mb-6 lg:mb-0">
                                <a href="https://autodita.lt" target="_blank">

                                <img class="mx-auto h-6" src="https://autodita.lt/images/autodita-adbiggest718-2.png" alt="">
                                </a>
                            </div>
                            <div class="w-full md:w-auto px-3">
                                <img class="mx-auto" src="/flex-ui-assets/brands/resecurb-light.svg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:hidden px-4">
                        <div class="relative max-w-max mx-auto">
                            <img class="absolute p-1 ml-11 top-1 left-0 z-10 h-52 object-cover"
                                src="https://ev-saas.fra1.digitaloceanspaces.com/uploads/c71c779f-d325-4175-8b55-7d31b6f21257/1649656340_Screenshot%202022-04-11%20at%2008.50.38.png">
                            <img class="hidden h-56 mx-auto object-cover"
                                src="/flex-ui-assets/images/headers/mockup-light1.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="md:absolute md:-right-80 md:top-1/2 md:transform md:-translate-y-1/2 md:translate-x-64 lg:translate-x-32 xl:-translate-x-7 md:mt-12 hidden md:block">
                <img class="absolute left-12 top-1/2 transform -translate-y-64"
                    src="/flex-ui-assets/elements/circle4-violet.svg" alt="">
                <img class="relative z-10" src="/flex-ui-assets/images/headers/mockup-light2.png" alt="">
                <img class="absolute z-20 top-6 left-36 transform translate-x-4 max-h-[460px]"
                    src="https://ev-saas.fra1.digitaloceanspaces.com/uploads/c71c779f-d325-4175-8b55-7d31b6f21257/1649656340_Screenshot%202022-04-11%20at%2008.50.38.png">
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
                            src="/flex-ui-assets/elements/circle3-violet.svg" alt="">
                        <img class="absolute z-10 -left-10 -bottom-8 w-28 md:w-auto"
                            src="/flex-ui-assets/elements/dots3-red.svg" alt="">
                        <img src="/flex-ui-assets/images/how-it-works/stock.png" alt="">
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

    <section class="py-20 xl:py-24 bg-gray-200" id="pricing"
        style="background-image: url('flex-ui-assets/elements/pattern-white.svg'); background-position: center;">
        <div class="container px-4 mx-auto">
            <div class="text-center">
                <span
                    class="inline-block py-px px-2 mb-4 text-xs leading-5 text-blue-500 bg-blue-100 font-medium uppercase rounded-9xl">FoxAsk
                    PRO PRICING</span>
                <h3 class="mb-6 text-3xl md:text-5xl text-coolGray-900 font-bold tracking-tighter">Choose FoxAsk be
                    smart!</h3>
                <div class="hidden flex items-center justify-center w-full mb-12">
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
                        class="bg-white flex flex-col pt-8 pb-8 h-full bg-coolGray-50 rounded-md shadow-md hover:scale-105 transition duration-500">
                        <div class="px-8 text-center">
                            <h3 class="mb-2 text-3xl md:text-4xl text-coolGray-800 font-semibold tracking-tighter">Free
                            </h3>
                            <p class="mb-6 text-coolGray-400 font-medium">For Individual Users</p>
                            <div class="mb-6">
                                <span class="relative -top-10 right-1 text-3xl text-coolGray-900 font-bold">€</span>
                                <span
                                    class="text-6xl md:text-7xl text-coolGray-900 font-semibold tracking-tighter">0</span>
                                <span class="inline-block ml-1 text-coolGray-500 font-semibold">/forever</span>
                            </div>
                            @auth
                            <a class="inline-block py-4 px-7 mb-8 w-full text-base md:text-lg leading-6 text-blue-50 font-medium text-center bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm"
                                href="{{ route('dashboard') }}">
                                {{ translate('Already a member') }}
                            </a>
                            {{ translate('Go to dashboard') }}
                            @else
                            <a class="inline-block py-4 px-7 mb-8 w-full text-base md:text-lg leading-6 text-blue-50 font-medium text-center bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm"
                                href="{{ route('user.registration') }}">
                                {{ translate('Register now!') }}
                            </a>
                            @endauth

                        </div>
                        <ul class="self-start px-8">
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="/flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Unlimited products</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="/flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Personal verified profile</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="/flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Access to FoxAsk Social Marketplace</span>
                            </li>
                            <li class="flex items-center text-coolGray-500 font-medium">
                                <img class="mr-3" src="/flex-ui-assets/elements/pricing/checkbox-blue.svg">
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
                            {{-- TODO: Make this custom --}}
                            <a class="inline-block py-4 px-7 mb-8 w-full text-base md:text-lg leading-6 text-blue-50 font-medium text-center bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm"
                                target="_blank" href="https://buy.stripe.com/4gwcMR1jPb6N8Eg9AC">
                                Get Started Now
                            </a>
                        </div>
                        <ul class="self-start px-8">
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="/flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Custom payment options</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="/flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Meetings Booking (Calendly integration)</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="/flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Manage leads and subscribers</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="/flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Boosted performance and engagement</span>
                            </li>
                            <li class="flex items-center text-coolGray-500 font-medium">
                                <img class="mr-3" src="/flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Social Commerce Integration (Facebook + Instagram)</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 p-4">
                    <div
                        class="flex bg-white flex-col pt-8 pb-8 h-full bg-coolGray-50 rounded-md shadow-md hover:scale-105 transition duration-500">
                        <div class="px-8 text-center">
                            <h3 class="mb-2 text-3xl md:text-4xl text-coolGray-800 font-semibold tracking-tighter">
                                Business</h3>
                            <p class="mb-6 text-coolGray-400 font-medium">For Business and Education institutions</p>
                            <div class="mb-6">
                                <span class="relative -top-10 right-1 text-3xl text-coolGray-900 font-bold">€</span>
                                <span
                                    class="text-6xl md:text-7xl text-coolGray-900 font-semibold tracking-tighter">250</span>
                                <span class="inline-block ml-1 text-coolGray-500 font-semibold">/mo</span>
                            </div>
                            {{-- TODOL: make this dynamic --}}
                            <a class="inline-block py-4 px-7 mb-8 w-full text-base md:text-lg leading-6 text-blue-50 font-medium text-center bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm"
                                href="https://buy.stripe.com/eVacMRd2x7UB3jW288" target="blank">
                                {{ translate('Get Started Now')}}
                            </a>
                        </div>
                        <ul class="self-start px-8">
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="/flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>White-Label EShop</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="/flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Multiple Social-Commerce Channels</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="/flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Product and Data migration</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="/flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>12 hrs SLA TIME</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="/flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Advanced bookings</span>
                            </li>
                            <li class="flex items-center mb-4 text-coolGray-500 font-medium">
                                <img class="mr-3" src="/flex-ui-assets/elements/pricing/checkbox-blue.svg">
                                <span>Sell Courses</span>
                            </li>
                            <li class="flex items-center text-coolGray-500 font-medium">
                                <img class="mr-3" src="/flex-ui-assets/elements/pricing/checkbox-blue.svg">
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
